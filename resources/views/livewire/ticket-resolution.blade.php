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
    $resols = Config::get('steps.ticketManagement.resolution');

    $disabled = '';
    if($disableResolution)
    {
        $disabled="disabled='true'";
    }

    $errorClass = "dark:bg-red-400 dark:text-slate-900 p-2";

@endphp

<div id="{{ $selectedTab }}">
    @if ($resolutionExecuted)
        <div class="{{ $info }} text-center" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => {
            show = false,
                $wire.set('resolutionExecuted', false)
        }, 2500)">
            Resolution completed
        </div>
    @endif
    <form wire:submit='doResolve'>
        <div class="flex flex-row gap-3 w-full mt-3">
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Resolve At</label>
                <div class="flex flex-row gap-3 w-full mt-3">
                    <input type="date" class="{{ $input }}" wire:model='resolveDate' {{ $disabled }}>
                    <input type="time" class="{{ $input }}" wire:model='resolveTime' {{ $disabled }}>
                </div>
                <div>
                    <div>
                        @error('resolveDate')
                            <span class="error {{ $errorClass }}">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        @error('resolveTime')
                            <span class="error {{ $errorClass }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Resolve By</label>
                <div class="flex flex-row gap-3 w-full mt-3">
                    <select class="{{ $select }}" wire:model='resolveBy' {{ $disabled }}>
                        @if($ticket->resolved_by)
                            <option value="{{ $ticket->getAttributes()['resolved_by'] }}">{{ $ticket->resolved_by }}</option>
                        @endif
                        <option value="">--- SELECT USER ---</option>
                        @foreach ($internalUsers as $internalUser)
                            <option value="{{ $internalUser }}">{{ $internalUser->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        <div>
                            @error('resolveBy')
                                <span class="error {{ $errorClass }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row gap-3 w-full mt-3">
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Resolution</label>
                <select class="{{ $select }}" wire:model='resolution' {{ $disabled }}>
                    <option value="">--- SELECT RESOLUTION ---</option>
                    @foreach ($resols as $resol)
                        <option value="{{ $resol }}">{{ $resol }}</option>
                    @endforeach
                </select>
                <div class="mt-3">
                    <div>
                        @error('resolution')
                            <span class="error {{ $errorClass }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="flex flex-row gap-3 w-full mt-3">
            <div class="flex-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
                <label class="{{ $label }}">Resolution Note</label>
                <textarea class="{{ $textarea }}" rows="10" wire:model='resolutionNote' {{ $disabled }}></textarea>
                <div class="mt-3">
                    <div>
                        @error('resolutionNote')
                            <span class="error {{ $errorClass }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>  
            </div>
        </div>
        @if (!$disabled)
            <div class="flex flex-row gap-3 w-full mt-3">
                <input type="checkbox" class="{{ $checkbox }}" wire:model='notifyResolutionToCustomer'>
                <label class="{{ $label }}">Email this resolution to {{ $ticket->contact_email }}</label>
            </div>
            <div class="mt-4 pb-4 w-1/2">
                <button type="submit" class="{{ $btnEdit }}">
                    Submit
                </button>
            </div>
        @endif
    </form>
</div>
