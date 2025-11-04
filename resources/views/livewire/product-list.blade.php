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
            'name' => 'Product Code',
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
            'name' => 'Type',
            'field' => 'type',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Make',
            'field' => 'make',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Details',
            'field' => 'details',
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
            Product List
        </x-slot>
        <x-slot name="description">
            List of Products In Service
        </x-slot>
    </x-section-title>



    <div class="{{ $divSeparator }}">
        &nbsp;
    </div>

    @if ($canEdit)
        <div class="mt-3 mb-3 px-5">
            <button type="button" class="{{ $tdActionLink }}"
                wire:click="$dispatch('openModal', {
                component: 'CreateNewProduct',
            })">
                Create New Product
            </button>
            <button type="button" class="{{ $tdActionLink }} mt-10"
                wire:click="$dispatch('openModal', {
                component: 'importProducts',
            })">
                Import Products (Excel)
            </button>
        </div>
    @endif

    <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
        <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
    </div>

    {{ $products->links() }}

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
            @if ($products)
                @foreach ($products as $row)
                    <tr wire:key="{{ $row->id }}">
                        <td class="{{ $tdClass }}">
                            {{ $row->id }}
                        </td>
                        <td class="{{ $tdClass }}">
                            @if ($displayNameColumn == $row->id && $canEdit)
                                <x-input name="name-{{ $row->id }}" value="{{ $row->name }}"
                                    wire:keydown.enter='changeName({{ $row }}, $event.target.value)'
                                    x-on:click.away="$wire.resetFields()" />
                            @else
                                <button name="button-name-{{ $row->id }}" class="{{ $link }}"
                                    wire:click='showNameField({{ $row }})'>
                                    {{ $row->name }}
                                </button>
                            @endif
                        </td>
                        <td class="{{ $tdClass }}">
                            @if ($displayProductCodeColumn == $row->id && $canEdit)
                                <x-input name="productCode-{{ $row->id }}" value="{{ $row->product_code }}"
                                    wire:keydown.enter='changeProductCode({{ $row }}, $event.target.value)'
                                    x-on:click.away="$wire.resetFields()" />
                            @else
                                <button class="{{ $link }}" name="button-productCode-{{ $row->id }}"
                                    wire:click='showProductCodeField({{ $row }})'>
                                    {{ $row->product_code }}
                                </button>
                            @endif
                        </td>
                        <td class="{{ $tdClass }}">
                            @if ($displayDescriptionColumn == $row->id && $canEdit)
                                <x-input name="description-{{ $row->id }}" value="{{ $row->short_description }}"
                                    wire:keydown.enter='changeDescription({{ $row }}, $event.target.value)'
                                    x-on:click.away="$wire.resetFields()" />
                            @else
                                <button name="button-description-{{ $row->id }}" class="{{ $link }}"
                                    wire:click='showDescriptionField({{ $row }})'>
                                    {{ Str::limit($row->short_description, 50) }}
                                </button>
                            @endif
                        </td>
                        <td class="{{ $tdClass }}">
                            @if ($displayTypeColumn == $row->id && $canEdit)
                                <x-select class="w-full"
                                    wire:change="changeType({{ $row }}, $event.target.value)"
                                    x-on:click.away="$wire.resetFields()">
                                    <x-slot name="options">
                                        <option value="{{ $row->type }}">{{ $row->type }}</option>
                                        @foreach ($productTypes as $prodType)
                                            <option value="{{ $prodType }}">{{ $prodType }} </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>
                            @else
                                <button class="{{ $link }}" name="button-type-{{ $row->id }}"
                                    wire:click='showTypeField({{ $row }})'>
                                    {{ $row->type }}
                                </button>
                            @endif
                        </td>
                        <td class="{{ $tdClass }}">
                            @if ($displayMakeColumn == $row->id && $canEdit)
                                <x-select class="w-full"
                                    wire:change="changeMake({{ $row }}, $event.target.value)"
                                    x-on:click.away="$wire.resetFields()">
                                    <x-slot name="options">
                                        <option value="{{ $row->make }}">{{ $row->make }}</option>
                                        @foreach ($manufacturers as $manuf)
                                            <option value="{{ $manuf }}">{{ $manuf }} </option>
                                        @endforeach
                                    </x-slot>
                                </x-select>
                            @else
                                <button class="{{ $link }}" name="button-make-{{ $row->id }}"
                                    wire:click='showMakeField({{ $row }})'>
                                    {{ $row->make }}
                                </button>
                            @endif
                        </td>
                        <td class="{{ $tdClass }}">
                            <button wire:click='openDetails({{ $row }})' class="{{ $link }}">
                                View Details
                            </button>
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

    @if ($flagNewProduct)
        <div>
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                <x-modal-onpage showSubmitButton='hide'>
                    <x-slot name="title">
                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Product Details:</h2>
                    </x-slot>
                    <x-slot name="modalContent">
                        <ul class="max-w-md space-y-1 text-gray-500 list-none list-inside dark:text-white">
                            <li>
                                Added: {{ $product->created_at }}
                            </li>
                            <li>
                                Name: {{ $product->name }}
                            </li>
                            <li>
                                Description: {{ $product->short_description }}
                            </li>
                            <li>
                                Product Code: {{ $product->product_code }}
                            </li>
                            <li>
                                Type: {{ $product->type }}
                            </li>
                            <li>
                                Make: {{ $product->make }}
                            </li>
                            <li>
                                Version: {{ $product->version }}
                            </li>
                        </ul>
                    </x-slot>
                </x-modal-onpage>
            </div>
        </div>
    @endif

</div>
