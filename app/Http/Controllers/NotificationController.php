<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the notifications.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get custom notifications
        $customNotifications = $user->customNotifications()->latest()->get();
        
        // Get Laravel database notifications
        $databaseNotifications = $user->notifications()->latest()->get();
        
        // Combine both types
        $combinedNotifications = $customNotifications->concat($databaseNotifications)
            ->sortByDesc('created_at')
            ->paginate(15);
        
        return view('notifications.index', compact('combinedNotifications'));
    }

    /**
     * Get notifications for the notification dropdown.
     */
    public function getNotifications()
    {
        $user = Auth::user();
        
        // Get custom notifications
        try {
            $customNotifications = $user->customNotifications()->latest()->take(10)->get();
        } catch (\Exception $e) {
            $customNotifications = collect();
        }
        
        // Get Laravel database notifications
        try {
            $databaseNotifications = $user->notifications()->latest()->take(10)->get();
        } catch (\Exception $e) {
            $databaseNotifications = collect();
        }
        
        // Combine both types
        $notifications = $customNotifications->concat($databaseNotifications)
            ->sortByDesc('created_at')
            ->take(10);
        
        // Group notifications by date
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        $thisWeek = Carbon::now()->startOfWeek();
        
        $groupedNotifications = [
            'today' => $notifications->filter(function ($notification) use ($today) {
                return Carbon::parse($notification->created_at)->isToday();
            }),
            'yesterday' => $notifications->filter(function ($notification) use ($today, $yesterday) {
                return Carbon::parse($notification->created_at)->isYesterday();
            }),
            'thisWeek' => $notifications->filter(function ($notification) use ($today, $yesterday, $thisWeek) {
                return !Carbon::parse($notification->created_at)->isToday() && 
                       !Carbon::parse($notification->created_at)->isYesterday() && 
                       Carbon::parse($notification->created_at)->gte($thisWeek);
            }),
            'older' => $notifications->filter(function ($notification) use ($thisWeek) {
                return Carbon::parse($notification->created_at)->lt($thisWeek);
            }),
        ];
        
        // Count unread notifications from both sources
        try {
            $customUnreadCount = $user->customNotifications()->where('is_read', false)->count();
        } catch (\Exception $e) {
            $customUnreadCount = 0;
        }
        
        try {
            $databaseUnreadCount = $user->unreadNotifications()->count();
        } catch (\Exception $e) {
            $databaseUnreadCount = 0;
        }
        
        $totalUnreadCount = $customUnreadCount + $databaseUnreadCount;
        
        return response()->json([
            'notifications' => $groupedNotifications,
            'unreadCount' => $totalUnreadCount
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $type = $request->input('type', 'custom');
        
        try {
            if ($type === 'database') {
                // Handle Laravel database notification
                $notification = Auth::user()->notifications()->findOrFail($id);
                $notification->markAsRead();
            } else {
                // Handle custom notification
                $notification = Auth::user()->customNotifications()->findOrFail($id);
                $notification->is_read = true;
                $notification->save();
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error marking notification as read: ' . $e->getMessage()], 400);
        }
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead()
    {
        try {
            // Mark all custom notifications as read
            Auth::user()->customNotifications()->where('is_read', false)->update(['is_read' => true]);
        } catch (\Exception $e) {
            // Continue if there's an error
        }
        
        try {
            // Mark all Laravel database notifications as read
            Auth::user()->unreadNotifications()->update(['read_at' => now()]);
        } catch (\Exception $e) {
            // Continue if there's an error
        }
        
        return response()->json(['success' => true]);
    }
} 