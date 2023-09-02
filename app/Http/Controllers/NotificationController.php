<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification, Request $request)
    {
        $request->validate(['redirect_url' => 'required']);

        $notification->markAsRead();

        return redirect($request->redirect_url);
    }
}
