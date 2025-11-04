<div>

    <x-modal-steps>
        <x-slot name="title">
            Add Contact To Role
        </x-slot>
        <x-slot name="modalContent">
            <div class="grid gap-4 grid-cols-1 content-start">
                <x-select wire:model='role'>
                    <x-slot name="options">
                        <option value="">--- SELECT ---</option>
                        @foreach ($roles as $role)
                            @php
                                $lblOpt = \App\Enums\CustomerContactRoles::toName($role->toString());
                            @endphp
                            <option value="{{ $role->toString() }}">{{ $lblOpt }}</option>
                        @endforeach
                    </x-slot>
                </x-select>
                <div>
                    @error('role')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>                
                <x-label value="Short Description" class="mb-2 mt-2"></x-label>
                <x-text name="description" class="w-full" wire:model='description'>
                    <x-slot name="textValue">

                    </x-slot>
                </x-text>
                <div>
                    @error('description')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
                </div>
                <x-slot name="buttonActionName">
                    Add Role
                </x-slot>
            </div>
        </x-slot>
    </x-modal-steps>

</div>
