@php

    $moniker = Config::get('steps.ticket');

    $thCols = [
        [
            'name' => "{$moniker} Number",
            'field' => 'ticket_number',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Short Description',
            'field' => 'short_description',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Created At',
            'field' => 'created_at',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Created By',
            'field' => 'created_by',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Category',
            'field' => 'category',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Status',
            'field' => 'breached_at',
            'columnClasses' => '',
            'rowClasses' => '',
        ],        
    ];

    $tdClass = Config::get('steps.tableClasses.td');
    $thClass = Config::get('steps.tableClasses.th');
    $trThClass = Config::get('steps.tableClasses.colTr');
    $divTopClass = Config::get('steps.tableClasses.divTop');
    $divSeparator = Config::get('steps.tableClasses.divSeparator');

    $tdActionLink = Config::get('steps.buttonClasses.btnGrey');
    $tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');
    $tdActionLinkInfo = Config::get('steps.buttonClasses.btnBlue');


@endphp

<div class=""">


    <div class="{{ $divTopClass }}">

        <x-section-title>
            <x-slot name="title">
                Open {{ $moniker }}s
            </x-slot>
            <x-slot name="description">
                {{ $customer->name }}
            </x-slot>
        </x-section-title>

        <div class="{{ $divSeparator }}">
            &nbsp;
        </div>

        <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
            <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
        </div>

        <x-table>

            <x-slot name="tableColumns">
                <tr class="{{ $trThClass }}">
                    @foreach ($thCols as $col)
                        <th class="{{ $thClass }}">
                            {{ $col['name'] }}
                        </th>
                    @endforeach
                </tr>
            </x-slot>

            <x-slot name="tableRows">
                @foreach ($tickets as $ticket)
                    <tr>
                        <td class="{{ $tdClass }}">
                            <a href="{{ route('ticketProfile', ['ticket' => $ticket]) }}" target="_blank">
                                {{ $ticket->ticket_number }}
                            </a>
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $ticket->short_description }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $ticket->created_at }}
                        </td>
                        <td class="{{ $tdClass }}">
                            @if( $ticket->raised_by_user)
                                {{ $ticket->raised_by_user }}
                            @endif
                            @if( $ticket->raised_by_nonuser)
                                {{ $ticket->raised_by_nonuser }}
                            @endif
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $ticket->category }}
                        </td>
                        <td class="{{ $tdClass }}">
                            @php
                                $breach = false;
                                $br = $ticket->slaTasks->where('breached_at','!=', null)->first();
                                if($br){
                                    $breach = true;
                                }
                            @endphp
                            <span
                                @if($breach)
                                    class="{{ $tdActionLinkDelete }}"     
                                @else
                                    class="{{ $tdActionLinkInfo }}"
                                @endif
                            >
                            {{ $breach ? "Breached" : "Inside SLA" }}
                            </span>
                        </td>                        
                    </tr>
                @endforeach
            </x-slot>
        </x-table>

    </div>

</div>
