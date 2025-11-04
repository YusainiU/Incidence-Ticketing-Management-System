<div>
    <x-modal-steps>
        <x-slot name="title">
            Create New Supplier
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
                    <x-label value="Address 1" class="mb-2"></x-label>
                    <x-input name="address_1" class="w-full" wire:model='address_1' />
                    <div>
                        @error('address_1')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Address 2" class="mb-2"></x-label>
                    <x-input name="address_2" class="w-full" wire:model='address_2' />
                    <div>
                        @error('address_2')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                
                <div class="">
                    <x-label value="Address 3" class="mb-2"></x-label>
                    <x-input name="address_3" class="w-full" wire:model='address_3' />
                    <div>
                        @error('address_3')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Address 4" class="mb-2"></x-label>
                    <x-input name="address_4" class="w-full" wire:model='address_4' />
                    <div>
                        @error('address_4')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="Telephone" class="mb-2"></x-label>
                    <x-input name="telephone" class="w-full" wire:model='telephone' />
                    <div>
                        @error('telephone')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="">
                    <x-label value="email" class="mb-2"></x-label>
                    <x-input name="Email" class="w-full" wire:model='email' />
                    <div>
                        @error('email')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                                                                      
                <div class="">
                    <x-label value="URL" class="mb-2"></x-label>
                    <x-input name="url" class="w-full" wire:model='url' />
                    <div>
                        @error('url')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                                                                      


            </div>
        </x-slot>
        <x-slot name="buttonActionName">
            Create
        </x-slot>
    </x-modal-steps>
</div>
