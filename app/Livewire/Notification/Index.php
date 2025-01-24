<?php

namespace App\Livewire\Notification;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $readNotif = auth()->user()->notifications->whereNotNull('read_at')->all();
        return view('livewire.notification.index',[
            'Notif' =>$readNotif
            ]);
    }
    public function readNotification($id,$url)
    {
        $notificationId = $id;

        $userUnreadNotification = auth()->user()
                                    ->unreadNotifications
                                    ->where('id','like', $notificationId)
                                    ->first();
        
        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return redirect($url);
        }
    }
    public function goTo($url){
         return redirect($url);
    }
}
