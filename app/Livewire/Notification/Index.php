<?php

namespace App\Livewire\Notification;

use Livewire\Component;
class Index extends Component
{
    public $searching="";
    public function render()
    {
        $allNotification  = auth()->user()->notifications;
        $unRead = auth()->user()->unreadNotifications;
        return view('livewire.notification.index',[
            'AllNotification' =>$allNotification,
            'Unread'=>  $unRead
            ]);
    }
    public function readNotification($id,$url)
    {
        $notificationId = $id;
        $userUnreadNotification = auth()->user()->unreadNotifications->where('id','like', $notificationId)->first();
        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return redirect($url);
        }
    }
    public function goTo($id,$url){
        $userUnreadNotification = auth()->user()->notifications->where('id','like', $id)->whereNull('read_at')->first();
        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return redirect($url);
        }
         return redirect($url);
    }
    public function delete($id){
        $userDeleteNotification = auth()->user()->notifications->whereId('id','like', $id)->first();
        if($userDeleteNotification) {
            $userDeleteNotification->delete();
        }
    }
}
