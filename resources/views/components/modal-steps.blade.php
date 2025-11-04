@php

    $btnClose = Config::get('steps.buttonClasses.btnRed');
    $btnBlue = Config::get('steps.buttonClasses.btnBlue');
    $btnGrey = Config::get('steps.buttonClasses.btnGrey');
    $stdBg = Config::get('steps.standardBgColor');

@endphp

<div class="justify-center dark:{{ $stdBg }} items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-7xl max-h-full">
        <!-- Modal content -->
        <div class="relative  dark:{{ $stdBg }} rounded-lg shadow">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold leading-relaxed text-gray-500 dark:text-white">
                    {{ $title }}
                </h3>
                <button type="button" class="{{ $btnClose }}" wire:click="$dispatch('closeModal')">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form wire:submit='save'>
                <div class="p-4 md:p-5 space-y-4">
                    {{ $modalContent }}
                </div>
                <!-- Modal footer -->
                <div class="flex gap-5 items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button 
                        type="submit"
                        class="flex-1 {{ $btnBlue }}">
                        {{ $buttonActionName }}
                    </button>
                    <button 
                        type="button"
                        class="flex-1 {{ $btnGrey }}"
                        wire:click="$dispatch('closeModal')">
                        Close
                    </button>
                    @isset($buttonDelete)
                        <button 
                            type="button"
                            class="flex-1 {{ $btnClose }}"
                            wire:click="delete()"
                            wire:confirm="Are you sure you want to delete this visit?"
                        >
                            Delete
                        </button>
                    @endisset
                </div>
            </form>
        </div>
    </div>
</div>
