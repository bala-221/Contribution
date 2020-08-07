<?php

namespace App\Http\Controllers;

use \App\Notification;
use \App\ContriRequest;
use \App\User;



class NotificationController extends Controller
{

    public function showDropDown()
    {

        $userId = auth()->user()->id;

        $notifications =  Notification::where('userToId', $userId)->get();




        $htmlLinks = '';



        foreach ($notifications as $notification) {

            $timeMessage = $notification->created_at->diffForHumans();

            $htmlLinks =  $htmlLinks . "<a class='dropdown-item' href={$notification->link}>{$notification->message} {$timeMessage} </a>";
        }






        return response()->json([
            'success' => 'Form is successfully submitted!',
            'htmlLinks' => $htmlLinks,


        ]);
    }
}
