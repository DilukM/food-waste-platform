<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Request as RequestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display the user's requests.
     */
    public function index()
    {
        $requests = Auth::user()->requests()
            ->with(['donation.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('requests.index', compact('requests'));
    }

    /**
     * Store a new request for a donation.
     */
    public function store(Request $request, Donation $donation)
    {
        // Check if the user has recipient role
        if (!Auth::user()->canReceive()) {
            return back()->with('error', 'Only recipients can request donations. Please update your profile role.');
        }

        // First, we validate that the authenticated user is not the donor.
        // This is a crucial piece of business logic.
        if ($donation->user_id === Auth::id()) {
            return back()->with('error', 'You cannot request your own donation.');
        }

        // We also check if the donation is still available.
        if ($donation->status !== 'available') {
            return back()->with('error', 'This donation is no longer available.');
        }

        // Check if user has already requested this donation
        $existingRequest = Auth::user()->requests()
            ->where('donation_id', $donation->id)
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You have already requested this donation.');
        }

        // Check if this is the first request for this donation
        $existingRequests = $donation->requests()->count();
        $isFirstRequest = $existingRequests === 0;

        // Create the new request in the database.
        // If this is the first request, automatically claim it; otherwise make it pending
        Auth::user()->requests()->create([
            'donation_id' => $donation->id,
            'message' => $request->input('message'),
            'status' => $isFirstRequest ? 'claimed' : 'pending',
        ]);

        // Update the donation status to claimed (first requester gets it automatically)
        $donation->update(['status' => 'claimed']);

        $successMessage = $isFirstRequest
            ? 'Congratulations! You got the donation! It has been automatically claimed for you.'
            : 'Your request has been submitted and is pending approval.';

        return redirect()->route('my-requests')->with('status', $successMessage);
    }

    /**
     * Update the status of a request (for donors)
     */
    public function updateStatus(Request $request, RequestModel $donationRequest)
    {
        // Only the donation owner can update request status
        if ($donationRequest->donation->user_id !== Auth::id()) {
            return back()->with('error', 'You can only manage requests for your own donations.');
        }

        $donationRequest->update([
            'status' => $request->status
        ]);

        // If approved, mark donation as completed
        if ($request->status === 'approved') {
            $donationRequest->donation->update(['status' => 'completed']);
        } elseif ($request->status === 'rejected') {
            $donationRequest->donation->update(['status' => 'available']);
        }

        return back()->with('status', 'Request status updated successfully!');
    }
}
