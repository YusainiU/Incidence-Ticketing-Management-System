
@php

    $select = Config::get('steps.form.select');
    $btnClose = Config::get('steps.buttonClasses.btnGrey');
    $input = Config::get('steps.form.input-normal');

@endphp

<div class="justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ $user->name }}
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
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <x-label value="Full Name" class="mb-3"></x-label>
                        <x-input name="name" value="{{ $name }}" class="w-full" wire:model='name' />
                    <div>
                        @error('name')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <x-label value="Email Address" class="mb-3"></x-label>
                        <x-input name="email" value="{{ $email }}" class="w-full" wire:model='email' />
                    <div>
                        @error('email')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    </p>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <x-label value="Phone Number" class="mb-3"></x-label>
                        <x-input name="phone_number" value="{{ $phone_number }}" class="w-full"
                            wire:model='phone_number' />
                    <div>
                        @error('phone_number')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                    </p>

                    <div x-data="{ scustomer: false, uid: '{{ $user_identity }}', }">
                        <div class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                            <x-label value="User Identity" class="mb-3"></x-label>
                            <x-select name="user_identity" class="{{ $select }}" wire:model='user_identity'
                                x-on:change="uid = scustomer = $event.target.value">
                                <x-slot name="options">
                                    <option value="">---- SELECT ----</option>
                                    @if (is_array($user_identity_options))
                                        @foreach ($user_identity_options as $key => $ident)
                                            <option value="{{ $ident }}"
                                                {{ $ident == $user_identity ? 'selected' : '' }}>
                                                {{ $key }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="{{ $user_identity }}">{{ $user_identity }}</option>
                                    @endif
                                </x-slot>
                            </x-select>
                            <div>
                                @error('user_identity')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                            x-show="scustomer=='customer' || uid == 'customer'">
                            @if (sizeof($customers))
                                <x-searchable-dropdown :options="$customers" property="customer_id" />
                                <x-input type="hidden" wire:model='customer_id' id="customer_id" class="{{ $input }}" />
                                <div>
                                    @error('customer_id')
                                        <span class="text-red-600">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>

                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                        <label>
                            <x-checkbox name="active" class="mr-2" wire:model='active' />
                            Active
                        </label>
                    </p>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Update
                    </button>
                    <button type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                        wire:click="$dispatch('closeModal')">
                        Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
