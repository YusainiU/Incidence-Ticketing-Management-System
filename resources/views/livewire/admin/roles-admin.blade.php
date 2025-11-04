@php
    $divTopClass = Config::get('steps.tableClasses.divTop');
    $divSeparator = Config::get('steps.tableClasses.divSeparator');
    $box = Config::get('steps.whiteBox');
    $link = Config::get('steps.link');
    $tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');
    $svg_edit = Config::get('steps.svg.svg_edit');
    $buttonGrey = Config::get('steps.buttonClasses.btnGrey');
    $buttonEdit = Config::get('steps.buttonClasses.btnEdit');
    $buttonBlue = Config::get('steps.buttonClasses.btnBlue');
    $xcross = Config::get('steps.svg.svg_cross_x_complete');

    $box .= '  flex flex-col gap-5';
    $insetBox =
        'block text-zinc-950 mt-3 ml-9 p-3 border border-zinc-700 dark:border-zinc-200 rounded-md border-dashed';

@endphp

<div class="{{ $divTopClass }}">

    <div>
        <div class="mt-3 mb-3 py-5 px-5 text-center text-3xl font-bold">
            ROLES ADMINISTRATION
        </div>
    </div>

    <div class="{{ $divSeparator }}">
        &nbsp;
    </div>

    <div class="mt-3 mb-3 px-5">
        <button type="button" class="{{ $buttonBlue }}"
            wire:click="$dispatch('openModal', {
                component: 'createNewRole', 
            })">
            Create New Role
        </button>
    </div>

    @if ($roles)

        <div class="mt-3 mb-3 py-5 px-5">
            @foreach ($roles as $role)
                @php
                    $disableButton = $role->name == 'Super Administrator' || $role->name == 'Administrator' ? 'Disabled' : null;
                @endphp
                <div class="{{ $box }}">
                    <div class="flex justify-between">
                        @if ($displayNameColumn == $role->id)
                            <x-input name="name-{{ $role->id }}" value="{{ $role->name }}"
                                wire:keydown.enter='changeName({{ $role }}, $event.target.value)'
                                x-on:click.away="$wire.resetFields()" class="w-1/2" />
                        @else
                            <button class="{{ $link }}" name="button-name-{{ $role->id }}"
                                wire:click='showNameField({{ $role }})' {{ $disableButton }}>
                                {{ $role->name }}
                            </button>
                        @endif
                        <span>
                            @if ($showMore && $showMore == $role->name)
                                <button class="{{ $link }}" wire:click="expandMore('close')">Close ..</button>
                            @else
                                <button class="{{ $link }}"
                                    wire:click="expandMore('{{ $role->name }}')">more ..</button>
                            @endif
                        </span>

                    </div>
                    @if ($showMore == $role->name)
                        <div class="{{ $insetBox }} mt-3 flex flex-col gap-3">
                            <div>
                                @if ($displayDescriptionColumn == $role->id)
                                    <x-input name="description-{{ $role->id }}" value="{{ $role->description }}"
                                        wire:keydown.enter="changeDescription({{ $role }}, $event.target.value)"
                                        x-on:click.away="$wire.resetFields()" />
                                @else
                                    <span class="dark:text-zinc-200">Description :</span>
                                    <button class="{{ $link }}"
                                        name = "button-description-{{ $role->id }}"
                                        wire:click='showDescriptionField( {{ $role }} )' {{ $disableButton }}>
                                        {{ $role->description }}
                                    </button>
                                @endif
                            </div>
                            <div>
                                <span class="dark:text-zinc-200">Status:</span>
                                @if ($role->active)
                                    @if ($canEdit)
                                        <button href="" class="dark:text-red-400"
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
                                        <button href="" class="dark:text-blue-400"
                                            wire:click="changeRoleStatus({{ $role }})" {{ $disableButton }}>
                                            Activate
                                        </button>
                                    @else
                                        Insufficient Permission
                                    @endif
                                @endif
                                </civ>
                            </div>
                            <div class="flex flex-row flex-wrap gap-y-2 dark:text-zinc-200">
                                @php
                                    $routesExisted = [];
                                    $allow_edit = null;
                                    $thisRoutes = $role->allowed_routes;
                                    $allowEdit = $role->allow_edit ? explode(',', $role->allow_edit) : null;
                                    if ($thisRoutes) {
                                        $routesExisted = explode(',', $thisRoutes);
                                        asort($routesExisted);
                                    }
                                    $allow_add_new = '';
                                    $allow_remove = '';
                                    if (in_array($role->id, [1, 2])) {
                                        if(!$isSuperAdmin){
                                            $allow_add_new = 'disabled';
                                        }
                                        $allow_remove = 'disabled';
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
                                        @if ($canEdit)
                                            <button class="{{ $buttonGrey }} ml-2 text-sm px-4 flex flex-row gap-2"
                                                wire:click="removeRoute({{ $role }},'{{ $aw }}')"
                                                {{ $allow_remove }}>
                                                <div class="pt-1">{!! $xcross !!}</div>
                                                <div>{{ $disp }}</div>
                                                <div class="pt-1">{!! $isEditable !!}</div>
                                            </button>
                                        @else
                                            <div class="{{ $buttonGrey }} ml-2 text-sm px-4 flex flex-row gap-2">
                                                <div class="pt-1">{!! $xcross !!}</div>
                                                <div>{{ $disp }}</div>
                                                <div class="pt-1">{!! $isEditable !!}</div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                <button
                                    wire:click="$dispatch('openModal', { 
                                            component: 'AddRoutesToRoles', 
                                            arguments: { 
                                                role: {{ $role }} 
                                            }
                                        })"
                                    class="  {{ $buttonEdit }} ml-2" {{ $allow_add_new }}>
                                    Add Route
                                </button>
                            </div>
                    @endif
                </div>
            @endforeach
        </div>

    @endif

</div>
