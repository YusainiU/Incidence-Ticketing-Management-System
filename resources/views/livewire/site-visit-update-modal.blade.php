@php
    $info = Config::get('steps.alert.info');
    $failed = Config::get('steps.alert.danger');
    $input = Config::get('steps.form.input-normal');
    $label = Config::get('steps.form.label');
    $select = Config::get('steps.form.select');
    $textarea = Config::get('steps.form.textarea');
    $btnEdit = Config::get('steps.buttonClasses.btnEdit');
    $btnBlue = Config::get('steps.buttonClasses.btnBlue');
    $btnRed = Config::get('steps.buttonClasses.btnRed');
    $dl = Config::get('steps.descriptionList.dl');
    $checkbox = Config::get('steps.form.checkbox');
    $checkboxLabel = Config::get('steps.form.checkboxLabel');
    $link = Config::get('steps.link');

    $table = Config::get('steps.tableClasses.table');
    $thead = Config::get('steps.tableClasses.thead');
    $th = Config::get('steps.tableClasses.th');
    $td = Config::get('steps.tableClasses.td');
    $tbody = Config::get('steps.tableClasses.tbody');
    $colTr = Config::get('steps.tableClasses.colTr');
    $divTop = Config::get('steps.tableClasses.divTop');

    $svg_elip = Config::get('steps.svg.svg_ellipsis');
@endphp

<div>
    <x-modal-steps>
        <x-slot name="title">
            Update Site Visit
        </x-slot>   
        <x-slot name="modalContent">
            <div class="flex gap-4 flex-row content-start">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Short Description</label>
                    <input type="text" wire:model='short_description' class="{{ $input }}" />
                    <div>
                        <div>
                            @error('short_description')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Assigned Visit To</label>
                    <select wire:model='assigned_to' class="{{ $select }}">
                        <option value="{{ $assigned_to }}">{{ $siteVisit->assignedTo->name }}</option>
                        @foreach ($internalUsers as $internalUser)
                            <option value="{{ $internalUser }}">{{ $internalUser->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        <div>
                            @error('assigned_to')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 flex-row content-start">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Visit Schedule At</label>
                    <div class="flex flex-row gap-3 w-full mt-3">
                        <input type="date" class="{{ $input }}" wire:model='scheduled_date' />
                        <input type="time" class="{{ $input }}" wire:model='scheduled_time' />
                    </div>
                    <div class="flex flex-row gap-3">
                        <div class="flex-1">
                            @error('scheduled_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            @error('scheduled_time')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 flex-row content-start">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Visit Notes</label>
                    <textarea class="{{ $textarea }}" wire:model='description' cols="5" rows="5" /></textarea>
                </div>
            </div>
            <div class="flex gap-4 flex-row content-start">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Enroute At</label>
                    <div class="flex flex-row gap-3 w-full mt-3">
                        <input type="date" class="{{ $input }}" wire:model='enroute_date' />
                        <input type="time" class="{{ $input }}" wire:model='enroute_time' />
                    </div>
                    <div class="flex flex-row gap-3">
                        <div class="flex-1">
                            @error('enroute_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            @error('enroute_time')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 flex-row content-start">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Onsite At</label>
                    <div class="flex flex-row gap-3 w-full mt-3">
                        <input type="date" class="{{ $input }}" wire:model='onsite_date' />
                        <input type="time" class="{{ $input }}" wire:model='onsite_time' />
                    </div>
                    <div class="flex flex-row gap-3">
                        <div class="flex-1">
                            @error('onsite_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            @error('onsite_time')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-4 flex-row content-start">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Offsite At</label>
                    <div class="flex flex-row gap-3 w-full mt-3">
                        <input type="date" class="{{ $input }}" wire:model='offsite_date' />
                        <input type="time" class="{{ $input }}" wire:model='offsite_time' />
                    </div>
                    <div class="flex flex-row gap-3">
                        <div class="flex-1">
                            @error('offsite_date')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            @error('offsite_time')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>                                         
        </x-slot>
        <x-slot name="buttonActionName">
            Update
        </x-slot>
        <x-slot name="buttonDelete">
            &nbsp;
        </x-slot>
    </x-modal-steps>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
</div>
