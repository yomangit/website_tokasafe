<?php

namespace App\Livewire\EventReport\PtoReport\Panel;

use Livewire\Component;
use App\Models\pto_report;
use App\Models\ClassHierarchy;
use App\Models\WorkflowDetail;
use App\Models\EventUserSecurity;
use App\Models\WorkflowApplicable;

class Index extends Component
{
    public $pto_id, $assign_to, $also_assign_to, $current_step, $workflow_administration_id;
    public $Workflows, $Workflows_id, $bg_status, $status, $tampilkan = false, $responsible_role_id, $show = false, $EventUserSecurity = [], $division_id, $event_type_id, $procced_to;
    protected $listeners = [

        'panel_pto' => 'render'
    ];
    public function mount(pto_report $id)
    {
        $this->pto_id = $id->id;
    }
    public function update()
    {
        $id = pto_report::whereId($this->pto_id)->first();
        $this->Workflows_id = $id->workflow_detail_id;

        $this->current_step = $id->WorkflowDetails->name;
        $this->bg_status = $id->WorkflowDetails->Status->bg_status;
        $this->status = $id->WorkflowDetails->Status->status_name;
        $this->responsible_role_id = $id->WorkflowDetails->ResponsibleRole->id;
        $this->workflow_administration_id = $id->workflow_template_id;
        $this->division_id = $id->division_id;
        $this->assign_to = $id->assign_to;
        $this->also_assign_to = $id->also_assign_to;
        $this->event_type_id = WorkflowApplicable::where('workflow_administration_id', $this->workflow_administration_id)->first()->type_event_report_id;
    }
    public function userSecurity()
    {
        $ClassHierarchy =  ClassHierarchy::where('division_id', [$this->division_id])->first();
        $Company = $ClassHierarchy->company_category_id;
        $Department = $ClassHierarchy->dept_by_business_unit_id;
        $User = EventUserSecurity::where('user_id', auth()->user()->id)->where('responsible_role_id',  $this->responsible_role_id)->where('responsible_role_id',  $this->responsible_role_id)->where('type_event_report_id', $this->event_type_id)->pluck('user_id');

        foreach ($User as $value) {
            if (EventUserSecurity::where('user_id', $value)->searchCompany(trim($Company))->exists()) {
                $this->tampilkan = true;
            } elseif (EventUserSecurity::where('user_id', $value)->searchDept(trim($Department))->exists()) {
                $this->tampilkan = true;
            } else {
                $this->tampilkan = false;
            }
        }
    }
    public function realtimeUpdate()
    {
        if ($this->procced_to === "Assigned") {
            $ERM = ClassHierarchy::searchDivision(trim($this->division_id))->pluck('dept_by_business_unit_id');
            foreach ($ERM as $value) {
                if (!empty($value)) {
                    $this->EventUserSecurity = ( EventUserSecurity::where('responsible_role_id',2)->where('dept_by_business_unit_id', $value)->where('type_event_report_id', $this->event_type_id)->exists())? EventUserSecurity::where('responsible_role_id',2)->where('dept_by_business_unit_id', $value)->where('type_event_report_id', $this->event_type_id)->get(): EventUserSecurity::where('responsible_role_id',2)->where('dept_by_business_unit_id', $value)->get();

                    $this->show = true;
                } else {
                    $this->show = false;
                }
            }
        } else {
            $this->show = false;
        }
    }
    public function render()
    {
        $this->update();
        $this->userSecurity();
        $this->realtimeUpdate();

            $this->Workflows = WorkflowDetail::where('workflow_administration_id', $this->workflow_administration_id)->where('name', $this->current_step)->get();

        return view('livewire.event-report.pto-report.panel.index', [
            "Workflow" => $this->Workflows,
        ]);
    }
    public function store()
    {
        if (empty($this->assign_to)) {
            $this->assign_to = null;
        }
        if (empty($this->also_assign_to)) {
            $this->also_assign_to = null;
        }
        if ($this->procced_to === "Assigned") {
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
            $WorkflowDetail = WorkflowDetail::where('workflow_administration_id', $this->workflow_administration_id)->where('name', $this->procced_to)->first();
            $this->Workflows_id = $WorkflowDetail->id;
        }
        pto_report::whereId($this->pto_id)->update([
            'workflow_detail_id' => $this->Workflows_id,
            'assign_to' => $this->assign_to,
            'also_assign_to' => $this->also_assign_to,
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
        // $this->dispatch('panel_incident', $this->data_id);
        $this->dispatch('pto_detail');
        $this->reset('procced_to');
    }
}
