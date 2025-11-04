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

    $td = "$td align-top";
@endphp

<div style="max-height: 400px; overflow-y: auto;">
    <div class="{{ $marginTop }} mb-3">
        <div class="{{ $info }}"><span class="block text-center">Unresponded Comments</span></div>
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
                        Created By
                    </th>
                    <th class="{{ $td}}"> 
                        Created At
                    </th>
                    <th class="{{ $td}}"> 
                        Log        
                    </th>
                </tr>
            </x-slot>
            <x-slot name="tableRows">
                @foreach($taskLogs as $task)
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
                        {{ $task->ticket->customer->name }}
                    </td>
                    <td class="{{ $td }}">
                        {{ $task->user_id ? $task->user_id : $task->external_user }}
                    </td>   
                    <td class="{{ $td }}">
                        {{ date('d-m-Y H:i', strtotime($task->created_at)) }}
                    </td>
                    <td>
                        {{ $task->description }}
                        &nbsp;
                        [ <a 
                            class="{{ $link }}"
                            href="#"
                            wire:click="$dispatch('openModal', { 
                                component: 'progressLogTimeline', 
                                arguments: {ticket:{{ $task->ticket }}}
                            })"
                        >More</a> ]    
                    </td>
                </tr>
                @endforeach
            </x-slot>
        </x-table>
    </div>
</div>
