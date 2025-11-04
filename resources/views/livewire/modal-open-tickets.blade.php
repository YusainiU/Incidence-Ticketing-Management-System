@php
    $table = Config::get('steps.tableClasses.table');
    $tbody = Config::get('steps.tableClasses.tbody');
    $thead = Config::get('steps.tableClasses.thead');
    $th = Config::get('steps.tableClasses.th');
    $td = Config::get('steps.tableClasses.td');
    $thAlign = Config::get('steps.tableClasses.colTr');
    $marginTop = Config::get('steps.tableClasses.divTop');

    $info = Config::get('steps.alert.info');
    $link = Config('steps.link');
    $moniker = Config::get('steps.ticket');

@endphp

<div style="max-height: 400px; overflow-y: auto;">
    <div class="{{ $marginTop }} mb-3">
        <div class="{{ $info }}"><span class="block text-center">All Open {{ $moniker }}s</span></div>
        <x-table class="{{ $table }}">
            <x-slot name="tableColumns">
                <tr>
                    <th class="{{ $td }}">
                        Ref #
                    </th>
                    <th class="{{ $td }}">
                        Site
                    </th>
                    <th class="{{ $td }}"> 
                        Created At
                    </th>
                    <th class="{{ $td}}"> 
                        Assigned To
                    </th>                                                            
                </tr>
            </x-slot>
            <x-slot name="tableRows">
                @foreach($tickets as $ticket)
                <tr>
                    <td class="{{ $td }}">
                        <a 
                            href="{{ route('ticketProfile', ['ticket' => $ticket]) }}" 
                            target="_blank"
                            class="{{ $link }}"
                        >
                            {{ $ticket->ticket_number }}
                        </a>
                    </td>
                    <td class="{{ $td }}">
                        {{ $ticket->customer->name }}
                    </td>
                    <td class="{{ $td }}">
                        {{ date('d-m-Y H:i',strtotime($ticket->created_at)) }}
                    </td>   
                    <td class="{{ $td }}">
                        @if($ticket->assigned_to)
                            {{ $ticket->assigned_to }}
                        @else
                            Unassigned
                        @endif
                    </td>                                                            
                </tr>
                @endforeach
            </x-slot>
        </x-table>
    </div>
</div>
