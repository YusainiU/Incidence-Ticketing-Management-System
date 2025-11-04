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

    $disabled = '';
    if ($ticketIsClosed) {
        $disabled = "disabled='true'";
    }

    $errorClass = "dark:bg-red-400 dark:text-slate-900 p-2";

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
                <label class="{{ $label }}">Assigned To</label>
                <select class="{{ $select }}" name="assignedTo" wire:model='assignedTo' {{ $disabled }}>
                    @if ($ticket->assigned_to)
                        <option value="{{ $ticket->assigned_to }}">{{ $ticket->assigned_to }}</option>
                    @endif
                    <option value=''></option>
                    @foreach ($internalUsers as $internalUser)
                        <option value="{{ $internalUser->id }}">{{ $internalUser->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Close At</label>
                <div class="flex flex-row gap-3 w-full mt-3">
                    <input type="date" class="{{ $input }}" wire:model='closeDate' {{ $disabled }}>
                    <input type="time" class="{{ $input }}" wire:model='closeTime' {{ $disabled }}>
                </div>
                <div>
                    <div>
                        @error('closeDate')
                            <span class="error {{ $errorClass }}">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        @error('closeTime')
                            <span class="error {{ $errorClass }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row gap-3 w-full mt-3">
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Remote Response</label>
                <div class="flex flex-row gap-3 w-full mt-3">
                    <input type="date" class="{{ $input }}" wire:model='remoteResponseDate'
                        {{ $disabled }}>
                    <input type="time" class="{{ $input }}" wire:model='remoteResponseTime'
                        {{ $disabled }}>
                </div>
                <div>
                    <div>
                        @error('remoteResponseTime')
                            <span class="error {{ $errorClass }}">{{ $message }}</span>
                        @enderror
                        <div>
                            @error('remoteResponseDate')
                                <span class="error {{ $errorClass }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Fix</label>
                <div class="flex flex-row gap-3 w-full mt-3">
                    <input type="date" class="{{ $input }}" wire:model='fixDate' {{ $disabled }}>
                    <input type="time" class="{{ $input }}" wire:model='fixTime' {{ $disabled }}>
                </div>
                <div>
                    @error('fixTime')
                        <span class="error {{ $errorClass }}">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    @error('fixDate')
                        <span class="error {{ $errorClass }}">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="flex flex-row gap-3 w-full mt-3">
            <input type="checkbox" class="{{ $checkbox }}" wire:model='iAmWorking' {{ $disabled }}>
            <label class="{{ $label }}">Currently working</label>
        </div>
        <div class="flex flex-row gap-3 w-full mt-3">
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Progress Note</label>
                <textarea class="{{ $textarea }}" rows="10" wire:model='note' {{ $disabled }}></textarea>
            </div>
        </div>
        <div class="flex flex-row gap-3 w-full mt-3">
            <input type="checkbox" class="{{ $checkbox }}" wire:model='noteIsImportant' {{ $disabled }}>
            <label class="{{ $label }}">Make this note important</label>
        </div>
        <div class="flex flex-row gap-3 w-full mt-3">
            <input type="checkbox" class="{{ $checkbox }}" wire:model='notifyCustomer' {{ $disabled }}>
            <label class="{{ $label }}">Email this note to {{ $ticket->contact_email }}</label>
        </div>
        @if (!$disabled)
            <div class="mt-4 pb-4 w-1/2">
                <button type="submit" class="{{ $btnEdit }}">
                    Submit
                </button>
            </div>
        @endif
    </form>
</div>
