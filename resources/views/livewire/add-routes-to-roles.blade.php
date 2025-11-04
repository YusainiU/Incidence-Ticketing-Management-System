<?php

if ($role->allowed_routes) {
    $r = explode(',', $role->allowed_routes);
    $existing = implode(', ', $r);
}

$select = Config::get('steps.form.select');
$btnBlue = Config::get('steps.buttonClasses.btnBlue');
$btnGrey = Config::get('steps.buttonClasses.btnGrey');
$btnClose = Config::get('steps.buttonClasses.btnX');
$svg_x = Config::get('steps.svg.svg_cross_x_complete');
$checkbox = Config::get('steps.form.checkbox');
$label = Config::get('steps.form.label');

?>

<div class="justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $role->name }}
                </h3>
                <button type="button" class="{{ $btnClose }}" wire:click="$dispatch('closeModal')">
                    {!! $svg_x !!}
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form method="post" action="{{ route('addRouteToRole', ['role' => $role]) }}">
                <!-- Modal body -->
                <div class="flex flex-col p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    @csrf
                    <div class="flex-1">
                        <x-label>Select Route</x-label>
                        <x-select name="MultiSelectRoute_{{ $role->id }}">
                            <x-slot name="options">
                                <option value="add_all">Add All</option>
                                @foreach ($allRoutesFromConfig as $routeLabel => $route)
                                    @php
                                        $disp = str_replace('Ticket', Config::get('steps.ticket'),$routeLabel);
                                    @endphp
                                    <option value="{{ $route }}">{{ $disp }}</option>
                                @endforeach
                            </x-slot>
                        </x-select>
                    </div>
                    <div class="flex flex-1 gap-3 mt-3 align-middle">
                        <x-checkbox name="allow_edit" />
                        <x-label>Allow Edit</x-label>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="{{ $btnBlue }}">
                        Update
                    </button>
                    <button type="button"
                        class="{{ $btnGrey }} ml-5"
                        wire:click="$dispatch('closeModal')">
                        Close
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

