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
    $nodata = Config::get('steps.alert.dark');

@endphp

<div style="max-height: 400px; overflow-y: auto;">
    <div class="{{ $marginTop }} mb-3">
        <div class="{{ $info }}"><span class="block text-center">To Respond By Today</span></div>
        @if ($tickets)
            <x-table>
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
                        <th class="{{ $td }}">
                            Respond By
                        </th>
                        <th class="{{ $td }}">
                            Respond At
                        </th>                        

                    </tr>
                </x-slot>
                <x-slot name="tableRows">
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="{{ $td }}">
                                <a href="{{ route('ticketProfile', ['ticket' => $ticket]) }}" target="_blank"
                                    class="{{ $link }}">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="{{ $td }}">
                                {{ $ticket->customer->name }}
                            </td>
                            <td class="{{ $td }}">
                                {{ date('d-m-Y H:i', strtotime($ticket->created_at)) }}
                            </td>
                            <td class="{{ $td }}">
                                @if($ticket->slaTasks->first()->respond_by)
                                    {{ date('d-m-Y H:i', strtotime($ticket->slaTasks->first()->respond_by)) }}
                                @else
                                    --
                                @endif
                            </td>
                            <td class="{{ $td }}">
                                @if($ticket->slaTasks->first()->responded_at)
                                    {{ date('d-m-Y H:i', strtotime($ticket->slaTasks->first()->responded_at)) }}
                                @else
                                    --
                                @endif
                            </td>                            
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        @else
            <div class="{{ $nodata  }} text-center">
                No Tickets Available
            </div>
        @endif
    </div>
</div>
