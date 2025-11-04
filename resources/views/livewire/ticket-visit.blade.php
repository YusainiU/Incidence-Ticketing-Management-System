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
    $errorClass = 'dark:bg-red-400 p-2';

@endphp

<div id="{{ $selectedTab }}">
    @if ($visitCreated)
        <div class="{{ $info }} text-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => {
            show = false,
                $wire.set('visitCreated', false)
        }, 2500)">
            Visit task has been created
        </div>
    @endif
    @if ($canEdit)
        <form wire:submit.prevent='doVisit'>
            <div class="flex flex-row gap-3 w-full mt-3">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Short Description</label>
                    <input type="text" wire:model='visit_short_description' class="{{ $input }}" />
                    <div>
                        <div>
                            @error('visit_short_description')
                                <span class="error {{ $errorClass }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Assigned Visit To</label>
                    <select wire:model='visit_assigned_to' class="{{ $select }}">
                        <option value="">--- Select ---</option>
                        @foreach ($internalUsers as $internalUser)
                            <option value="{{ $internalUser }}">{{ $internalUser->name }}</option>
                        @endforeach
                    </select>
                    <div class="mt-3">
                        <div>
                            @error('visit_assigned_to')
                                <span class="error {{ $errorClass }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row gap-3 w-full mt-3">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Visit Schedule At</label>
                    <div class="flex flex-row gap-3 w-full mt-3">
                        <input type="date" class="{{ $input }}" wire:model='visit_scheduled_date' />
                        <input type="time" class="{{ $input }}" wire:model='visit_scheduled_time' />
                    </div>
                    <div class="flex flex-row gap-3">
                        <div class="flex-1">
                            @error('visit_scheduled_date')
                                <span class="error {{ $errorClass }}">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex-1">
                            @error('visit_scheduled_time')
                                <span class="error {{ $errorClass }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row gap-3 w-full mt-3">
                <div class="flex-1 flex-col gap-3 w-full mt-3">
                    <label class="{{ $label }}">Visit Notes</label>
                    <textarea class="{{ $textarea }}" wire:model='visit_description' cols="5" rows="5" /></textarea>
                </div>
            </div>
            <div x-show='false' class="flex flex-row gap-3 w-full mt-3">
                <input type="checkbox" class="{{ $checkbox }}" wire:model='visit_first'>
                <label class="{{ $label }}">This is a first visit</label>
            </div>
            <div class="flex flex-row gap-3 w-full mt-3">
                <button type="submit" class="{{ $btnBlue }}">Submit</button>
            </div>
        </form>
    @endif
    <div class="{{ $divTop }}" wire:show='showVisitTable'>
        <x-table>
            <x-slot name="tableColumns">
                <tr class="{{ $colTr }}">
                    <th class="{{ $th }}">Visit Scheduled</th>
                    <th class="{{ $th }}">Short Description</th>
                    <th class="{{ $th }}">Person to Visit</th>
                    <th class="{{ $th }}">Scheduled By</th>
                    <th class="{{ $th }}">Enroute At</th>
                    <th class="{{ $th }}">Onsite At</th>
                    <th class="{{ $th }}">Offsite At</th>
                    <th class="{{ $th }}">&nbsp;</th>
                </tr>
            </x-slot>
            <x-slot name="tableRows">
                @foreach ($allVisits as $thisVisit)
                    <tr>
                        <td class="{{ $td }}">
                            {{ date('d-m-Y H:i', strtotime($thisVisit->visit_scheduled_at)) }}
                        </td>
                        <td class="{{ $td }}">
                            {{ $thisVisit->short_description }}
                        </td>
                        <td class="{{ $td }}">
                            {{ $thisVisit->assignedTo->name }}
                        </td>
                        <td class="{{ $td }}">
                            {{ $thisVisit->scheduledBy->name }}
                        </td>
                        <td class="{{ $td }}">
                            @if ($thisVisit->enroute_at)
                                {{ date('d-m-Y H:i', strtotime($thisVisit->enroute_at)) }}
                            @else
                                &nbsp;
                            @endif

                        </td>
                        <td class="{{ $td }}">
                            <div>
                                @if ($thisVisit->onsite_at)
                                    {{ date('d-m-Y H:i', strtotime($thisVisit->onsite_at)) }}
                                @else
                                    &nbsp;
                                @endif
                            </div>
                        </td>
                        <td class="{{ $td }}">
                            @if ($thisVisit->offsite_at)
                                {{ date('d-m-Y H:i', strtotime($thisVisit->offsite_at)) }}
                            @else
                                &nbsp;
                            @endif
                        </td>
                        <td class="{{ $td }}">
                            @if ($canEdit)
                                <a href="#EndOfSection"
                                    wire:click="$dispatch('openModal', {
                                    component: 'SiteVisitUpdateModal',
                                    arguments: {siteVisit:{{ $thisVisit }}}
                                })">
                                    {!! $svg_elip !!}
                                </a>
                            @else
                                {!! $svg_elip !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-table>
    </div>
</div>
