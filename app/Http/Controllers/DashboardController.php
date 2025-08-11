<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
 
class DashboardController extends Controller
{
    /**
     * Display the user's dashboard based on their role.
     */
    public function __invoke(Request $request): View|RedirectResponse
    {
        $user = Auth::user();

        // Redirect donors to their donation management page
        if ($user->canDonate() && !$user->canReceive()) {
            return redirect()->route('donations.manage');
        }

        // Redirect recipients to their requests page
        if ($user->canReceive() && !$user->canDonate()) {
            return redirect()->route('my-requests');
        }

        // Only users with "both" role should see the dashboard
        // Prepare data for users with both roles
        $data = [
            'user' => $user,
            'donations' => collect(),
            'requests' => collect(),
            'received_requests' => collect(),
        ];

        // Get their donations (since they can donate)
        $data['donations'] = $user->donations()
            ->orderBy('created_at', 'desc')
            ->get();

        // Get requests for their donations
        $data['received_requests'] = \App\Models\Request::whereHas('donation', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with(['user', 'donation'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get their requests (since they can receive)
        $data['requests'] = $user->requests()
            ->with(['donation.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', $data);
    }
}
