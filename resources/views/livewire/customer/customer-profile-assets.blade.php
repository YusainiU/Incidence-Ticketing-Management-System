@php
    $thCols = [
        [
            'name' => 'Asset',
            'field' => 'short_description',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Asset Number',
            'field' => 'asset_number',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Product',
            'field' => 'product_id',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Supplier',
            'field' => 'supplier_id',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Location',
            'field' => 'location',
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
<div x-data="{ slapName: '' }">
    <div class="{{ $divTopClass }}">
        <x-section-title>
            <x-slot name="title">
                Customer Assets
            </x-slot>
            <x-slot name="description">
                {{ $customer->name }}
            </x-slot>
        </x-section-title>

        <div class="{{ $divSeparator }}">
            &nbsp;
        </div>

        <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
            <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
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
                @if ($assets)
                    @foreach ($assets as $asset)
                        <tr>
                            <td class="{{ $tdClass }}">
                                {{ $asset->short_description }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $asset->asset_number }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $asset->product->name }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $asset->supplier->name }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $asset->location }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </x-slot>

        </x-table>

    </div>
</div>

