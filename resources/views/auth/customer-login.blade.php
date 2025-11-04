@php
    $alert = Config::get('steps.alert.danger');
    $input = Config::get('steps.form.input-normal');
@endphp
<div>
    <x-guest-layout>
        <x-authentication-card>
            <x-slot name="logo">
                <x-authentication-card-logo />
                <div class="mt-2 text-center">
                    CUSTOMER
                </div>
            </x-slot>

            <x-validation-errors class="mb-4" />

            @session('status')
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ $value }}
                </div>
            @endsession
            @if ($error)
                <div class="{{ $alert }} text-center">
                    {{ $error }}
                </div>
            @endif
            <form wire:submit='loginForCustomer'>
                <div>
                    <x-label for="email" value="{{ __('Email') }}" />
                    <input id="email" class="{{ $input }} block mt-1 w-full" type="email" name="email"
                        {{ $isBlocked ? 'disabled' : '' }} required autofocus autocomplete="username" wire:model='email'
                        wire:blur="verifyUsername()" />
                </div>

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <input id="password" class="{{ $input }} block mt-1 w-full" type="password" name="password"
                        {{ $isBlocked ? 'disabled' : '' }} required autocomplete="current-password"
                        wire:model='password' />
                </div>


                <div class="flex items-center justify-end mt-4">
                    @if (!$isBlocked)
                        <x-button class="ms-4">
                            Log In
                        </x-button>
                    @endif
                </div>

                @if ($browser->isMobile())
                    <div class="text-center mt-4 dark:text-yellow-500">
                        <hr class="mb-2" />
                        Your are using a mobile. Currently the Application will only
                        work correctly on a desktop.
                    </div>
                @endif

            </form>
        </x-authentication-card>
    </x-guest-layout>
</div>
