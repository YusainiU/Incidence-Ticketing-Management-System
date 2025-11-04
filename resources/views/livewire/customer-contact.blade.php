@php
    $tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');
    $text = Config::get('steps.standardTextColor');
    $whiteBox = Config::get('steps.whiteBox');
@endphp

<div>
    <x-page-profile>
        <x-slot name="title">
            Contact Roles
        </x-slot>
        <x-slot name="nav">
            @if ($canEdit)
                <x-button
                    wire:click="$dispatch('openModal', { 
                    component: 'AddCustomerContactToRole', 
                    arguments: { 
                        user: {{ $user }} 
                    }
                })"
                    type="button">Add Contact Role</x-button>
            @endif
        </x-slot>
        <x-slot name="left_panel">
            @if ($roles)
                <div class="flex gap-3 items-start mt-10 ml-10 mr-10">
                    <div class="w-full rounded-md p-3 text-lg">
                        <div class="table w-full">
                            @foreach ($roles as $key => $role)
                                <div class="dark:{{ $text }} text-dark table-row w-full align-top">
                                    <div class="table-cell p-3">
                                        {{ App\Enums\CustomerContactRoles::toName($role['customerRole']) }}</div>
                                    <div class="table-cell p-3">
                                        @if ($canEdit)
                                            <button class="{{ $tdActionLinkDelete }} text-sm"
                                                wire:click='removeRole({{ $role['id'] }})'
                                                wire:confirm.prompt='type REMOVE to confirm?|REMOVE'>
                                                Remove
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </x-slot>
        <x-slot name="right_panel">
        </x-slot>
        <x-slot name="bottom_panel">
        </x-slot>
    </x-page-profile>
</div>
