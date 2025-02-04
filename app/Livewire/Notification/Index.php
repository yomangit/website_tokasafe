<?php

namespace App\Livewire\Notification;

use App\Models\Notifications;
use Livewire\Component;

class Index extends Component
{
    public $searching="";
    public function render()
    {
        $allNotification  = Notifications::where('notifiable_id',auth()->user()->id)->where('data->line','LIKE','%'.$this->searching.'%')->get();
        $unRead =Notifications::whereNotNull('read_at')->where('notifiable_id',auth()->user()->id)->where('data->line','LIKE','%'.$this->searching.'%')->get();
        $unReadCount =Notifications::whereNotNull('read_at')->where('notifiable_id',auth()->user()->id)->count();
        return view('livewire.notification.index',[
            'AllNotification' =>$allNotification,
            'Unread'=>  $unRead
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
