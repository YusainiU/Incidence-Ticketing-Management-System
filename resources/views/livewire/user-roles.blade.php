<?php

$tdActionLink = Config::get('steps.buttonClasses.btnGrey');
$tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');
$buttonEdit = Config::get('steps.buttonClasses.btnEdit');
$buttonGrey = Config::get('steps.buttonClasses.btnGrey');

$textRed = 'text-red-700';
$textBlue = 'text-blue-700';

$dropDownButton = Config::get('steps.buttonClasses.btnToggleLink');
$dropDownContent = Config::get('steps.buttonClasses.btnToggleContent');

$tdClass = Config::get('steps.tableClasses.td');
$thClass = Config::get('steps.tableClasses.th');
$trThClass = Config::get('steps.tableClasses.colTr');
$divTopClass = Config::get('steps.tableClasses.divTop');
$divSeparator = Config::get('steps.tableClasses.divSeparator');

$link = Config::get('steps.link');

$svg_edit = Config::get('steps.svg.svg_edit');

asort($routes);

?>

<div class="{{ $divTopClass }}">

    <x-section-title>
        <x-slot name="title">
            User Roles
        </x-slot>
        <x-slot name="description">
            List of User Roles
        </x-slot>
    </x-section-title>

    <div class="{{ $divSeparator }}">
        &nbsp;
    </div>

    <div class="mt-3 mb-3 px-5">
        <button type="button" class="{{ $tdActionLink }}"
            wire:click="$dispatch('openModal', {
                component: 'createNewRole', 
            })">
            Create New Role
        </button>
    </div>

    @if ($roles)

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
                    <x-dropdown-link wire:click.prevent="setToggleStatus('all')" class="cursor-pointer">
                        Show All
                    </x-dropdown-link>
                    <x-dropdown-link wire:click.prevent="setToggleStatus('active')" class="cursor-pointer">
                        Show Active
                    </x-dropdown-link>
                    <x-dropdown-link wire:click.prevent="setToggleStatus('notActive')" class="cursor-pointer">
                        Show Not Active
                    </x-dropdown-link>
                </x-slot>
            </x-dropdown>
        </div>

        <div class="mt-3 mb-3 px-5">
            @if (!$filter && $roles)
                {{ $roles->links() }}
            @endif
        </div>

        <div class="px-5">
            <x-table>
                <x-slot name="tableColumns">
                    <tr class="{{ $trThClass }}">
                        <th class="{{ $thClass }}">Name</th>
                        <th class="{{ $thClass }}">Description</th>
                        <th class="{{ $thClass }}">Routes Allowed</th>
                        <th class="{{ $thClass }}">Status</th>
                        <th class="{{ $thClass }}">Actions</th>
                    </tr>
                </x-slot>
                <x-slot name="tableRows">
                    @foreach ($roles as $role)
                        @php
                            $disableButton = $role->id == 1 && !$isSuperAdmin ? 'Disabled' : null;
                        @endphp
                        <tr class="py-5" wire:key="{{ $role->id }}">
                            <td class="{{ $tdClass }} align-top">
                                @if ($displayNameColumn == $role->id)
                                    <x-input name="name-{{ $role->id }}" value="{{ $role->name }}"
                                        wire:keydown.enter='changeName({{ $role }}, $event.target.value)'
                                        x-on:click.away="$wire.resetFields()" />
                                @else
                                    <button class="{{ $link }}" name="button-name-{{ $role->id }}"
                                        wire:click='showNameField({{ $role }})' {{ $disableButton }}>
                                        {{ $role->name }}
                                    </button>
                                @endif
                            </td>
                            <td class="{{ $tdClass }} align-top">
                                @if ($displayDescriptionColumn == $role->id)
                                    <x-input name="description-{{ $role->id }}" value="{{ $role->description }}"
                                        wire:keydown.enter="changeDescription({{ $role }}, $event.target.value)"
                                        x-on:click.away="$wire.resetFields()" />
                                @else
                                    <button class="{{ $link }}"
                                        name = "button-description-{{ $role->id }}"
                                        wire:click='showDescriptionField( {{ $role }} )' {{ $disableButton }}>
                                        {{ $role->description }}
                                    </button>
                                @endif
                            </td>
                            <td class="flex flex-col flex-wrap gap-y-2 {{ $tdClass }}">
                                @php
                                    $routesExisted = [];
                                    $allow_edit = null;
                                    $thisRoutes = $role->allowed_routes;
                                    $allowEdit = $role->allow_edit ? explode(',', $role->allow_edit) : null;
                                    if ($thisRoutes) {
                                        $routesExisted = explode(',', $thisRoutes);
                                        asort($routesExisted);
                                    }
                                @endphp
                                @if ($thisRoutes)
                                    @foreach ($routesExisted as $aw)
                                        @php
                                            $isEditable = '';
                                            $ticket_moniker = Config::get('steps.ticket');
                                            $disp = str_replace('_', ' ', Str::snake($aw));
                                            $disp = str_replace('ticket', $ticket_moniker, $disp);
                                            if (is_array($allowEdit) && in_array($aw, $allowEdit)) {
                                                $isEditable = $svg_edit;
                                            }
                                        @endphp
                                        @if($canEdit)
                                        <button class="{{ $buttonGrey }} ml-2 text-sm px-4 flex flex-row gap-2"
                                            wire:click="removeRoute({{ $role }},'{{ $aw }}')"
                                            {{ $disableButton }}>
                                            {{ $disp }}
                                            {!! $isEditable !!}
                                        </button>
                                        @else
                                            <div class="{{ $buttonGrey }} ml-2 text-sm px-4 flex flex-row gap-2">
                                            {{ $disp }}
                                            {!! $isEditable !!}
                                            </div>
                                        @endif
                                    @endforeach
                                @endif

                                @if ($canEdit)
                                    <button
                                        wire:click="$dispatch('openModal', { 
                                            component: 'AddRoutesToRoles', 
                                            arguments: { 
                                                role: {{ $role }} 
                                            }
                                        })"
                                        class="  {{ $buttonEdit }} ml-2">
                                        Add Route
                                    </button>
                                @endif

                            </td>
                            <td class="{{ $tdClass }} {{ $role->active ? $textBlue : $textRed }} align-top">
                                {{ $role->active ? 'Active' : 'Not Active' }}
                            </td>
                            <td class="{{ $tdClass }} align-top">
                                @if ($disableButton)
                                    <div>
                                        Disallowed
                                    </div>
                                @else
                                    <div>
                                        @if ($role->active)
                                            @if ($canEdit)
                                                <button href="" class="{{ $tdActionLinkDelete }}"
                                                    wire:click="changeRoleStatus({{ $role }})"
                                                    wire:confirm='Are you you want to deactive this role?'
                                                    {{ $disableButton }}>
                                                    Deactivate
                                                </button>
                                            @else
                                                Insufficient Permission
                                            @endif
                                        @else
                                            @if ($canEdit)
                                                <button href="" class="{{ $tdActionLink }}"
                                                    wire:click="changeRoleStatus({{ $role }})"
                                                    {{ $disableButton }}>
                                                    Activate
                                                </button>
                                            @else
                                                Insufficient Permission
                                            @endif
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>

        </div>

        <div class="mt-3 mb-3 px-5">
            @if (!$filter && $roles)
                {{ $roles->links() }}
            @endif
        </div>

    @endif

</div>
