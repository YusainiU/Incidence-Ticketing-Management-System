@php
    $info = Config::get('steps.alert.info');
    $input = Config::get('steps.form.input-normal');
    $label = Config::get('steps.form.label');
    $textarea = Config::get('steps.form.textarea');
    $btnEdit = Config::get('steps.buttonClasses.btnEdit');
    $dl = Config::get('steps.descriptionList.dl');

@endphp

<div id="{{ $selectedTab }}">
    @if ($detailsUpdated)
        <div 
            class="{{ $info }} text-center" 
            x-data="{ show: true }" 
            x-show="show" 
            x-init="setTimeout(() => {
                show = false, 
                $wire.set('detailsUpdated', false)
            }, 2500)"
        >
            Details Updated
        </div>
    @endif
    <form wire:submit='updateTicket'>
        <div class="flex flex-row gap-3 w-full mt-3">
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <x-label class="{{ $label }}">Short Description</x-label>
                <x-input class="{{ $input }}" name="short_description" wire:model='short_description' />
            </div>
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <x-label class="{{ $label }}">Customer Reference</x-label>
                <x-input class="{{ $input }}" name="customer_reference" wire:model='customer_reference' />
            </div>
        </div>
        <div class="mt-4">
            <x-label value="Full Description" class="{{ $label }} mb-2"></x-label>
            <x-text name="description" rows="8" class="{{ $textarea }} w-full" wire:model='description'>
                <x-slot name="textValue">

                </x-slot>
            </x-text>
        </div>
        <div class="mt-4 pb-4 w-1/2">
            <button type="submit" class="{{ $btnEdit }}">
                Update
            </button>
        </div>
    </form>
</div>
