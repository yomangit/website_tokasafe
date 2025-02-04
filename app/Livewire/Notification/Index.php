<?php

namespace App\Livewire\Notification;

use App\Models\Notifications;
use Livewire\Component;

class Index extends Component
{
    public $searching="";
    public function render()
    {
        $allNotification  = auth()->user()->notifications->where('data.line','BANEA, Yoman Denis has submitted a hazard report, please review');
        $unRead =auth()->user()->unreadNotifications;
        return view('livewire.notification.index',[
            'AllNotification' =>$allNotification,
            'Unread'=>  $unRead
            ]);
    }
    public function readNotification($id,$url)
    {
        $notificationId = $id;

        $userUnreadNotification = auth()->user()->unreadNotifications->find($id);

        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return redirect($url);
        }
    }
    public function goTo($url){
         return redirect($url);
    }
}
