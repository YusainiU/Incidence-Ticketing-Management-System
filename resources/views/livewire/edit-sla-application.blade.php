<div>
    <x-modal-steps>
        <x-slot name="title">
            <span class="block">Edit Service Level Agreement</span>
            <span class="block text-sm">{{ $customer->name }}</span>
        </x-slot>
        <x-slot name="modalContent">
            <div class="grid gap-4 grid-cols-2 content-start">
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
                    <x-label value="Short Description" class="mb-2"></x-label>
                    <x-input name="short_description" class="w-full" wire:model='short_description' />
                    <div>
                        @error('short_description')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Service Level Agreement" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='service_level_agreement_id'>
                        <x-slot name="options">
                            <option value="">--- SELECT SLA ---</option>
                            @foreach ($slas as $sla)
                                <option value="{{ $sla->id }}">
                                    {{ $sla->name }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <div>
                        @error('end_day')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    &nbsp;        
                </div>
                <div class="">
                    <label>
                        <x-checkbox name="active" class="mr-2" wire:model='active' />
                        Active
                    </label>
                </div>                                
            </div>
        </x-slot>
        <x-slot name="buttonActionName">
            Update
        </x-slot>
    </x-modal-steps>
</div>
