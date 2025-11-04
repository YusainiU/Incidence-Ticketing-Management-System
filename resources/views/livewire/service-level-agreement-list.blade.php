@php
    $thCols = [
        [
            'name' => 'Name',
            'field' => 'name',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'SLA Key',
            'field' => 'product_code',
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
            'name' => 'Days Covered',
            'field' => 'start_day',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Times Covered',
            'field' => 'service_start_time',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Public Holiday?',
            'field' => 'include_public_holiday',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Type',
            'field' => 'type',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Status',
            'field' => 'active',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => '',
            'field' => '',
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

@endphp

<div class="{{ $divTopClass }}">
    <x-section-title>
        <x-slot name="title">
            Service Level Agreement List
        </x-slot>
        <x-slot name="description">
            List of Service Level Agreement (SLA)
        </x-slot>
    </x-section-title>

    <div class="{{ $divSeparator }}">
        &nbsp;
    </div>

    @if ($canEdit)
        <div class="mt-3 mb-3 px-5">
            <button type="button" class="{{ $tdActionLink }}"
                wire:click="$dispatch('openModal', {
                component: 'CreateNewServiceLevelAgreement',
            })">
                Create New Service Level Agreement
            </button>
        </div>
    @endif

    <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
        <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
    </div>

    {{ $slas->links() }}

    <x-table>

        <x-slot name="tableColumns">
            <tr class="{{ $trThClass }}">
                @foreach ($thCols as $col)
                    <th class="{{ $thClass }}">
                        {{ $col['name'] }}
                    </th>
                @endforeach
                <th class="{{ $trThClass }}">
                    &nbsp;
                <th>
            </tr>
        </x-slot>

        <x-slot name="tableRows">
            @if ($slas)
                @foreach ($slas as $row)
                    <tr wire:key="{{ $row->id }}">
                        <td class="{{ $tdClass }}">
                            {{ $row->name }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $row->sla_key }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $row->short_description }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $row->start_day }} - {{ $row->end_day }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $row->service_start_time['formatted'] }} -
                            {{ $row->service_end_time['formatted'] }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $row->include_public_holiday }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $row->type }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ App\Models\serviceLevelAgreement::displayStatus($row->active) }}
                        </td>
                        <td class="{{ $tdClass }}">
                            @if($canEdit)
                            <x-button name="Edit"
                                wire:click="$dispatch('openModal', {
                                    component: 'EditServiceLevelAgreement',
                                    arguments: {sla:{{ $row }}},
                                })">
                                Edit
                            </x-button>
                            @else
                                No Permission
                            @endif

                        </td>
                    </tr>
                @endforeach
            @endif
        </x-slot>

    </x-table>

</div>
