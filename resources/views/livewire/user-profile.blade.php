@php
    $ident = $userIdentity ? "( $userIdentity )" : '';
    $tdActionLink = Config::get('steps.buttonClasses.btnGrey');
    $tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');
    $btnBlue = Config::get('steps.buttonClasses.btnBlue');
    $btnDisabled = Config::get('steps.buttonClasses.btnGrey');
    $svg_cross_x = Config::get('steps.svg.svg_cross_x');
    $link = Config::get('steps.link');
    $bg = Config::get('steps.standardBgColor');
    $whiteBox = Config::get('steps.whiteBox');
    $text = Config::get('steps.standardTextColor');
    $file = Config::get('steps.form.fileInput');

    $insetBox = 'block mt-3 p-3 border border-zinc-700 rounded-md border-dashed';

@endphp


<div class="">
    <div class="text-5xl font-bold dark:{{ $text }} p-3 text-center mt-10 ml-10 mr-10">
        <p>User Profile {{ $ident }}</p>
        <span class="text-2xl">
            @if ($customerName)
                {{ $customerName }}
            @endif
        </span>
    </div>

    <div class="flex gap-3 items-start mt-10 ml-10 mr-10">
        <div class="{{ $whiteBox }} flex flex-1 w-1/2 rounded-md p-3 shadow-2xl">
            <div class="h-28 w-30 mr-5 mb-3 box-border p-2">
                @if ($user->profile_photo_path)
                    <img class="h-36 w-full" src="{{ Storage::url($user->profile_photo_path) }}" />
                    <button type="button" wire:click='removePhoto'
                        class="bg-red-800 hover:bg-red-500 text-white font-bold py-2 px-4 rounded mt-2 w-full">Remove</button>
                @endif
            </div>
            <div class="dark:{{ $text }} text-dark  text-lg">
                <div class="mb-3 py-0 align-top">Full Name: {{ $user->name }}</div>
                <div class="mb-3 py-0 align-top">First Name: {{ $user->first_name }}</div>
                <div class="mb-3 py-0 align-top">Last Name: {{ $user->last_name }}</div>
                <div class="mb-3 py-0 align-top">Email: {{ $user->email }}</div>
                <div class="mb-3 py-0 align-top">Phone Number: {{ $user->phone_number }}</div>
                <div class="mb-3 py-0 align-top">Status: {{ $user->active ? 'Active' : 'Not Active' }}</div>
                {{-- <div class="mb-3 py-0 align-top">Photo: {{ $user->profile_photo_path }}</div> --}}
            </div>
        </div>
        <div class="{{ $whiteBox }} {{ $text }} flex-1 w-1/2 rounded-md p-3 text-lg">
            @if ($canEdit)
                <div class="mb-3">
                    <button type="button"
                        wire:click="$dispatch('openModal', { 
                            component: 'modalDeleteUser', 
                            arguments: {userToDelete:{{ $user }}}
                        })"
                        wire:confirm.prompt='Please type DELETE to continue|DELETE'
                        class="bg-red-800 hover:bg-red-500 text-white font-bold py-2 px-4 rounded w-1/2">
                        Delete User
                    </button>
                </div>
                <div class="mb-3">
                    <button type="button"
                        wire:click="$dispatch('openModal', { 
                        component: 'EditUserDetails', 
                        arguments: { userdata: {{ $user }} }
                        })"
                        class="bg-blue-800 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded w-1/2">
                        Edit User Details
                    </button>
                </div>
                <div class="mb-3">
                    <form wire:submit='photoUpdate'>
                        <div class="items-center w-1/2" x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                            x-on:livewire-upload-finish="uploading = false"
                            x-on:livewire-upload-cancel="uploading = false"
                            x-on:livewire-upload-error="uploading = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <input type="file" wire:model="photo" class="{{ $file }}">
                            <div x-show="uploading">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div>
                            <div>
                                <button type="submit"
                                    class="bg-blue-800 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded w-1/2 mt-3">
                                    Upload Photo
                                </button>
                            </div>
                            <div>
                                @error('photo')
                                    <span class="text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            @endif
            @if($canResetPassword)
                <div class="mb-3">
                    <button type="button"
                        wire:click="$dispatch('openModal', { 
                            component: 'resetUserPassword', 
                            arguments: {user:{{ $user }}}
                        })"
                        wire:confirm.prompt='Please type RESET to continue|RESET'
                        class="bg-red-800 hover:bg-red-500 text-white font-bold py-2 px-4 rounded w-1/2">
                        Reset Password
                    </button>
                </div>
            @endif
        </div>
    </div>

    @if ($canEdit && $isInternalUser)
        <div class="text-center text-3xl font-bold dark:{{ $text }} text-dark p-3 mt-10 ml-10 mr-10">
            User Roles
        </div>
        <div class="flex gap-3 items-start mt-10 ml-10 mr-10">
            @if ($roles)

                <div class="w-full rounded-md p-3 shadow-2xl text-lg">
                    <div class="dark:{{ $text }} text-dark table w-full">
                        @foreach ($roles as $role)
                            @php
                                $roleName = $role->getRoleName($role->roles_id)->name;
                                $disable = '';
                                $btnStyle = $tdActionLinkDelete;
                                if(($roleName == 'Administrator' || $roleName == 'Super Administrator') && !$isSuperAdmin){
                                    $disable = 'disabled';
                                    $btnStyle = $btnDisabled;
                                }
                            @endphp
                            <div class="table-row {{ $insetBox }} w-full align-top">
                                <div class="table-cell p-3">{{ $roleName }}</div>
                                <div class="table-cell p-3">
                                    <button class="{{ $btnStyle }} text-sm"
                                        wire:click='removeUserRole({{ $role->id }})'
                                        wire:confirm.prompt='type REMOVE to confirm?|REMOVE'
                                        {{ $disable }}
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="w-full rounded-md p-3">
                    <button class="{{ $btnBlue }}"
                        wire:click="$dispatch('openModal', { 
                            component: 'AddUserToRole', 
                            arguments: {user:{{ $user }}}
                        })">
                        Add Role
                    </button>
                </div>
            @endif
        </div>
    @endif

    @if ($isCustomer)
        <livewire:CustomerContact :user="$user" />
    @endif



    <x-bladewind::modal size="large" type="info" title="Add User To Roles" name="AddUserToRole" ok_button_label="">
        <livewire:AddUserToRole :user="$user" />
    </x-bladewind::modal>

</div>
