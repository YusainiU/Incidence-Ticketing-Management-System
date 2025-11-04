@php
    $thCols = [
        [
            'name' => 'Name',
            'field' => 'name',
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
            'name' => 'Description',
            'field' => 'description',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Parent',
            'field' => 'parent',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Status',
            'field' => 'status',
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
    $link = Config::get('steps.link');

@endphp


<div class="{{ $divTopClass }}">

    <x-section-title>
        <x-slot name="title">
            Customer List
        </x-slot>
        <x-slot name="description">
            List of currently active customers
        </x-slot>
    </x-section-title>

    <div class="{{ $divSeparator }}">
        &nbsp;
    </div>

    @if ($canEdit)
        <div class="mt-3 mb-3 px-5">
            <button type="button" class="{{ $tdActionLink }}"
                wire:click="$dispatch('openModal', {
                component: 'CreateNewCustomer',
            })">
                Create New Customer
            </button>
        </div>
    @endif

    <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
        <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
    </div>

    {{ $customers->links() }}

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
            @if ($customers)
                @foreach ($customers as $row)
                    <tr>
                        <td class="{{ $tdClass }}">
                            <a href="{{ route('customerProfile', ['customer' => $row]) }}" class="{{ $link }}">
                                {{ $row->name }}
                            </a>
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ \App\Enums\CustomerPrimaryTypes::toName($row->primary_type->toString()) }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ Str::limit($row->short_description, 50) }}
                        </td>
                        <td class="{{ $tdClass }}">
                            @if ($row->parent_company)
                                {{ $row->getParent($row->parent_company)->name }}
                            @else
                                --
                            @endif
                        </td>
                        <td class="{{ $tdClass }}">
                            @if ($row->active)
                                <span class="text-blue-700">Active</span>
                            @else
                                <span class="text-red-700">Not Active</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="100%" class="text-center py-10 px-4 text-sm">
                        No records found
                    </td>
                </tr>
            @endif
        </x-slot>
    </x-table>
    {{ $customers->links() }}
</div>
