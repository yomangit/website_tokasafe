<?php

namespace App\Livewire\Notification;

use Livewire\Component;

class Index extends Component
{
    public $searching="";
    public function render()
    {
        $allNotification = auth()->user()->notifications->all();
        return view('livewire.notification.index',[
            'AllNotification' =>$allNotification
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
