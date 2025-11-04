@php
    $info = Config::get('steps.alert.info');
    $failed = Config::get('steps.alert.danger');
    $input = Config::get('steps.form.input-normal');
    $label = Config::get('steps.form.label');
    $select = Config::get('steps.form.select');
    $textarea = Config::get('steps.form.textarea');
    $btnEdit = Config::get('steps.buttonClasses.btnEdit');
    $dl = Config::get('steps.descriptionList.dl');
    $checkbox = Config::get('steps.form.checkbox');
    $checkboxLabel = Config::get('steps.form.checkboxLabel');
    $errorClass = 'dark:bg-red-400 dark:text-slate-900 p-2';

@endphp

<div id="{{ $selectedTab }}">
    @if ($actionExecuted)
        <div class="{{ $info }} text-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => {
            show = false,
                $wire.set('actionExecuted', false)
        }, 2500)">
            Action Executed
        </div>
    @endif
    @if ($additionalInformation)
        <div class="{{ $info }} text-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => {
            show = false,
                $wire.set('additionalInformation', '')
        }, 3000)">
            {{ $additionalInformation }}
        </div>
    @endif
    @if ($failures)
        <div class="{{ $failed }} text-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => {
            show = false,
                $wire.set('failures', '')
        }, 3000)">
            {{ $failures }}
        </div>
    @endif
    <form wire:submit.prevent='doAction'>
        <div class="flex flex-row gap-3 w-full mt-3">
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Comments</label>
                <textarea class="{{ $textarea }}" rows="10" wire:model='note'></textarea>
            </div>
        </div>
        <div class="mt-4 pb-4 w-1/2">
            <button type="submit" class="{{ $btnEdit }}">
                Submit
            </button>
        </div>

    </form>
</div>
