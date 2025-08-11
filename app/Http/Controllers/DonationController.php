<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DonationController extends Controller
{
    /**
     * Show the form for creating a new donation.
     */
    public function create()
    {
        // Check if user can donate
        if (!Auth::user()->canDonate()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Only donors can create donations.');
        }

        return view('donations.create');
    }

    /**
     * Store a newly created donation in the database.
     */
    public function store(Request $request)
    {
        // Check if user can donate
        if (!Auth::user()->canDonate()) {
            return redirect()->route('dashboard')->with('error', 'Only donors can create donations. Please update your profile role.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'expires_at' => 'required|date|after:now',
        ]);

        // Create the donation and associate it with the logged-in user
        Auth::user()->donations()->create($validated);

        return redirect()->route('donations.manage')->with('status', 'Donation created successfully!');
    }

    public function index()
    {
        $donations = Donation::with('user')
            ->where('status', 'available')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('donations.index', compact('donations'));
    }

    public function show(Donation $donation)
    {
        // The Donation model is automatically resolved by Laravel
        // We can pass it directly to the view.
        return view('donations.show', compact('donation'));
    }

    public function edit(Donation $donation)
    {
        // First, authorize the user. We need to make sure
        // only the donor can manage this donation.
        if ($donation->user_id !== Auth::id()) {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to manage this donation.');
        }

        // We can load the requests for this donation using our relationship.
        $donation->load('requests.user');

        return view('donations.edit', compact('donation'));
    }

    /**
     * Show the donor's donation management dashboard
     */
    public function manage()
    {
        // Check if user can donate
        if (!Auth::user()->canDonate()) {
            return redirect()->route('dashboard')->with('error', 'Access denied. Only donors can manage donations.');
        }

        $donations = Auth::user()->donations()
            ->with(['requests.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('donations.manage', compact('donations'));
    }

    public function update(Request $request, Donation $donation)
    {
        // Authorize the user
        if ($donation->user_id !== Auth::id()) {
            return redirect()->route('donations.manage')->with('error', 'Unauthorized action.');
        }

        // Prevent editing if donation is claimed or later
        if (in_array($donation->status, ['claimed', 'delivered', 'completed'])) {
            return redirect()->route('donations.edit', $donation)->with('error', 'Cannot edit donation that has been ' . $donation->status . '.');
        }

        // Check if this is a status-only update (form only has _token, _method, and status)
        $requestFields = collect($request->all())->except(['_token', '_method'])->keys();
        if ($requestFields->count() === 1 && $requestFields->first() === 'status') {
            $validated = $request->validate([
                'status' => 'required|in:available,claimed,delivered,completed',
            ]);
        } else {
            // Full donation update (would be from a complete edit form)
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|string',
                'quantity' => 'required|integer|min:1',
                'location' => 'required|string|max:255',
                'expires_at' => 'required|date|after:now',
                'status' => 'sometimes|in:available,claimed,delivered,completed',
            ]);
        }

        $donation->update($validated);

        return redirect()->route('donations.manage')->with('status', 'Donation updated successfully!');
    }
    /**
     * Remove the specified donation from storage.
     */
    public function destroy(Donation $donation)
    {
        // Authorize the user
        if ($donation->user_id !== Auth::id()) {
            return redirect()->route('donations.manage')->with('error', 'Unauthorized action.');
        }

        // Prevent deleting if donation is claimed or later
        if (in_array($donation->status, ['claimed', 'delivered', 'completed'])) {
            return redirect()->route('donations.manage')->with('error', 'Cannot delete donation that has been ' . $donation->status . '.');
        }

        // Check if donation has pending requests
        if ($donation->requests()->where('status', 'pending')->exists()) {
            return redirect()->route('donations.manage')->with('error', 'Cannot delete donation with pending requests.');
        }

        $donation->delete();

        return redirect()->route('donations.manage')->with('status', 'Donation deleted successfully!');
    }
}
