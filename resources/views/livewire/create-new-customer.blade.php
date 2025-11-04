
<div x-data="{ main_customer: '' }">
    <x-modal-steps>
        <x-slot name="title">
            Create New Customer
        </x-slot>
        <x-slot name="modalContent">
            <div class="grid gap-4 grid-cols-1 content-start">
                <div class="">
                    <x-label value="Name" class="mb-2"></x-label>
                    <x-input name="name" class="w-full" wire:model='name' />
                    <div>
                        @error('name')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Type" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='type' x-on:change="main_customer = $event.target.value">
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
                        @error('type')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>                    
                </div>
                <div class="" x-show="main_customer == 'child_company'">
                    <x-label value="Child Type" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='child'>
                        <x-slot name="options">
                            <option value="">--- SELECT TYPE ---</option>
                            @if ($options_type)
                                @foreach ($options_child as $optKey => $optVal)
                                    <option value="{{ $optVal }}">
                                        {{ \App\Enums\CustomerChildTypes::toName($optVal) }}
                                    </option>
                                @endforeach
                            @endif
                        </x-slot>
                    </x-select>
                    <div>
                        @error('child')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>                    
                </div>
                <div class="">
                    <x-label value="Short Description" class="mb-2"></x-label>
                    <x-text name="short_description" class="w-full" wire:model='short_description'>
                        <x-slot name="textValue">

                        </x-slot>
                    </x-text>
                </div>
            </div>
        </x-slot>
        <x-slot name="buttonActionName">
            Create
        </x-slot>
    </x-modal-steps>
</div>
