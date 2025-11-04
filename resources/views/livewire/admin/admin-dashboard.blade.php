@php
    
    $whiteBox = Config::get('steps.whiteBox');
    $text = Config::get('steps.standardTextColor');

@endphp

<div class="" >

    <div class="flex overflow-hidden dark:{{ $text }}">

        {{-- SIDE BAR --}}
        <aside class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0">

            <div class="flex items-center gap-2 pt-8 sidebar-header pb-7">
                {{-- Sidebar --}}
                <span class="logo">
                    ADMIN DASHBOARD
                </span>
            </div>

            <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
                <!-- Sidebar Menu -->
                <nav x-data="{ selected: $persist('Dashboard') }">
                    {{-- Menu Group --}}
                    <div>
                        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
                            <span class="menu-group-title">
                                MENU
                            </span>
                            <svg
                                class="mx-auto fill-current menu-group-icon" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
                                    fill="" 
                                />
                            </svg>
                        </h3>
                        <ul class="flex flex-col gap-4 mb-6">
                            <!-- Menu Item Dashboard -->
                            <li>
                                <a href="#"
                                    @click.prevent="selected = (selected === 'Dashboard' ? '':'Dashboard')"
                                    class="menu-item group"
                                >

                                    <span class="menu-item-text">
                                        Access Logs
                                    </span>
                                </a>

                                <!-- Dropdown Menu Start -->
                                <div 
                                    class="overflow-hidden transform translate"
                                    :class="(selected === 'Dashboard') ? 'block' : 'hidden'"
                                >
                                    <ul class="flex flex-col gap-1 mt-2 menu-dropdown pl-9">
                                        <li>
                                            <a href="#" class="menu-dropdown-item group" wire:click.prevent="selectContent('failedAttempts')">
                                                Failed Attempts
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="menu-dropdown-item group" wire:click.prevent="selectContent('cache')">
                                                Failed Attempts (Cache)
                                            </a>
                                        </li>                                          
                                        <li>
                                            <a href="#" class="menu-dropdown-item group" wire:click.prevent="selectContent('successfulLogins')">
                                                Successful Logins
                                            </a>
                                        </li>                                        
                                    </ul>
                                </div>
                                <!-- Dropdown Menu End -->
                            </li>                            
                            <!-- Menu Item Dashboard -->

                            <!-- Menu Item -->
                            <li>
                                <a 
                                    href="#" 
                                    class="menu-item group"
                                    wire:click.prevent="selectContent('pageRouteList')"
                                >
                                    <span class="menu-item-text">
                                        Route List
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item -->

                            <!-- Menu Item -->
                            <li>
                                <a 
                                    href="#" 
                                    class="menu-item group"
                                    wire:click.prevent="selectContent('uploadPublicImage')"
                                >
                                    <span class="menu-item-text">
                                        Upload Public Images
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item -->

                            <!-- Menu Item -->
                            <li>
                                <a 
                                    href="#" 
                                    class="menu-item group"
                                    wire:click.prevent="selectContent('configurationList')"
                                >
                                    <span class="menu-item-text">
                                        Configurations
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item -->
                            
                            <!-- Menu Item -->
                            {{-- <li>
                                <a 
                                    href="#" 
                                    class="menu-item group"
                                    wire:click.prevent="selectContent('userRoles')"
                                >
                                    <span class="menu-item-text">
                                        User Roles
                                    </span>
                                </a>
                            </li> --}}
                            <!-- Menu Item -->

                            <!-- Menu Item -->
                            <li>
                                <a 
                                    href="#" 
                                    class="menu-item group"
                                    wire:click.prevent="selectContent('rolesAdmin')"
                                >
                                    <span class="menu-item-text">
                                        Roles Admin
                                    </span>
                                </a>
                            </li>
                            <!-- Menu Item -->                                                               

                        </ul>
                    </div>

                </nav>
            </div>
            
        </aside>

        {{-- MAIN --}}
        <div class="flex-1">
            <div class="">
                <div class="w-full">
                    @if($content == 'failedAttempts')
                        <livewire:admin.failed-attempts />
                    @endif
                    @if($content == 'successfulLogins')
                        <livewire:admin.successful-logins />
                    @endif
                    @if($content == 'cache')
                        <livewire:admin.cache-table />
                    @endif
                    @if($content == 'pageRouteList')
                        <livewire:admin.route-list />
                    @endif
                    @if($content == 'uploadPublicImage')
                        <livewire:upload-public-image />
                    @endif
                    @if($content == 'configurationList')
                        <livewire:admin.configuration-list />
                    @endif
                    @if($content == 'userRoles')
                        <livewire:user-roles />
                    @endif
                    @if($content == 'rolesAdmin')
                        <livewire:admin.roles-admin />
                    @endif                    
                </div>
            </div>
        </div>

    </div>

</div>
