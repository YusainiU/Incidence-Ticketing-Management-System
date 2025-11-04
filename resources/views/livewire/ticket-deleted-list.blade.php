@php

    $th = Config::get('steps.tableClasses.th');
    $td = Config::get('steps.tableClasses.td');
    $thAlign = Config::get('steps.tableClasses.colTr');
    $marginTop = Config::get('steps.tableClasses.divTop');

    $info = Config::get('steps.alert.info');
    $alert = Config::get('steps.alert.warning');
    $select = Config::get('steps.form.select');
    $btnGrey = Config::get('steps.buttonClasses.btnGrey');
    $link = Config::get('steps.link');
    $tooltip = Config::get('steps.tooltip');

    $divSeparator = Config::get('steps.tableClasses.divSeparator');
    
    $moniker = Config::get('steps.ticket');

@endphp
<div class="{{ $marginTop }}">
    <div>

        <x-section-title>
            <x-slot name="title">
                Deleted {{ $moniker }}
            </x-slot>
            <x-slot name="description">
                List of Deleted {{ $moniker }}
            </x-slot>
        </x-section-title>

    <div class="{{ $divSeparator }}">
        &nbsp;
    </div>        

        <div>
            <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
                <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
            </div>
        </div>

        {{ $tickets->links() }}

        <x-table>

            <x-slot name="tableColumns">
                <tr class="{{ $thAlign }}">
                    <th class="{{ $th }}">
                        {{ $moniker }} #
                    </th>
                    <th class="{{ $th }}">
                        Deleted At
                    </th>
                    <th class="{{ $th }}">
                        Site
                    </th>
                    <th class="{{ $th }}">
                        Summary
                    </th>
                    <th class="{{ $th }}">
                        Restore
                    </th>
                </tr>
            </x-slot>

            <x-slot name="tableRows">
                @if ($tickets)
                    @foreach ($tickets as $ticket)
                        <tr class="{{ $thAlign }}">
                            <td class="{{ $td }} align-top">
                                {{ $ticket->ticket_number }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ date('d-m-Y H:i', strtotime($ticket->deleted_at)) }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ Str::of($ticket->customer->name)->limit(20) }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ Str::of($ticket->short_description)->limit(30) }}
                                <button class="{{ $link }}"
                                    x-on:click="$wire.showDescription({{ $ticket }})">[more]</button>
                            </td>
                            <td class="{{ $td }} align-top">
                                <button 
                                    type="button" 
                                    class="{{ $btnGrey }}"
                                    wire:confirm="Are you sure you want to restore this ticket?"
                                    wire:click='restore({{ $ticket }})'
                                >
                                    Restore
                                </button>
                            </td>
                        </tr>

                        @if ($moreOnThis && $moreOnThis->id == $ticket->id)
                            <tr class="{{ $thAlign }}" wire:show="showFilter">
                                <td class="{{ $td }}" colspan="6">
                                    <div class="{{ $info }}">
                                        <span class="block">
                                            Description: {{ $moreOnThis->description }}
                                        </span>
                                        <span class="block">
                                            Raised By:
                                            {{ $ticket->raised_by_user ? $ticket->raised_by_user : $ticket->raised_by_nonuser }}
                                        </span>
                                        <span class="block">
                                            Respond By:
                                            {{ $slaTask->respond_by ? date('d-m-Y H:i', strtotime($slaTask->respond_by)) : 'Not Available' }}
                                        </span>
                                        <span class="block">
                                            Fix By:
                                            {{ $slaTask->fix_by ? date('d-m-Y H:i', strtotime($slaTask->fix_by)) : 'Not Available' }}
                                        </span>
                                        <span class="block">
                                            Remote response at:
                                            {{ $slaTask->responded_at ? date('d-m-Y H:i', strtotime($slaTask->responded_at)) : 'Not Available' }}
                                        </span>
                                        <span class="block">
                                            Fixed at:
                                            {{ $slaTask->fixed_at ? date('d-m-Y H:i', strtotime($slaTask->fixed_at)) : 'Not Available' }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </x-slot>

        </x-table>


    </div>
</div>
