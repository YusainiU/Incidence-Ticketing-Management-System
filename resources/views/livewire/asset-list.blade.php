@php

    $th = Config::get('steps.tableClasses.th');
    $td = Config::get('steps.tableClasses.td');
    $link = Config::get('steps.link');
    $thAlign = Config::get('steps.tableClasses.colTr');
    $marginTop = Config::get('steps.tableClasses.divTop');
    $btnBlue = Config::get('steps.buttonClasses.btnBlue');
    $rootDiv = 'relative overflow-hidden shadow-md rounded-lg';
    $divSeparator = Config::get('steps.tableClasses.divSeparator');
    $dropDownButton = Config::get('steps.buttonClasses.btnToggleLink');
    $dropDownContent = Config::get('steps.buttonClasses.btnToggleContent');
    $input =
        'appearance-none block w-32 py-1 px-3 bg-gray-200 text-gray-700 border focus:outline-none focus:bg-white focus:border-gray-500';
    $inpDiv = 'flex flex-col gap-1';
    $insetBox = 'block text-zinc-950 mt-3 ml-9 p-3 border border-zinc-700 rounded-md border-dashed bg-zinc-100';

@endphp

<div class="{{ $rootDiv }}">

    <x-section-title>
        <x-slot name="title">
            Assets
        </x-slot>
        <x-slot name="description">
            List of Assets
        </x-slot>
    </x-section-title>

    <div class="{{ $divSeparator }}">
        &nbsp;
    </div>

    {{-- <div>
        <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
            <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
        </div>
    </div> --}}

    @if ($this->currentFilter)
        <div class="mt-3 mb-3 px-5 w-full flex flex-row justify-center">
            <span class="{{ $insetBox }} font-bold">
                Filter for {{ $this->triggerFilter }}: "{{ $this->currentFilter }}"
            </span>
        </div>
    @endif

    <div class="mt-3 mb-3 flex flex-row-reverse justify-between gap-x-6 py-5 px-5">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button type="button" class="{{ $dropDownButton }}">
                    Toggle
                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link wire:click.prevent="toggleActive('all')" class="cursor-pointer">
                    Show All
                </x-dropdown-link>
                <x-dropdown-link wire:click.prevent="toggleActive('active')" class="cursor-pointer">
                    Show Active
                </x-dropdown-link>
                <x-dropdown-link wire:click.prevent="toggleActive('notActive')" class="cursor-pointer">
                    Show Not Active
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    </div>    

    <div class="mt-3 mb-3 px-5">
        {{ $assets->links() }}
    </div>

    <div class="px-5">
        <x-table>
            <x-slot name="tableColumns">
                <tr class="{{ $thAlign }}">
                    <th class="{{ $th }}">
                        <div class="{{ $inpDiv }}">
                            <span>Asset #</span>
                            <input wire:model='filterByAsset' class="{{ $input }}"
                                wire:keydown.enter='filterAsset' />
                        </div>
                    </th>
                    <th class="{{ $th }}">
                        <div class="{{ $inpDiv }}">
                            <span>Short Description</span>
                            <input wire:model='filterByDescription' class="{{ $input }}"
                                wire:keydown.enter='filterDescription' />
                        </div>
                    </th>
                    <th class="{{ $th }}">
                        <div class="{{ $inpDiv }}">
                            <span>Product</span>
                            <input wire:model='filterByProduct' class="{{ $input }}"
                                wire:keydown.enter='filterProduct' />
                        </div>
                    </th>
                    <th class="{{ $th }}">
                        <div class="{{ $inpDiv }}">
                            <span>Supplier</span>
                            <input wire:model='filterBySupplier' class="{{ $input }}"
                                wire:keydown.enter='filterSupplier' />
                        </div>
                    </th>
                    <th class="{{ $th }}">
                        <div class="{{ $inpDiv }}">
                            <span>Customer</span>
                            <input wire:model='filterByCustomer' class="{{ $input }}"
                                wire:keydown.enter='filterCustomer' />
                        </div>
                    </th>
                    <th class="{{ $th }}">
                        Active
                    </th>
                </tr>
            </x-slot>
            <x-slot name="tableRows">
                @if ($assets)
                    @foreach ($assets as $asset)
                        <tr class="{{ $thAlign }}">
                            <td class="{{ $td }} align-top">
                                <a href="{{ route('assetProfile',['asset' => $asset]) }}" target="_blank" class="{{ $link }}">
                                    {{ $asset->asset_number }}
                                </a>
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ mb_strimwidth($asset->short_description, 0, 30, '...') }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ $asset->product->name }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ $asset->supplier->name }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ $asset->customer->name }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ $asset->active ? 'Active' : ' -- ' }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </x-slot>
        </x-table>

    </div>


</div>
