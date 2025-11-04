<?php

    // SVGs Icons for STEPS
    $conf = Config::get('steps');
    $svgs = $conf['svg'];
    $svg_logout = $svgs['svg_logout'];
    $svg_account = $svgs['svg_account'];
    $svg_role = $svgs['svg_role'];
    $svg_user = $svgs['svg_user'];
    $svg_logo = $svgs['svg_logo'];
    $svg_customer = $svgs['svg_customer'];
    $svg_spanner = $svgs['svg_spanner'];
    $svg_product = $svgs['svg_product'];
    $svg_sla = $svgs['svg_sla'];
    $svg_supplier = $svgs['svg_supplier'];
    $svg_fileManager = $svgs['svg_fileManager'];
    $shadow = $conf['shadow'];
    $moniker = $conf['ticket'];
?>

<nav x-data="{ open: false }" class="bg-white dark:bg-slate-400 border-b border-gray-100 dark:border-gray-700 {{ $shadow }}">
    <div class="container flex flex-wrap items-center justify-between mx-auto text-slate-800 px-20">
        <a href="{{ route('customerViewProfile')}}" class="mr-4 flex flex-row gap-3 cursor-pointer py-1.5 text-base text-slate-800 font-semibold">
            {!! $svg_logo !!}
            <span class="pt-5">Customer Portal</span>
        </a>
        <div class="lg:block">
            <ul class="flex gap-2 mt-2 mb-4 lg:mb-0 lg:mt-0 lg:flex-row lg:items-center lg:gap-6">


                <li class="flex items-center p-1 text-sm gap-x-2 text-slate-900">
                    {!! $svg_spanner !!}
                    <a href="{{ route('customerTicketList') }}" class="flex items-center">
                        {{ $moniker }}
                    </a>
                </li>                 

                <li class="flex items-center p-1 text-sm gap-x-2 text-slate-900">
                    {!! $svg_customer !!}
                    <a href="{{ route('customerViewProfile') }}" class="flex items-center">
                        Profile
                    </a>
                </li> 

                <li class="flex items-center p-1 text-sm gap-x-2 text-slate-900">
                    {!! $svg_logout !!}
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <a href="{{ route('logout') }}" class="flex items-center" @click.prevent="$root.submit();">
                            Logout
                        </a>
                    </form>
                </li>                                                   
            </ul>
        </div>
        <button
            class="relative ml-auto h-6 max-h-[40px] w-6 max-w-[40px] select-none rounded-lg text-center align-middle text-xs font-medium uppercase text-inherit transition-all hover:bg-transparent focus:bg-transparent active:bg-transparent disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none lg:hidden"
            type="button">
            <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </span>
        </button>
    </div>
    <div class="lg:block bg-white dark:bg-slate-500">
        <div class="p-4 text-dark dark:text-slate-300">
             Logged in as: {{ Auth()->user()->name }}
        </div>
    </div>     
</nav>
