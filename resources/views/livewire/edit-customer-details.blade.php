@php
    $text = Config::get('steps.standardTextColor');
@endphp

<div>
    <x-modal-steps>
        <x-slot name="title">
            Edit Customer Details
        </x-slot>

        <x-slot name="modalContent">
            <div class="w-full" x-data="{ main_customer: '', current_main_type:'{{ $primary_type }}' }">
                <div class="max-w-full">
                    <div class="max-w-full">
                        <x-label value="Name" class="mb-2"></x-label>
                        <x-input name="name" class="w-full" wire:model='name' />
                        <div>
                            @error('name')
                                <span class="text-red-600 dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="flex flex-row gap-2 mt-4">
                    <div class="">
                        <x-label value="Type" class="mb-2"></x-label>
                        <x-select class="w-full" wire:model='primary_type'
                            x-on:change="main_customer = $event.target.value">
                            <x-slot name="options">
                                <option value="">--- SELECT TYPE ---</option>
                                @if ($options_type)
                                    @foreach ($options_type as $optKey => $optVal)
                                        <option value="{{ $optVal }}">
                                            {{ \App\Enums\CustomerPrimaryTypes::toName($optVal) }}
                                        </option>
                                    @endforeach
                                @endif
                            </x-slot>
                        </x-select>
                        <div>
                            @error('primary_type')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="" x-show="main_customer == 'child_company' || current_main_type == 'child_company'">
                        <x-label value="Child Type" class="mb-2"></x-label>
                        <x-select class="w-full" wire:model='child_type'>
                            <x-slot name="options">
                                <option value="">--- SELECT TYPE ---</option>
                                @if ($options_type)
                                    @foreach ($options_child as $optKey => $optVal)
                                        <option value="{{ $optVal }}">
                                            {{ \App\Enums\CustomerChildTypes::toName($optVal) }}</option>
                                    @endforeach
                                @endif
                            </x-slot>
                        </x-select>
                        <div>
                            @error('child_type')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                @if (sizeof($customers))
                    <div class="mt-4" x-show="main_customer == 'child_company' || current_main_type == 'child_company'">
                        <x-label value="Parent Company" class="mb-2"></x-label>
                        <x-searchable-dropdown :options="$customers" property="parent_company" >
                        <input hidden wire:model='parent_company' id="parent_company" />
                        <div>
                            @error('parent_company')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                        </x-searchable-dropdown>
                    </div>
                @endif
                <div class="flex flex-row gap-2 mt-4">
                    <div class="">
                        <x-label value="Address 1" class="mb-2"></x-label>
                        <x-input name="address_1" class="max-w-full" wire:model='address_1' />
                        <div>
                            @error('address_1')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="">
                        <x-label value="Address 2" class="mb-2"></x-label>
                        <x-input name="address_2" class="w-full" wire:model='address_2' />
                        <div>
                            @error('address_2')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="">
                        <x-label value="Address 3" class="mb-2"></x-label>
                        <x-input name="address_3" class="w-full" wire:model='address_3' />
                        <div>
                            @error('address_3')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="">
                        <x-label value="Telephone" class="mb-2"></x-label>
                        <x-input name="telephone" class="w-full" wire:model='telephone_1' />
                        <div>
                            @error('telephone_1')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="">
                        <x-label value="URL" class="mb-2"></x-label>
                        <x-input name="url" class="w-full" wire:model='url' />
                        <div>
                            @error('url')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                <div class="mt-4">
                    <div class="">
                                                
                        <x-checkbox name="url" class="w-full" wire:model='portal_enabled' />
                        <label class="text-dark dark:{{ $text }} align-middle">Portal Enabled</label>
                        <div>
                            @error('portal_enabled')
                                <span class="text-red-600  dark:{{ $text }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>                    
                </div>
            </div>
        </x-slot>

        <x-slot name="buttonActionName">
            Update
        </x-slot>

    </x-modal-steps>
</div>
