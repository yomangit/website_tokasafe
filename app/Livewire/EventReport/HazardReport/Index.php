<?php

namespace App\Livewire\EventReport\HazardReport;

use Livewire\Component;
use App\Models\StatusEvent;
use App\Models\ActionHazard;
use App\Models\HazardReport;
use Livewire\Attributes\Url;
use App\Models\TypeEventReport;
use App\Models\Eventsubtype;
use App\Models\EventUserSecurity;
use App\Models\route_request;
use Illuminate\Support\Facades\Request;
use App\Models\choseEventType;
class Index extends Component
{
    #[Url]
    public $rangeDate = '', $searching = '', $search_workgroup = '', $search_eventType = '', $search_eventSubType = '', $search_status = '',$responsible_role_id,$workflow_template_id;
    public $EventSubType = [], $show = false, $in_tray, $nilai,$muncul=false,$event_type_id,$view=false;
    public $startDate, $endDate;
    public $tglMulai, $tglAkhir;
    public function render()
    {

        if (route_request::where('route_name','LIKE',Request::getPathInfo())->exists()) {
            $this->workflow_template_id = route_request::where('route_name','LIKE',Request::getPathInfo())->first()->workflow_template_id;
           
           }else{
            $this->workflow_template_id ="";
           }
        if ($this->in_tray) {
            $this->nilai = auth()->user()->id;
        } else {
            $this->nilai = '';
        }

        $user_security = EventUserSecurity::where('user_id', auth()->user()->id)->searchEventType(trim($this->event_type_id))->pluck('responsible_role_id');
        foreach ($user_security as $value) {
            if ($value = $this->responsible_role_id) {
                $this->muncul = true;
            } else {
                $this->muncul = false;
            }
        }
        if (auth()->user()->role_user_permit_id == 1) {
            $this->view=true;
        }
        if ($this->rangeDate) {

            $Hazard = HazardReport::with([
                'WorkflowDetails',
                'subEventType',
                'eventType'
            ])->findSubmitter(trim($this->nilai))->searchStatus(trim($this->search_status))->searchEventType(trim($this->search_eventType))->searchEventSubType(trim($this->search_eventSubType))->whereBetween('date', [array($this->tglMulai), array($this->tglAkhir)])->search(trim($this->searching))->paginate(30);
        } else {
            $Hazard = HazardReport::with([
                'WorkflowDetails',
                'subEventType',
                'eventType'
            ])->findSubmitter(trim($this->nilai))->searchStatus(trim($this->search_status))->searchEventType(trim($this->search_eventType))->searchEventSubType(trim($this->search_eventSubType))->search(trim($this->searching))->paginate(30);
        }
      
         if (choseEventType::where('route_name','LIKE','%'. '/eventReport/hazardReport'.'%')->exists()) {
            $eventType = choseEventType::where('route_name','LIKE','%'. '/eventReport/hazardReport'.'%')->pluck('event_type_id');
            
            $Event_type = TypeEventReport::whereIn('id', $eventType)->get();
           
           }else{
            $Event_type =[];
           }
            $this->EventSubType = (isset($this->search_eventType)) ?  $this->EventSubType = Eventsubtype::where('event_type_id', $this->search_eventType)->get() : [];
        return view('livewire.event-report.hazard-report.index', [
            'HazardReport' => $Hazard,
            'ActionHazard' => ActionHazard::get(),
            'Status' => StatusEvent::get(),
            'EventType' =>  $Event_type,
        ])->extends('base.index', ['header' => 'Hazard Report', 'title' => 'Hazard Report'])->section('content');
    }

}
