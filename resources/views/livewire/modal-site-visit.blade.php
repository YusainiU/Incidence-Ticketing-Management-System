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
        <div class="{{ $info }}"><span class="block text-center">Outstanding Site Visits</span></div>
        @if($visits)
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
                            Scheduled At
                        </th>
                        <th class="{{ $td }}">
                            Visit Assigned To
                        </th>
                    </tr>
                </x-slot>
                <x-slot name="tableRows">
                    @foreach($visits as $visit)
                        <tr>
                            <td class="{{ $td }}">
                                <a 
                                    href="{{ route('ticketProfile', ['ticket' => $visit->ticket]) }}" 
                                    target="_blank"
                                    class="{{ $link }}"
                                >                                
                                    {{ $visit->ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="{{ $td }}">
                                {{ $visit->ticket->customer->name }}
                            </td>
                            <td class="{{ $td }}">
                                {{ $visit->visit_scheduled_at ? date('d-m-Y H:i', strtotime($visit->visit_scheduled_at)) : null  }}
                            </td>
                            <td class="{{ $td }}">
                                {{ $visit->assigned_to ? $visit->assignedTo->name : null }}
                            </td>                                                        
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        @endif
    </div>
</div>
