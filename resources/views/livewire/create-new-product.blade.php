<div>
    <x-modal-steps>
        <x-slot name="title">
            {{ $title }}
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
                    <x-label value="Product Code" class="mb-2"></x-label>
                    <x-input name="product_code" class="w-full" wire:model='product_code' />
                    <div>
                        @error('product_code')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Model" class="mb-2"></x-label>
                    <x-input name="model" class="w-full" wire:model='model' />
                    <div>
                        @error('model')
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
                <div class="">
                    <x-label value="Make" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='make'>
                        <x-slot name="options">
                            <option value="">--- SELECT TYPE ---</option>
                            @foreach ($productMakes as $make)
                                <option value="{{ $make }}">
                                    {{ $make }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <div>
                        @error('make')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Type" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='type'>
                        <x-slot name="options">
                            <option value="">--- SELECT TYPE ---</option>
                            @foreach ($productTypes as $type)
                                <option value="{{ $type }}">
                                    {{ $type }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <div>
                        @error('type')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Version" class="mb-2"></x-label>
                    <x-input name="version" class="w-full" wire:model='version' />
                    <div>
                        @error('version')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
        </x-slot>
        <x-slot name="buttonActionName">
            Create
        </x-slot>
    </x-modal-steps>

</div>
