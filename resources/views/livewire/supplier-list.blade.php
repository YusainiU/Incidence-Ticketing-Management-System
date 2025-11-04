@php
    $thCols = [
        [
            'name' => 'ID',
            'field' => 'id',
            'columnClasses' => '',
            'rowClasses' => '',
        ],

        [
            'name' => 'Name',
            'field' => 'name',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Address',
            'field' => 'address_1',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Status',
            'field' => 'active',
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

<div>
    <div class="{{ $divTopClass }}">

        <x-section-title>
            <x-slot name="title">
                Suppliers List
            </x-slot>
            <x-slot name="description">
                List of currently active Suppliers
            </x-slot>
        </x-section-title>

        <div class="{{ $divSeparator }}">
            &nbsp;
        </div>

        @if ($canEdit)
            <div class="mt-3 mb-3 px-5">
                <button type="button" class="{{ $tdActionLink }}"
                    wire:click="$dispatch('openModal', {
                component: 'CreateNewSupplier',
            })">
                    Create New Supplier
                </button>
            </div>
        @endif

        <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
            <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
        </div>

        {{ $suppliers->links() }}

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
                @if ($suppliers)
                    @foreach ($suppliers as $row)
                        <tr wire:key="{{ $row->id }}">
                            <td class="{{ $tdClass }}">
                                {{ $row->id }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $row->name }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $row->address_1 }}
                            </td>
                            <td class="{{ $tdClass }}">
                                @if($canEdit)
                                <a href="#" wire:click='setActiveStatus({{ $row }})'>
                                    @if ($row->active)
                                        <span class="text-blue-700">Active</span>
                                    @else
                                        <span class="text-red-700">Not Active</span>
                                    @endif
                                </a>
                                @else
                                    {{ $row->active ? 'Active' : 'Not Active' }}
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

        {{ $suppliers->links() }}

    </div>
    @if ($flagNewSupplier)
        <div>
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <x-modal-onpage showSubmitButton='hide'>
                    <x-slot name="title">
                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Supplier Details:</h2>
                    </x-slot>
                    <x-slot name="modalContent">
                        <ul class="w-full space-y-1 text-gray-500 list-none list-inside dark:text-gray-400">
                            <li>
                                Added: {{ $supplier->created_at }}
                            </li>
                            <li>
                                Name: {{ $supplier->name }}
                            </li>
                            <li>
                                Address 1: {{ $supplier->address_1 }}
                            </li>
                            <li>
                                Address 2: {{ $supplier->address_2 }}
                            </li>
                            <li>
                                Address 3: {{ $supplier->address_3 }}
                            </li>
                            <li>
                                Address 4: {{ $supplier->address_4 }}
                            </li>
                            <li>
                                Telephone: {{ $supplier->telephone }}
                            </li>
                            <li>
                                Email: {{ $supplier->email }}
                            </li>
                            <li>
                                URL: {{ $supplier->url }}
                            </li>
                        </ul>
                    </x-slot>
                </x-modal-onpage>
            </div>
        </div>
    @endif

</div>
