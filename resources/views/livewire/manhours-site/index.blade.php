<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between mb-2 p-1 shadow-md">
        <div class="flex gap-1">
            <!-- Open the modal using ID.showModal() method -->
            <x-btn-add wire:click="modalMS" data-tip="Add Data"></x-btn-add>
            <x-btn-icon-upload for="my_modal_7" data-tip="Upload Data" />
        </div>
        <div>
            <div class="flex flex-col sm:flex-row">
                <x-inputsearch wire:model.live='search' />
            </div>
        </div>
    </div>
    <div class="overflow-x-auto md:h-[28rem] 2xl:h-[45rem]  shadow-md">
        <table class="table table-xs table-pin-cols table-pin-rows ">
            <!-- head -->
            <thead>
                <tr class="text-center text-[11px]">
                    <th >Date</th>
                    <td>Company Employee</td>
                    <td>Company Workhours</td>
                    <td>Company Cummulatives</td>
                    <td>Contractor Employee</td>
                    <td>Contractor Workhours</td>
                    <td>Contractor Cummulatives</td>
                    <td>Total Employee</td>
                    <td>Total Workhours</td>
                    <td>Total Cummulatives</td>
                    <td>Cummulatives Manhours By LTI</td>
                    <td>Manhours Lost</td>
                    <td>LTI</td>
                    <td>LTI Date</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($ManhoursSite as $item)
                    <tr class="text-center hover:bg-cyan-200">
                        <th class="text-[10.5px]">{{ date('M-Y', strtotime($item->date)) }}</th>
                        <td>{{ number_format($item->Company_Employee, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Company_Workhours, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Company_Cummulatives, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Contractor_Employee, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Contractor_Workhours, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Contractor_Cummulatives, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Total_Employee, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Total_Workhours, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Total_Cummulatives, 0, ',', '.') }}</td>
                        <td>{{ number_format($item->Cummulatives_Manhours_By_LTI, 0, ',', '.') }}</td>
                        <td>{{ !empty($item->Manhours_Lost)?number_format($item->Manhours_Lost, 0, ',', '.'):"" }}</td>
                        <td>{{ $item->LTI }}</td>
                        <td>{{ !empty($item->LTI_Date)?date('d-M-Y',strtotime($item->LTI_Date)):'' }}</td>
                        <td>
                            <div class="flex gap-1">
                                <x-icon-btn-edit for="my_modal_1" wire:click="modalMS({{ $item->id }})"
                                    data-tip="Update"></x-icon-btn-edit>
                                <x-icon-btn-delete wire:click="delete({{ $item->id }})"
                                    wire:confirm.prompt="Are you sure you want to delete this data ?\n\nType DELETE to confirm|DELETE"
                                    data-tip="Delete"></x-icon-btn-delete>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    
    <div  class="modal {{ $modal }}">
        <div class="modal-box">
            <form wire:submit.prevent='store'>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Date')" />
                    <x-input id="month" wire:model.live='date' readonly :error="$errors->get('date')" />
                    <x-label-error :messages="$errors->get('date')" />
                </div>
                <div class="modal-action">
                    <x-btn-save  wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:target="store" wire:loading.class="btn-disabled" wire:click="closeModal" >{{ __('Close') }}</x-btn-close>
                </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="my_modal_7" class="modal-toggle" />
    <div class="modal" role="dialog">

        <div wire:target="uploadManhours" wire:loading.class="skeleton" class="modal-box">
            <div
                class="pb-2 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                Upload Manhours</div>
            <form wire:submit.prevent='uploadManhours'>
                @csrf

                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('File')" />
                    <div class="relative ">
                        <x-input-file wire:model.blur='files' :error="$errors->get('files')" />
                        <span wire:target="files"
                            wire:loading.class="loading-md loading loading-spinner text-accent absolute inset-y-0 right-0"></span>
                    </div>
                    <x-label-error :messages="$errors->get('files')" />
                </div>
                <div class="modal-action">
                    <x-btn-save wire:target="uploadManhours,files" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:target="uploadManhours,files" wire:loading.class="btn-disabled" >{{ __('Close') }}</x-btn-close>
                </div>
            </form>
        </div>

        <label class="modal-backdrop">Close</label>
    </div>

</div>
