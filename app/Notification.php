<?php

namespace App;

use Illuminate\Database\Eloquent\Model;



class Notification extends Model


{

    protected $table = 'notifications';

    public function getUnreadNumber($userToId)
    {

        return $this->where('userToId', $userToId)
            ->where('viewed', 0)->count();
    }



    public function getNotifications($userToId)

    {

        $notifications = $this->where('userToId', $userToId)
            ->latest()
            ->paginate(5);

        $sadiq =  $notifications->link;
        ddd($sadiq);
    }



    public function insertNotification($post_id, $user_to, $type)
    {
    }
}
