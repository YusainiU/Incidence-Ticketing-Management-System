<div>
    <<x-modal-steps>>

        <x-slot name="title">
            Edit Customer Details
        </x-slot>

        <x-slot name="modalContent">

            <x-validation-errors class="mb-4" />

            

                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" />
                    <x-input 
                        id="password" 
                        class="block mt-1 w-full" 
                        type="password" 
                        name="password" 
                        wire:model='password'
                        required
                        autocomplete="new-password" />
                </div>

                <div class="mt-4">
                    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                    <x-input 
                        id="password_confirmation" 
                        class="block mt-1 w-full" 
                        type="password"
                        name="password_confirmation" 
                        wire:model='password_confirmation'
                        required autocomplete="new-password" />
                </div>

            
        </x-slot>

        <x-slot name="buttonActionName">
            Reset Password
        </x-slot>        

        </x-modal-steps>

</div>
