<?php

namespace App\Livewire\Notification;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.notification.index');
    }
    public function readNotification($id)
    {
        $notificationId = $id;

        $userUnreadNotification = auth()->user()
                                    ->unreadNotifications
                                    ->where('id','like', $notificationId)
                                    ->first();
        
        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
        }
    }
}
