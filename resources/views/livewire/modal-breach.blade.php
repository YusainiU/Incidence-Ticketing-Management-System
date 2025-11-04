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
    $moniker = Config::get('steps.ticket');

@endphp
<div style="max-height: 400px; overflow-y: auto;">
    <div class="{{ $marginTop }} mb-3">
        <div class="{{ $info }}"><span class="block text-center">SLA Breach </span></div>
        @if($slaTasks)
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
                            Breached At
                        </th>
                        <th class="{{ $td }}">
                            Respond by Breach At
                        </th>
                        <th class="{{ $td }}">
                            Fix By Breach At
                        </th>
                    </tr>
                </x-slot>
                <x-slot name="tableRows">                
                    @foreach($slaTasks as $task)
                        <tr>
                            <td class="{{ $td }}">
                                <a 
                                    href="{{ route('ticketProfile', ['ticket' => $task->ticket]) }}" 
                                    target="_blank"
                                    class="{{ $link }}"
                                >                                
                                    {{ $task->ticket->ticket_number }}
                                </a>
                            </td>                            
                            <td class="{{ $td }}">
                                {{  $task->ticket->customer->name }}
                            </td>                            
                            <td class="{{ $td }}">
                                {{ date('d-m-Y H:i', strtotime($task->breached_at)) }}
                            </td>                            
                            <td class="{{ $td }}">
                                {{ $task->respond_by_breach_at ? date('d-m-Y H:i', strtotime($task->respond_by_breach_at)) : null}}
                            </td>
                            <td class="{{ $td }}">
                                {{ $task->fix_by_breach_at ? date('d-m-Y H:i', strtotime($task->fix_by_breach_at)) : null}}
                            </td>                            
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        @endif
    </div>
</div>
