@php
    $thCols = [
        [
            'name' => 'Name',
            'field' => 'name',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Description',
            'field' => 'short_description',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Type',
            'field' => 'Task Type',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Respond By',
            'field' => 'respond_by',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Fix By',
            'field' => 'fix_by',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Breach',
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

<div id="{{ $selectedTab }}">
    <div class="{{ $divTopClass }}">
        <x-section-title>
            <x-slot name="title">
                Tasks
            </x-slot>
            <x-slot name="description">
                Service Level Agreement
            </x-slot>
        </x-section-title>

        <div class="{{ $divSeparator }}">
            &nbsp;
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
                @foreach($tasks as $task)
                    <tr>
                        <td class="{{ $tdClass }}">
                            {{ $task->name }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $task->short_description }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $task->task_type }}
                        </td>                        
                        <td class="{{ $tdClass }}">
                            {{ $task->getDateInDMY($task->respond_by) }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $task->getDateInDMY($task->fix_by) }}
                        </td>
                        <td class="{{ $tdClass }}">
                            @if($task->checkIfBreach($task->breached_at))
                                <span class="{{ $tdActionLinkDelete }}">
                                    {{ $ticketStatusInformation["breachType"] }}
                                </span>
                            @else
                                <span class="{{ $tdActionLinkInfo }}">Inside SLA</span>
                            @endif
                        </td>                                                                          
                    </tr>
                @endforeach
            </x-slot>
        </x-table>

    </div>
</div>
