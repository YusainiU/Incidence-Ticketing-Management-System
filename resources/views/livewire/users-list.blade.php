<?php

$dropDownButton = Config::get('steps.buttonClasses.btnToggleLink');
$dropDownContent = Config::get('steps.buttonClasses.btnToggleContent');

$textRed = 'text-red-700';
$textBlue = 'text-blue-700';

$tdActionLink = Config::get('steps.buttonClasses.btnGrey');
$tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');
$link = Config::get('steps.link');

$tdClass = Config::get('steps.tableClasses.td');
$thClass = Config::get('steps.tableClasses.th');
$trThClass = Config::get('steps.tableClasses.colTr');
$divTopClass = Config::get('steps.tableClasses.divTop');
$divSeparator = Config::get('steps.tableClasses.divSeparator');

?>

<div class="relative overflow-hidden shadow-md rounded-lg">

    <x-section-title>
        <x-slot name="title">
            Users
        </x-slot>
        <x-slot name="description">
            List of User
        </x-slot>
    </x-section-title>

    <div class="{{ $divSeparator }}">
        &nbsp;
    </div>

    @if ($isUserAdmin || $isAdmin)
        <div class="mt-3 mb-3 px-5">
            <button type="button" class="{{ $tdActionLink }}"
                wire:click="$dispatch('openModal', {
                component: 'createNewUser',
            })">
                Create New User
            </button>
        </div>
    @endif

    <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
        <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button type="button" class="{{ $dropDownButton }}">
                    Toggle
                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link wire:click.prevent="toggleActive('all')" class="cursor-pointer">
                    Show All
                </x-dropdown-link>
                <x-dropdown-link wire:click.prevent="toggleActive('active')" class="cursor-pointer">
                    Show Active
                </x-dropdown-link>
                <x-dropdown-link wire:click.prevent="toggleActive('notActive')" class="cursor-pointer">
                    Show Not Active
                </x-dropdown-link>
            </x-slot>
        </x-dropdown>
    </div>

    <div class="mt-3 mb-3 px-5">
        @if (!$filter)
            {{ $users->links() }}
        @endif
    </div>

    <div class="px-5">

        <x-table>
            <x-slot name="tableColumns">
                <tr class="{{ $trThClass }}">
                    <th class="{{ $thClass }}">Name</th>
                    <th class="{{ $thClass }}">Email</th>
                    <th class="{{ $thClass }}">Phone Num</th>
                    <th class="{{ $thClass }}">Status</th>
                    <th class="{{ $thClass }}">Type</th>
                    @if ($isAdmin)
                        <th class="{{ $thClass }}">Roles</th>
                    @endif
                    <th class="{{ $thClass }}">Actions</th>
                </tr>
            </x-slot>
            <x-slot name="tableRows">
                @foreach ($users as $user)
                    <tr class="py-5" wire:key="{{ $user->id }}">
                        <td class="{{ $tdClass }}">
                            @php
                                $companyName = '';
                                $co = $customers->where('customer_id', '=', $user->customer_id)->first();
                                if ($co) {
                                    $companyName = $co->name;
                                }
                                $roles = $user->roles;
                                $listOfRoles = '';
                                if ($isAdmin) {
                                    if ($roles) {
                                        $ro = [];
                                        foreach ($roles as $role) {
                                            $ro[] = array_values($role->getRoles->only(['name']))[0];
                                        }
                                        $listOfRoles = implode(', ', $ro);
                                    }
                                }
                            @endphp
                            <a href="{{ route('userProfile', $user->id) }}" class="{{ $link }}">
                                {{ $user->name }}
                                @if ($companyName)
                                    <span class="block text-ellipsis text-xs">Company: {{ $companyName }}</span>
                                @endif
                            </a>
                        </td>
                        <td class="{{ $tdClass }}">{{ $user->email }}</td>
                        <td class="{{ $tdClass }}">{{ $user->phone_number }}</td>
                        <td class="{{ $tdClass }} {{ $user->active ? $textBlue : $textRed }}">
                            {{ $user->active ? 'Active' : 'Not Active' }}
                        </td>
                        <td class="{{ $tdClass }}">{{ $user->user_identity }}</td>
                        @if ($isAdmin)
                            <td class="{{ $tdClass }}">{{ $listOfRoles }}</td>
                        @endif
                        @if ($isUserAdmin)
                            <td class="{{ $tdClass }} flex flex-row">
                                <div class="ml-2">
                                    <button
                                        wire:click="$dispatch('openModal', {
                                            component: 'EditUserDetails', 
                                            arguments: { userdata: {{ $user }} }
                                        })"
                                        class="  {{ $tdActionLink }} mr-1" onclick="this.blur()">
                                        Edit
                                    </button>
                                </div>
                                <div>
                                    <button href="" class="{{ $tdActionLinkDelete }}"
                                        wire:click="$dispatch('openModal', {
                                        component: 'modalDeleteUser', 
                                        arguments: {userToDelete:{{ $user }}}
                                    })"
                                        wire:confirm.prompt='Please type DELETE to continue|DELETE'>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </x-slot>

        </x-table>

    </div>

    <div class="mt-3 mb-3 px-5">
        @if (!$filter)
            {{ $users->links() }}
        @endif
    </div>
</div>
