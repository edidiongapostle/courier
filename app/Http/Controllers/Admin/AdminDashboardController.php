<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Shipment;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $userCount = User::count();
        $blockedCount = User::where('is_blocked', true)->count();
        $pendingShipments = Shipment::where('approved', false)->count();
        $totalShipments = Shipment::count();
        $recentShipments = Shipment::with('user')->orderByDesc('created_at')->take(5)->get();
        return view('admin.dashboard', compact('userCount', 'blockedCount', 'pendingShipments', 'totalShipments', 'recentShipments'));
    }

    // Admin: List all users
    public function users()
    {
        $users = \App\Models\User::orderByDesc('created_at')->paginate(20);
        return view('admin.users.all', compact('users'));
    }

    // Admin: Block a user
    public function blockUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_blocked = true;
        $user->save();
        return back()->with('status', 'User blocked successfully.');
    }

    // Admin: Unblock a user
    public function unblockUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();
        return back()->with('status', 'User unblocked successfully.');
    }

    // Admin: Verify a user
    public function verifyUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_verified = true;
        $user->save();
        return back()->with('status', 'User verified successfully.');
    }

    // Admin: Delete a user
    public function deleteUser($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return back()->with('status', 'User deleted successfully.');
    }
} 