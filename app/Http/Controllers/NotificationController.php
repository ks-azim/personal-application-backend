<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function getAll()
    {
        $notSeen = Notification::with('quote')->orderBy('created_at', 'DESC')->where('status', 'not seen');

        $unread = $notSeen->get();
        $count  = $notSeen->count();
        $read   = Notification::with('quote')->orderBy('created_at', 'DESC')->where('status', 'seen')->get();

        if(!$read) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        return response()->json([
            'status'             => 200,
            'notificationCount'  => $count,
            'unread'             => $unread,
            'read'               => $read
        ]);
    }

    public function updateNotificationStatus(Request $request)
    {
        try {
            $update = Notification::whereIn('id', $request->ids)->update([
                'status' => 'seen'
            ]);

            return response()->json([
                'status' => 200
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 500
            ]);
        }
    }

    public function getById($id)
    {
        $notification = Notification::with('quote')->where('id', $id)->first();

        if(!$notification) {
            return response()->json([
                'status'   => 404,
                'message'  => 'No Data Found !'
            ]);    
        }

        Notification::where('id', $id)->update([
            'status' => 'seen'
        ]);

        return response()->json([
            'status'   => 200,
            'data'     => $notification->quote
        ]);
    }
}
