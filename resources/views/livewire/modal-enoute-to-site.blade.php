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
        <div class="{{ $info }}"><span class="block text-center">Currently Enroute to Site</span></div>
        @if($enroutes)
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
                            Enroute At
                        </th>
                        <th class="{{ $td }}">
                            Visit Assigned To
                        </th>
                    </tr>
                </x-slot>
                <x-slot name="tableRows">
                    @foreach($enroutes as $enroute)
                        <tr>
                            <td class="{{ $td }}">
                                <a 
                                    href="{{ route('ticketProfile', ['ticket' => $enroute->ticket]) }}" 
                                    target="_blank"
                                    class="{{ $link }}"
                                >                                
                                    {{ $enroute->ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="{{ $td }}">
                                {{ $enroute->ticket->customer->name }}
                            </td>
                            <td class="{{ $td }}">
                                {{ $enroute->enroute_at ? date('d-m-Y H:i', strtotime($enroute->enroute_at)) : null  }}
                            </td>
                            <td class="{{ $td }}">
                                {{ $enroute->assigned_to ? $enroute->assignedTo->name : null }}
                            </td>                                                        
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        @endif
    </div>
</div>

