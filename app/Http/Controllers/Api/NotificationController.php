<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;

class NotificationController extends Controller
{

    /**
     * Get user's notifications.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id',Auth::id())
        ->orderBy('created_at', 'DESC')
        ->get();

        Notification::where('user_id',Auth::id())->whereNull('read_at')
        ->update(['read_at'=>now()]);

        return response()->json(['success'=>[
            'notifications'=>$notifications
        ]]);
    }
}
