<?php

namespace App\Http\Controllers;

use App\Models\DateModification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = DateModification::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(DateModification $notification)
    {
        $notification->update(['read' => true]);
        return back()->with('success', 'Notification marked as read');
    }
}