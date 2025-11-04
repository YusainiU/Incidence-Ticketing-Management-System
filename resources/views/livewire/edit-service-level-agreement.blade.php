@php
    $label = Config::get('steps.form.label');
    $checkbox = Config::get('steps.form.checkbox');
@endphp

<div>
    <x-modal-steps>
        <x-slot name="title">
            Edit Service Level Agreement
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
                    <x-label value="Start Day" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='start_day'>
                        <x-slot name="options">
                            <option value="">--- SELECT DAY ---</option>
                            @foreach ($daysOfWeek as $dayName)
                                <option value="{{ $dayName }}">
                                    {{ $dayName }}
                                </option>
                            @endforeach
                        </x-slot>
                    </x-select>
                    <div>
                        @error('start_day')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="End Day" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='end_day'>
                        <x-slot name="options">
                            <option value="">--- SELECT DAY ---</option>
                            @foreach ($daysOfWeek as $dayName)
                                <option value="{{ $dayName }}">
                                    {{ $dayName }}
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
                    <x-label value="Service Start" class="mb-2"></x-label>
                    <x-input type="time" name="service_start_time" class="w-full" wire:model='service_start_time' />
                    <div>
                        @error('servie_start_time')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Service End" class="mb-2"></x-label>
                    <x-input type="time" name="service_end_time" class="w-full" wire:model='service_end_time' />
                    <div>
                        @error('servie_end_time')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Response Time" class="mb-2"></x-label>
                    <div class="flex gap-2">
                        <x-input type="number" min="0" step="1" name="response_time_hours" class="w-full" wire:model='response_time_hours' />
                        <span>:</span>
                        <x-input type="number" min="0" max="59" name="response_time_mins" class="w-full" wire:model='response_time_mins' />
                    </div>
                    <div>
                        @error('response_time_hours')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        @error('response_time_mins')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>                    

                </div>
                <div class="">
                    <x-label value="Fixed Time" class="mb-2"></x-label>
                    <div class="flex gap-2">
                        <x-input type="number" min="0" step="1" name="fixed_time_hours" class="w-full" wire:model='fixed_time_hours' />
                        <span>:</span>
                        <x-input type="number" min="0" max="59" name="fixed_time_mins" class="w-full" wire:model='fixed_time_mins' />
                    </div>
                    <div>
                        @error('fixed_time_hours')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        @error('fixed_time_mins')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>                       
                </div>                  
                <div class="">
                    <x-label value="Service Type" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='type'>
                        <x-slot name="options">
                            <option value="">--- SELECT SERVICE TYPE ---</option>
                            @foreach ($slaTypes as $slaType)
                                <option value="{{ $slaType }}">
                                    {{ $slaType }}
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
                <div>
                    &nbsp;
                </div>                
                <div class="">
                    <label class="{{ $label }}">
                        <input 
                            type="checkbox" 
                            name="include_public_holiday" 
                            class="{{ $checkbox }} mr-2" 
                            wire:model='include_public_holiday'
                        />
                        Include Public Holiday
                    </label>
                </div>                                                                                                               
            </div>
        </x-slot>
        <x-slot name="buttonActionName">
            Update
        </x-slot>
    </x-modal-steps>
</div>
