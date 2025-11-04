@php

    $fieldClass = 'flex flex-col pb-3';
    $labelClass = Config::get('steps.form.label');
    $valueClass = Config::get('steps.form.value');
    $whiteBox = Config::get('steps.whiteBox');
    $link = Config::get('steps.link');
    $insetBox = "block mt-3 p-3 border border-zinc-700 rounded-md border-dashed";
    $buttonEditClass =
        'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800';
    $buttonDeleteClass =
        'text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800';

@endphp

<div>
    <x-page-profile>
        <x-slot name="title">
            <span class="block text-2xl">Asset Profile</span>
            <span class="block">{{ $product->name }}</span>
        </x-slot>
        <x-slot name="nav">
            <div class="block text-4xl {{ $insetBox }} w-full dark:text-white text-center">{{ $asset->short_description }}</div>
        </x-slot>
        <x-slot name="left_panel">
            <div class="">
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Asset Number:</div>
                    <div class="{{ $valueClass }}">
                        {{ $asset->asset_number }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Customer:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->name }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('supplier')" class="{{ $labelClass }} {{ $link }}">
                            Supplier:
                        </button>
                    </div>
                    <div class="{{ $valueClass }}">
                        {{ $supplier->name }}
                    </div>
                    @if ($updateFlag == 'supplier' && $canEdit)
                        <div>
                            <x-select wire:change="updateRecord('supplier_id', $event.target.value)"
                                x-on:click.away="$wire.resetFlag()">
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                <x-slot name="options">
                                    @foreach ($suppliers as $supl)
                                        <option value="{{ $supl->id }}">{{ $supl->name }}</option>
                                    @endforeach
                                </x-slot>
                            </x-select>
                        </div>
                    @endif
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('asset_location')" class="{{ $labelClass }} {{ $link }}">
                            Asset Location:
                        </button>
                    </div>
                    <div class="{{ $valueClass }}">
                        {{ $asset->location }}
                    </div>
                    @if ($updateFlag == 'asset_location' && $canEdit)
                        <div>
                            <x-input wire:change="updateRecord('location', $event.target.value)"
                                x-on:click.away="$wire.resetFlag()" value="{{ $asset->location }}" class="mt-3">
                            </x-input>
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>
        <x-slot name="right_panel">
            <div class="">
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('asset_status')" class="{{ $labelClass }} {{ $link }}">
                            Asset Status:
                        </button>
                    </div>
                    <div class="{{ $valueClass }}">
                        {{ $asset->active ? 'Active' : 'Not Active' }}
                    </div>
                    @if ($updateFlag == 'asset_status' && $canEdit)
                        <x-button type="button" class="mt-3"
                            wire:click="updateRecord('active',{{ $asset->active }})"
                            x-on:click.away="$wire.resetFlag()">
                            Change Status
                        </x-button>
                    @endif
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('buy_price')" class="{{ $labelClass }} {{ $link }}">
                            Buy Price:
                        </button>
                    </div>
                    <div class="{{ $valueClass }}">
                        &pound; {{ $asset->buy_price }}
                    </div>
                    @if ($updateFlag == 'buy_price' && $canEdit)
                        <x-input wire:change="updateRecord('buy_price',$event.target.value)"
                            x-on:click.away="$wire.resetFlag()" value="{{ $asset->buy_price }}" class="mt-3">
                        </x-input>
                    @endif
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('sell_price')" class="{{ $labelClass }} {{ $link }}">
                            Sell Price:
                    </div>
                    <div class="{{ $valueClass }}">
                        &pound; {{ $asset->sell_price }}
                    </div>
                    @if ($updateFlag == 'sell_price' && $canEdit)
                        <x-input wire:change="updateRecord('sell_price',$event.target.value)"
                            x-on:click.away="$wire.resetFlag()" value="{{ $asset->sell_price }}" class="mt-3">
                        </x-input>
                    @endif
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('license_number')" class="{{ $labelClass }} {{ $link }}">
                            License:
                        </button>
                    </div>
                    <div class="{{ $valueClass }}">
                        {{ $asset->license_number }}
                    </div>
                    @if ($updateFlag == 'license_number' && $canEdit)
                        <x-input wire:change="updateRecord('license_number', $event.target.value)"
                            x-on:click.away="$wire.resetFlag()" value="{{ $asset->license_number }}" class="mt-3">
                        </x-input>
                    @endif
                </div>
            </div>
        </x-slot>
        <x-slot name="bottom_panel">
            <div class="{{ $whiteBox }}">
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('ip_address')" class="{{ $labelClass }} {{ $link }}">
                            IP Address:
                        </button>
                    </div>
                    <div class="{{ $valueClass }}">
                        {{ $asset->ip_address }}
                    </div>
                    @if ($updateFlag == 'ip_address' && $canEdit)
                        <x-input wire:change="updateRecord('ip_address',$event.target.value)"
                            x-on:click.away="$wire.resetFlag()" value="{{ $asset->ip_address }}" class="mt-3">
                        </x-input>
                    @endif
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('mac_address')" class="{{ $labelClass }} {{ $link }}">
                            Mac Address:
                        </button>
                    </div>
                    <div class="{{ $valueClass }}">
                        {{ $asset->mac_address }}
                    </div>
                    @if ($updateFlag == 'mac_address' && $canEdit)
                        <x-input wire:change="updateRecord('mac_address',$event.target.value)"
                            x-on:click.away="$wire.resetFlag()" value="{{ $asset->mac_address }}" class="mt-3">
                        </x-input>
                    @endif
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="">
                        <button wire:click="setUpdateFlag('tech_spec')" class="{{ $labelClass }} {{ $link }}">
                            Technical Specification:
                        </button>

                    </div>
                    <div class="{{ $valueClass }}">
                        {{ $asset->technical_specifications }}
                    </div>
                    @if ($updateFlag == 'tech_spec' && $canEdit)
                        <x-text wire:change="updateRecord('technical_specifications',$event.target.value)"
                            x-on:click.away="$wire.resetFlag()" class="w-full mt-3">
                            <x-slot name="textValue">
                                {{ $asset->technical_specifications }}
                            </x-slot>
                        </x-text>
                    @endif
                </div>
            </div>
        </x-slot>
    </x-page-profile>

    <div class="h-7 mb-10">&nbsp;</div>

</div>
