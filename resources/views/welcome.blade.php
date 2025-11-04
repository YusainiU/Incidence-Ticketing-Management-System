@php

    //App Welcome Page

    $text = Config::get('steps.standardTextColor');
    $bg = Config::get('steps.standardBgColor');
    $shadow = Config::get('steps.shadow');
    $whiteBox = Config::get('steps.whiteBox');

    $body_bg_class = "$text $bg";
    $root_div_class = 'flex flex-col min-h-screen';
    $header_class = 'sticky top-0 z-40 flex-none mx-auto w-full bg-white dark:bg-gray-900';

    $banner = 'z-50 flex justify-center w-full px-4 py-3 border border-b border-zinc-800 bg-zinc-700 lg:py-4';
    $banner_item = 'items-center md:flex';
    $banner_item_paragraph = 'text-sm font-medium text-zinc-100 md:my-0';

    $menu = "w-full px-3 py-3 mx-auto lg:flex lg:justify-between max-w-8xl lg:px-3 $bg";
    $menu_container = 'w-full px-3 py-3 mx-auto lg:flex lg:justify-between max-w-8xl lg:px-3';
    $menu_logo = 'flex justify-between';
    $menu_content = 'flex items-center w-full lg:w-auto';
    $menu_content_items = 'flex flex-col py-2 lg:py-0 lg:flex-row lg:self-center w-full';
    $menu_link = 'block py-2 text-lg font-medium text-zinc-100 lg:px-3 lg:py-0 hover:text-yellow-400';
    $menu_content_items_right = 'lg:self-center flex items-center mb-4 lg:mb-0';

    $section = 'py-4 bg-zinc-900';
    
    $header_1 = 'mb-4 md:mb-2 text-xl md:text-4xl text-center font-bold dark:text-white text md:px-36';
    $header_2 = 'mb-4 text-2xl font-bold tracking-tight lg:font-extrabold lg:text-4xl lg:leading-snug dark:text-white lg:text-center 2xl:px-48';
    $paragraph_1 = 'mb-10 text-lg text-center px-4 md:px-60 font-normal text-gray-200 dark:text-gray-200';
    $paragraph_2 = 'mb-10 text-left text-lg font-normal text-gray-500 dark:text-gray-400';
    $paragraph_3 = 'mb-10 text-lg font-normal text-gray-500 dark:text-gray-400  text-left md:text-xl px-4 md:px-60';
    $paragraph_4 = 'text-left text-lg font-normal text-gray-500 dark:text-gray-400';
    $buttons_and_links_section = 'flex flex-col mb-8 md:flex-row lg:justify-center';
    $view = 'ml-4 md:ml-20 md:mr-20 md:mt-6 md:mb-6 md:pb-10 md:p-5';
    $img = 'rounded-lg w-5/6';
    $view_link = 'flex flex-row gap-1 items-center hover:text-yellow-400';

    $list = 'mb-6 list-inside list-none space-y-4 font-medium text-gray-900 text-white dark:text-white lg:mb-8';
    $list_item = 'flex items-center gap-2';
    $ellipsis = Config::get('steps.svg.svg_ellipsis');
    $arrowUp = Config::get('steps.svg.svg_arrow_up');
    $logo = Config::get('steps.svg.svg_logo');
    $logoPath = Config::get('steps.logo_path');
    $lineMotif = Config::get('steps.svg.svg_component');
    $arrowRight = Config::get('steps.svg.svg_next');
    $link = Config::get('steps.link');

    $horizontalLine = 'h-1 my-2 bg-gray-400 border-0 rounded-sm dark:bg-gray-700';
    $hrSection = "$horizontalLine  ml-28 mr-28";
    $hrView = 'h-1 my-8 bg-stone-500 border-0 rounded-sm dark:bg-stone-700 w-full';

    $views = [
        [
            'id' => 'dashboard',
            'file' => 'dashboard_view.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Dashboard View',
            'content' => 'details-dashboard',
        ],
        [
            'id' => 'customerList',
            'file' => 'customer_view.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Customer List View',
            'content' => 'details-customerListView',
        ],
        [
            'id' => 'customerProfile',
            'file' => 'customer_profile_view.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Customer Profile View',
            'content' => 'details-customerProfile',
        ],
        [
            'id' => 'customerProfileVideo',
            'file' => 'customer_profile_video.mp4',
            'path' => 'public_videos',
            'type' => 'video',
            'title' => 'More on Customer Profile',
            'content' => '',
        ],
        [
            'id' => 'customerPortalEnabled',
            'file' => 'customer_portal_enabled.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Customer Portal Administration View',
            'content' => '',
        ],        
        [
            'id' => 'customerPortalLogin',
            'file' => 'customer_portal_login.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Customer Portal Login View',
            'content' => '',
        ],            
        [
            'id' => 'customerPortal',
            'file' => 'customer_portal.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Customer Portal View',
            'content' => '',
        ],        
        [
            'id' => 'ticketCaseIncidence',
            'file' => 'ticket_list_view.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Ticket/Case/Incidence List View',
            'content' => 'details-incidenceListView',
        ],
        [
            'id' => 'incidenceListVideo',
            'file' => 'incidence_list_video.mp4',
            'path' => 'public_videos',
            'type' => 'video',
            'title' => 'More on Ticket/Case/Incidence List',
            'content' => '',
        ],
        [
            'id' => 'incidenceProfile',
            'file' => 'incidence_profile.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Ticket/Case/Incidence Profile View',
            'content' => 'details-incidenceProfile',
        ],
        [
            'id' => 'incidenceProfileVideo',
            'file' => 'incidence_profile_video.mp4',
            'path' => 'public_videos',
            'type' => 'video',
            'title' => 'More on Ticket/Case/Incidence Profile',
            'content' => '',
        ],
        [
            'id' => 'incidenceCalendar',
            'file' => 'incidence_calendar_view.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Ticket/Case/Incidence Calendar',
            'content' => 'details-incidenceCalendar',
        ],
        [
            'id' => 'productList',
            'file' => 'product_list_video.mp4',
            'path' => 'public_videos',
            'type' => 'video',
            'title' => 'Product List',
            'content' => '',
        ],
        [
            'id' => 'supplierList',
            'file' => 'supplier_list_view.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'Supplier List View',
            'content' => '',
        ],
        [
            'id' => 'serviceLevelAgreement',
            'file' => 'sla_list_view.png',
            'path' => 'public_image',
            'type' => 'image',
            'title' => 'Service Level Agreement',
            'content' => 'details-serviceLevelAgreement',
        ],
        [
            'id' => 'serviceLevelAgreementVideo',
            'file' => 'sla_list_video.mp4',
            'path' => 'public_video',
            'type' => 'video',
            'title' => 'More on Service Level Agreement',
            'content' => '',
        ],
        [
            'id' => 'fileManager',
            'file' => 'file_manager_view.png',
            'path' => 'public_image',
            'type' => 'image',
            'title' => 'File Manager',
            'content' => '',
        ],
        [
            'id' => 'userRoles',
            'file' => 'user_roles_view.png',
            'path' => 'public_image',
            'type' => 'image',
            'title' => 'User Roles Management',
            'content' => '',
        ],
        [
            'id' => 'userRolesVideo',
            'file' => 'user_roles_video.mp4',
            'path' => 'public_video',
            'type' => 'video',
            'title' => 'More on User Roles Management',
            'content' => '',
        ],
        [
            'id' => 'fileImportExample',
            'file' => 'import_example.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'File Import Example View',
            'content' => '',
        ],
        [
            'id' => 'fileExportExample',
            'file' => 'export_example.png',
            'path' => 'public_images',
            'type' => 'image',
            'title' => 'File Export Example View',
            'content' => '',
        ],                                                                                                            
    ];

    $ulItems[] = [
        [
            'href' => '#dashboard',
            'text' => 'View of the outstanding status of all the incidences/cases',
        ],
        [
            'href' => '#customerList',
            'text' => 'View of all customer sites',
        ],
        [
            'href' => '#customerProfileVideo',
            'text' => 'More on Customer Profile (Video)',
        ],
        [
            'href' => '#customerProfile',
            'text' => 'View of site profile',
        ],
        [
            'href' => '#ticketCaseIncidence',
            'text' => 'View of all tickets/incidences/cases',
        ],
        [
            'href' => '#incidenceListVideo',
            'text' => 'More on tickets/incidences/cases (Video)',
        ],        
    ];

    $ulItems[] = [
        [
            'href' => '#incidenceProfile',
            'text' => 'View of Ticket/Case/Incidence Profile',
        ],
        [
            'href' => '#incidenceProfileVideo',
            'text' => 'More on tickets/incidences/cases Profile (Video)',
        ],
        [
            'href' => '#incidenceCalendar',
            'text' => 'View on ticket/case/incidence calendar',
        ],
        [
            'href' => '#productList',
            'text' => 'View product list',
        ],
        [
            'href' => '#supplierList',
            'text' => 'View supplier list',
        ],
        [
            'href' => '#serviceLevelAgreement',
            'text' => 'View Service Level Agreement List',
        ],                                                           
    ];

    $ulItems[] = [
        [
            'href' => '#serviceLevelAgreementVideo',
            'text' => 'More on Service Level Agreement (Video)',
        ],
        [
            'href' => '#fileManager',
            'text' => 'View File Manager',
        ],
        [
            'href' => '#userRoles',
            'text' => 'View User Role Management',
        ],
        [
            'href' => '#userRolesVideo',
            'text' => 'More on User Role Management (Video)',
        ],
        [
            'href' => '#customerPortalEnabled',
            'text' => 'Customer Portal',
        ],                                                                                           
    ];    

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    

    <title>{{ Config::get('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="{{ $body_bg_class }}">
    <div class="{{ $root_div_class }}">
        <header class="{{ $header_class }}">
            <div id="banner" class="{{ $banner }}">
                <div class="{{ $banner_item }}">
                    <p class="{{ $banner_item_paragraph }}">
                        A Simple Ticket/Case/Incidence Management System
                    </p>
                </div>
            </div>
            <nav class="{{ $menu }}">
                <div class="{{ $menu_container }}">
                    <div class="{{ $menu_logo }}">
                        <div class="flex flex-col w-full justify-center">
                            <div class="w-48 h-22 pl-4">
                                <img src="{{ url($logoPath) }}" alt="logo" title="logo" />
                            </div>
                            {{-- <div class="mt-3 antialiased">
                                Simple Digital
                            </div> --}}
                        </div>
                    </div>
                    <div class="{{ $menu_content }}">
                        <ul class="{{ $menu_content_items }}">
                            @if (Route::has('login'))
                                @auth
                                    <li>
                                        @if (session('isCustomer') == 'true')
                                            <a href="{{ url('/customerViewProfile') }}" class="{{ $menu_link }}">
                                                Customer Portal
                                            </a>
                                        @endif
                                        @if (session('isInternal') == 'true')
                                            <a href="{{ url('/dashboard') }}" class="{{ $menu_link }}">
                                                Dashboard
                                            </a>
                                        @endif
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('internalLogin') }}" class="{{ $menu_link }}">
                                            Internal User
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('customerLogin') }}" class="{{ $menu_link }}">
                                            Customer Portal
                                        </a>
                                    </li>
                                @endauth
                            @endif
                            <li>
                                <a href="#contact" class="{{ $menu_link }}">Contact Me</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <div class="grow">

            {{-- Summary of the main features --}}
            <section class="{{ $section }}">

                <h1 class="{{ $header_1 }}">
                    A simple incidence/case management System for a small and medium size companies
                </h1>

                @include('livewire.page-text.introduction')
            </section>

            {{-- 
            <div class="mr-36 ml-36">
                <div class="inline-flex items-center justify-center w-full mt-10">
                    <hr class="{{ $hrView }} mt-10" />
                    <div class="absolute px-4 -translate-x-1/2 bg-zinc-900 left-1/2 dark:bg-zinc-900">
                        {!! $lineMotif !!}
                    </div>
                </div>
            </div> 
            --}}

            {{-- List of facilities in the Application --}}
            {{-- 
            <section class="{{ $section }}" id="facilities">
                <div class="{{ $view }}">
                    <h4 class="{{ $paragraph_2 }}">
                        List of the facilities highlighted by the features above ..
                    </h4>
                    <div class="flex md:gap-3 flex-col md:flex-row">
                        @foreach ($ulItems as $uls)
                            <ul class="{{ $list }} flex-1 flex-grow">
                                @foreach ($uls as $li)
                                    <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                                        <span>{!! $arrowRight !!}</span>
                                        <span>
                                            <a href="{{ $li['href'] }}" class="{{ $list_item }}">
                                                {{ $li['text'] }}
                                            </a>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                        <ul class="{{ $list }} flex-1 flex-col md:flex-grow w-full">
                            <li class="flex justify-center md:flex-row-reverse">
                                <img class="h-auto max-w-md rounded-lg border-zinc-700"
                                    src="{{ url('storage/public_images/img_code.jpg') }}" />
                            </li>
                        </ul>
                    </div>
                </div>
            </section> 
            --}}

            {{-- 
            <div class="mr-36 ml-36">
                <div class="inline-flex items-center justify-center w-full mt-10">
                    <hr class="{{ $hrView }} mt-10" />
                    <div class="absolute px-4 -translate-x-1/2 bg-zinc-900 left-1/2 dark:bg-zinc-900">
                        {!! $lineMotif !!}
                    </div>
                </div>
            </div> 
            --}}

            {{-- Images of the facilities --}}
            {{-- 
            <section class="{{ $section }}">

                <h2 class="{{ $header_1 }}">Views of the Application</h2>

                @foreach ($views as $v)
                    <div class="{{ $view }}" id="{{ $v['id'] }}">
                        <p class="{{ $paragraph_4 }} flex flex-row items-center gap-4">
                            {{ $v['title'] }}
                            <a href="#facilities" class="{{ $view_link }}">{!! $arrowUp !!} <span>Go to the
                                    Top</span></a>
                        </p>
                        <div class="mt-3 mb-5">
                            @if($v["content"])
                                @include('livewire.page-text.'.$v["content"])
                            @endif
                        </div>
                        <div class="flex {{ $whiteBox }} justify-center">
                            @if ($v['type'] == 'image')
                                <img src="{{ asset('storage/public_images/' . $v['file']) }}"
                                    class="{{ $img }}" />
                            @endif
                            @if ($v['type'] == 'video')
                                <video class="{{ $img }}" controls autoplay>
                                    <source src="{{ asset('storage/public_videos/' . $v['file']) }}"
                                        type="video/mp4" />
                                </video>
                            @endif
                        </div>
                        <div class="inline-flex items-center justify-center w-full mt-10">
                            <hr class="{{ $hrView }} mt-10" />
                            <div class="absolute px-4 -translate-x-1/2 bg-zinc-900 left-1/2 dark:bg-zinc-900">
                                {!! $lineMotif !!}
                            </div>
                        </div>
                    </div>
                @endforeach

            </section> 
            --}}
            
            {{-- Contact Me --}}
             
            <section class="{{ $section }}" id="contact">
                <div class="{{ $view }}">
                    <div class="{{ $whiteBox }}">
                        If you are interested to try the Application, Email me at&nbsp;<a href="mailto:Yusaini.Usulludin@proton.me" class="{{ $link }}">Yusaini.Usulludin@proton.me</a>&nbsp;for access details.
                    </div>
                </div>            
            </section>
            

        </div>
    </div>

    @livewire('steps-footer')

</body>

</html>
