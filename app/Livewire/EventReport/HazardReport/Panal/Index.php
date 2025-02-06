<?php

namespace App\Livewire\EventReport\HazardReport\Panal;

use App\Models\ClassHierarchy;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\HazardReport;
use App\Models\WorkflowDetail;
use App\Models\EventUserSecurity;
use App\Models\WorkflowApplicable;
class Index extends Component
{
    public $procced_to, $EventUserSecurity = [], $Workflows, $show = false, $workflow_detail_id, $data_id, $assign_to, $also_assign_to, $current_step,  $event_type_id, $workflow_administration_id, $status, $bg_status, $muncul = false, $responsible_role_id;
    public $wf_id, $division_id, $assign_to_old, $also_assign_to_old;
    #[On('hzrd_updated')]
    public function hzrd_updated($id)
    {
        $HazardReport = HazardReport::whereId($id)->first();
        $this->assign_to_old = $HazardReport->assign_to;
        $this->also_assign_to_old = $HazardReport->also_assign_to;
        $this->responsible_role_id = $HazardReport->WorkflowDetails->ResponsibleRole->id;
    }
    public function mount($id)
    {
        $this->data_id = $id;
        $HazardReport = HazardReport::whereId($id)->first();
        $this->assign_to = $HazardReport->assign_to;
        $this->also_assign_to = $HazardReport->also_assign_to;
    }
    public function render()
    {
        $this->updatePanel();
        $this->workflow_administration_id = (!empty(WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id)) ? WorkflowApplicable::where('type_event_report_id', $this->event_type_id)->first()->workflow_administration_id : null;
        $this->Workflows = WorkflowDetail::where('workflow_administration_id', $this->workflow_administration_id)->where('name', $this->current_step)->get();
        $this->realtimeUpdate();
        $this->userSecurity();
        return view('livewire.event-report.hazard-report.panal.index', [
            "Workflow" => $this->Workflows
        ]);
    }
    public function userSecurity()
    {
        $ClassHierarchy =  ClassHierarchy::where('division_id', [$this->division_id])->first();
        if ($ClassHierarchy) {
            $Company = $ClassHierarchy->company_category_id;
            $Department = $ClassHierarchy->dept_by_business_unit_id;
            $User = EventUserSecurity::where('user_id', auth()->user()->id)->where('responsible_role_id',  $this->responsible_role_id)->where('type_event_report_id', $this->event_type_id)->pluck('user_id');
            foreach ($User as $value) {
                if (EventUserSecurity::where('user_id', $value)->searchCompany(trim($Company))->exists()) {
                    $this->muncul = true;
                } elseif (EventUserSecurity::where('user_id', $value)->searchDept(trim($Department))->exists()) {
                    $this->muncul = true;
                } else {
                    $this->muncul = false;
                }
            }
        }else {
            $this->dispatch(
                'alert',
                [
                    'text' => "the Responsibility Workgroup not have class Hierarchy!!",
                    'duration' => 5000,
                    'destination' => '/contact',
                    'newWindow' => true,
                    'close' => true,
                    'backgroundColor' => "linear-gradient(to right, #9a3412, #fbbf24)",
                ]
            );
        }
    }
    public function updatePanel()
    {
        $HazardReport = HazardReport::whereId($this->data_id)->first();
        $this->current_step = $HazardReport->WorkflowDetails->name;
        $this->responsible_role_id = $HazardReport->WorkflowDetails->ResponsibleRole->id;
        $this->status = $HazardReport->WorkflowDetails->Status->status_name;
        $this->bg_status = $HazardReport->WorkflowDetails->Status->bg_status;
        $this->wf_id = $HazardReport->workflow_detail_id;
        $this->division_id = $HazardReport->division_id;
        $this->event_type_id = $HazardReport->event_type_id;
    }
    public function realtimeUpdate()
    {
        if ($this->procced_to === "ERM Assigned") {
            $ERM = ClassHierarchy::searchDivision(trim($this->division_id))->pluck('dept_by_business_unit_id');

            foreach ($ERM as $value) {
                if (!empty($value)) {
                    $this->EventUserSecurity = ( EventUserSecurity::whereNotIn('dept_by_business_unit_id', [$value])->where('type_event_report_id', $this->event_type_id)->exists())? EventUserSecurity::whereIn('dept_by_business_unit_id', [$value])->get():EventUserSecurity::whereIn('dept_by_business_unit_id', [$value])->where('type_event_report_id', $this->event_type_id)->get();
                    $this->show = true;
                } else {
                    $this->show = false;
                }
            }
        } else {
            $this->show = false;
        }
    }
    public function store()
    {
        if (empty($this->assign_to)) {
            $this->assign_to = null;
        }
        if (empty($this->also_assign_to)) {
            $this->also_assign_to = null;
        }
        if ($this->procced_to === "ERM Assigned") {
            $this->validate([
                'procced_to' => ['required'],
                'assign_to' => ['required'],
                'also_assign_to' => ['nullable'],
            ]);
        } else {
            $this->validate([
                'procced_to' => ['required'],
            ]);
        }
        if ($this->procced_to) {
            $WorkflowDetail  = WorkflowDetail::where('name', $this->procced_to)->first();
            $this->workflow_detail_id = $WorkflowDetail->id;
        }

        HazardReport::whereId($this->data_id)->update([
            'workflow_detail_id' => $this->workflow_detail_id,
            'assign_to' => $this->assign_to,
            'also_assign_to' => $this->also_assign_to
        ]);
        $this->dispatch(
            'alert',
            [
                'text' => "The Step was updated!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #a3e635, #eab308)",
            ]
        );
        $this->dispatch('panel_updated', $this->data_id);
        $this->dispatch('panel_hazard');
        $this->reset('procced_to');
        $this->show = false;
    }
}
