@php
    $text = Config::get('steps.standardTextColor');
@endphp

<div>
    <x-modal-steps>
        <x-slot name="title">
            Create New Asset
        </x-slot>
        <x-slot name="modalContent">
            <div class="grid gap-4 grid-cols-2 content-start">
                <div class="">
                    <x-label value="Asset Name" class="mb-2"></x-label>
                    <x-input name="short_description" class="w-full" wire:model='short_description' />
                    <div>
                        @error('short_description')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Product" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='product_id'>
                        <x-slot name="options">
                            <option value="">--- SELECT TYPE ---</option>
                            @if ($listOfProducts)
                                @foreach ($listOfProducts as $optVal)
                                    <option value="{{ $optVal['id'] }}">
                                        {{ $optVal['name'] }}
                                    </option>
                                @endforeach
                            @endif
                        </x-slot>
                    </x-select>
                    <div>
                        @error('product_id')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Supplier" class="mb-2"></x-label>
                    <x-searchable-dropdown :options="$listOfSuppliers" property="supplier_id" />
                    <div>
                        @error('supplier_id')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @if (!$withCompanyId)
                    <div class="">
                        <x-searchable-dropdown :options="$listOfCustomers" property="customer_id" />
                        <div>
                            @error('customer_id')
                                <span class="text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif
                <div class="">
                    <x-label value="Buy Price" class="mb-2"></x-label>
                    <x-input name="buy_price" class="w-full" wire:model='buy_price' />
                    <div>
                        @error('buy_price')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Sell Price" class="mb-2"></x-label>
                    <x-input name="sell_price" class="w-full" wire:model='sell_price' />
                    <div>
                        @error('sell_price')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Asset Location" class="mb-2"></x-label>
                    <x-input name="location" class="w-full" wire:model='location' />
                    <div>
                        @error('location')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="License Number" class="mb-2"></x-label>
                    <x-input name="license_number" class="w-full" wire:model='license_number' />
                    <div>
                        @error('license_number')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="IP Address" class="mb-2"></x-label>
                    <x-input name="ip_address" class="w-full" wire:model='ip_address' />
                    <div>
                        @error('ip_address')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Mac Address" class="mb-2"></x-label>
                    <x-input name="mac_address" class="w-full" wire:model='mac_address' />
                    <div>
                        @error('mac_address')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="grid gap-4 grid-cols-1 content-start">
                <div class="">
                    <x-label value="Technical Specifications" class="mb-2"></x-label>
                    <x-text name="technical_specifications" class="w-full" wire:model='technical_specifications'>
                        <x-slot name="textValue">

                        </x-slot>
                    </x-text>
                </div>
                <div class=" {{ $text }}">
                    <x-checkbox name="active" class="mr-2" wire:model='active' />
                    Active
                </div>
            </div>
        </x-slot>
        <x-slot name="buttonActionName">
            Create
        </x-slot>
    </x-modal-steps>
</div>
