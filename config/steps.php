<?php

return [

    /*--------------------------------------------------------------------------
    | Blocked login after n failed attempts
    |--------------------------------------------------------------------------
    */

    'loginAttempts' => 3,
    'blockedDuration' => 30, //Minutes
    
    /*--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    */

    'logo_path' => 'storage/public_images/logo-1.png',
    
    /*
    |--------------------------------------------------------------------------
    | Nomenclatures
    |--------------------------------------------------------------------------
    */
    
    'ticket' => env('TICKET_MONIKER'),
    'prefix_ticket' => 'TN',
    'prefix_visit' => 'VS',
    'prefix_log' => 'LOG',
    'prefix_sla' => 'SLAT',
    'prefix_asset' => 'ASSET',
    'prefix_slap' => 'SLA',

    /*
    |--------------------------------------------------------------------------
    | SVG Icons Path
    |--------------------------------------------------------------------------
    |
    | Here you may specify the svg path for each of the icons used in 
    | the app
    |
    */

    'svg' => [
        'svg_edit' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>',
        'svg_logo' => '<svg height="68px" width="68px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 392.598 392.598" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#FFFFFF;" d="M196.299,115.006c-44.8,0-81.261,36.461-81.261,81.261s36.461,81.261,81.261,81.261 s81.261-36.461,81.261-81.261S241.099,115.006,196.299,115.006z"></path> <path style="fill:#56ACE0;" d="M295.079,59.669c0,20.881,17.002,37.883,37.883,37.883s37.883-17.002,37.883-37.883 s-17.002-37.883-37.883-37.883C312.081,21.786,295.079,38.788,295.079,59.669z"></path> <g> <path style="fill:#FFC10D;" d="M332.897,295.046c-20.881,0-37.883,17.002-37.883,37.883s17.002,37.883,37.883,37.883 c20.881,0,37.883-17.002,37.883-37.883S353.778,295.046,332.897,295.046z"></path> <path style="fill:#FFC10D;" d="M46.836,21.786c-13.834,0-25.018,11.184-25.018,25.018s11.313,25.018,25.018,25.018 s25.018-11.184,25.018-25.018S60.671,21.786,46.836,21.786z"></path> </g> <path style="fill:#56ACE0;" d="M68.622,298.861c-13.834,0-25.018,11.184-25.018,25.018c0,13.834,11.184,25.018,25.018,25.018 s25.018-11.184,25.018-25.018C93.705,310.109,82.457,298.861,68.622,298.861z"></path> <path style="fill:#194F82;" d="M332.897,273.261c-12.541,0-24.113,3.879-33.745,10.537l-22.82-22.885 c14.287-17.713,22.949-40.21,22.949-64.646s-8.663-46.998-22.949-64.646l22.82-22.82c9.568,6.659,21.269,10.537,33.745,10.537 c32.905,0,59.669-26.764,59.669-59.669S365.802,0,332.897,0s-59.669,26.764-59.669,59.669c0,12.541,3.879,24.113,10.537,33.745 l-22.82,22.82c-17.713-14.287-40.21-22.949-64.646-22.949s-46.998,8.663-64.646,22.949L86.788,71.37 c4.396-7.111,6.982-15.451,6.982-24.436C93.77,21.075,72.76,0,46.966,0S0.032,21.01,0.032,46.804s21.01,46.804,46.804,46.804 c8.986,0,17.325-2.521,24.436-6.982l44.865,44.994c-14.287,17.713-22.95,40.21-22.95,64.646c0,25.018,9.051,48.032,23.984,65.939 l-23.273,22.303c-7.24-4.719-15.903-7.499-25.277-7.499c-25.794,0-46.804,21.01-46.804,46.804s21.01,46.804,46.804,46.804 s46.804-21.01,46.804-46.804c0-8.663-2.392-16.679-6.465-23.661l23.855-22.885c17.519,13.77,39.499,22.044,63.418,22.044 c24.501,0,46.998-8.663,64.646-22.949l22.82,22.82c-6.659,9.568-10.537,21.269-10.537,33.745c0,32.905,26.764,59.669,59.669,59.669 s59.669-26.764,59.669-59.669C392.566,299.96,365.867,273.261,332.897,273.261z M370.78,59.669 c0,20.881-17.002,37.883-37.883,37.883s-37.883-17.002-37.883-37.883s17.002-37.883,37.883-37.883 C353.778,21.786,370.78,38.788,370.78,59.669z M46.836,71.887c-13.834,0-25.018-11.184-25.018-25.018s11.184-25.018,25.018-25.018 s25.018,11.313,25.018,25.018S60.671,71.887,46.836,71.887z M68.622,348.962c-13.834,0-25.018-11.184-25.018-25.018 c0-13.834,11.184-25.018,25.018-25.018s25.018,11.184,25.018,25.018C93.705,337.778,82.457,348.962,68.622,348.962z M196.299,277.527c-44.8,0-81.261-36.461-81.261-81.261s36.461-81.261,81.261-81.261s81.261,36.461,81.261,81.261 S241.099,277.527,196.299,277.527z M332.897,370.747c-20.881,0-37.883-17.002-37.883-37.883s17.002-37.883,37.883-37.883 c20.881,0,37.883,17.002,37.883,37.883S353.778,370.747,332.897,370.747z"></path> <path style="fill:#FFC10D;" d="M196.299,255.677c-32.776,0-59.41-26.634-59.41-59.41s26.634-59.41,59.41-59.41 s59.41,26.634,59.41,59.41S229.075,255.677,196.299,255.677z"></path> </g></svg>',
        'svg_arrow_up' => '<svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M7.60141 2.33683C7.73885 2.18084 7.9401 2.08243 8.16435 2.08243C8.16475 2.08243 8.16516 2.08243 8.16556 2.08243C8.35773 2.08219 8.54998 2.15535 8.69664 2.30191L12.6968 6.29924C12.9898 6.59203 12.9899 7.0669 12.6971 7.3599C12.4044 7.6529 11.9295 7.65306 11.6365 7.36027L8.91435 4.64004L8.91435 13.5C8.91435 13.9142 8.57856 14.25 8.16435 14.25C7.75013 14.25 7.41435 13.9142 7.41435 13.5L7.41435 4.64442L4.69679 7.36025C4.4038 7.65305 3.92893 7.6529 3.63613 7.35992C3.34333 7.06693 3.34348 6.59206 3.63646 6.29926L7.60141 2.33683Z" fill="#039855"></path></svg>',
        'svg_visit' => '<svg fill="#000000" class="h-6 w-6" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>home-blank</title> <path d="M30.814 13.051l-14.001-12c-0.217-0.187-0.502-0.3-0.813-0.3s-0.596 0.114-0.815 0.302l0.002-0.001-14 12c-0.268 0.23-0.437 0.57-0.437 0.948 0 0 0 0.001 0 0.001v-0 16c0 0.69 0.56 1.25 1.25 1.25h28c0.69-0.001 1.249-0.56 1.25-1.25v-16c-0-0.379-0.168-0.718-0.434-0.948l-0.002-0.001zM28.75 28.75h-25.5v-14.175l12.75-10.929 12.75 10.929z"></path> </g></svg>',
        'svg_offsite' => '<svg fill="#000000" class="h-6 w-6" viewBox="-14.68 0 122.88 122.88" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="enable-background:new 0 0 93.52 122.88" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css">.st0{fill-rule:evenodd;clip-rule:evenodd;}</style> <g> <path class="st0" d="M0.46,0h13.33c0.25,0,0.46,0.21,0.46,0.46v44.21l0.29-0.3l0.08-0.08c3.18-3.48,5.78-6.26,9.1-8.14 c3.36-1.9,7.4-2.84,13.42-2.58l0.01,0c2.15,0.03,4.69,0.26,6.78,0.46c0.97,0.09,1.84,0.17,2.59,0.22 c10.16,0.67,14.92,6.01,18.62,10.17c1.63,1.84,3.05,3.42,4.57,4.15c0.72,0.34,1.85-0.14,3.14-0.68c0.78-0.33,1.6-0.68,2.47-0.91 c0.56-0.21,0.87-0.33,1.11-0.42c0.31-0.12,0.52-0.2,0.64-0.24l9.24-3.66l0.04-0.01c1.24-0.42,2.68-0.16,3.95,0.59 c0.89,0.53,1.71,1.31,2.3,2.26c0.59,0.96,0.95,2.1,0.94,3.36c-0.01,1.81-0.81,3.83-2.82,5.83c-0.09,0.09-0.19,0.15-0.3,0.18 l-9.26,3.67l0,0l-0.86,0.3c-4.96,1.76-8.55,3.03-14.84,1.48c-0.05-0.01-0.09-0.03-0.13-0.05c-4.4-1.71-6.68-4.08-8.9-6.4 l-0.33-0.34l-2.81,17.91c2.51,1.58,5.02,2.75,7.39,3.86c7.2,3.36,13.12,6.12,14.39,17.43c0.23,2.03,0.12,3.94,0.01,6.02l0,0.03 c-0.02,0.3-0.03,0.63-0.07,1.4l-0.88,21.91c-0.02,0.43-0.38,0.76-0.8,0.75l-11.13,0.03c-0.43,0-0.78-0.35-0.78-0.78 c0.12-7.55,0.34-15.46,0.73-23l0.06-1.02c0.06-1.18,0.12-2.27,0.06-3.29c-0.06-0.97-0.24-1.88-0.64-2.75l-0.11-0.23 c-0.45-0.98-0.86-1.88-1.48-2.17c-1.23-0.57-3.18-1.28-5.4-2.01c-2.54-0.84-5.38-1.68-7.88-2.39c-1.84,6.08-4.33,13.44-7,20.43 c-2.39,6.24-4.92,12.21-7.27,16.74c-0.14,0.28-0.44,0.44-0.73,0.42l-11.69,0.06c-0.43,0-0.78-0.34-0.78-0.77 c0-0.1,0.02-0.2,0.06-0.29l0,0c2.34-5.75,5.1-13.22,7.75-20.81c2.71-7.77,5.31-15.69,7.23-22.05c-1.14-1.4-2.23-2.96-2.97-4.68 c-0.82-1.9-1.22-3.96-0.81-6.17l4.01-21.66l-0.23-0.01c-1.39-0.06-2.55-0.11-3.88,0.47c-1.82,0.8-3.26,2.42-4.86,4.22 c-0.65,0.73-1.32,1.49-2.09,2.27l-0.05,0.05c-0.57,0.59-1.17,1.2-1.73,1.77l-7.08,7.15c-0.11,0.11-0.24,0.18-0.38,0.21v59.84 c0,0.25-0.21,0.46-0.46,0.46H0.46c-0.25,0-0.46-0.21-0.46-0.46V0.46C0,0.21,0.21,0,0.46,0L0.46,0z M47.34,6.41 c3.18-1.09,6.51-0.78,9.31,0.59c2.8,1.37,5.08,3.82,6.17,7c1.09,3.18,0.78,6.51-0.59,9.31c-1.37,2.8-3.82,5.08-7,6.17 c-3.18,1.09-6.51,0.78-9.31-0.59c-2.8-1.37-5.08-3.82-6.17-7c-1.09-3.18-0.78-6.51,0.59-9.31C41.71,9.78,44.15,7.5,47.34,6.41 L47.34,6.41z M3.07,39.71h3.08v14.75H3.07V39.71L3.07,39.71z"></path> </g> </g></svg>',
        'svg_enroute' => '<svg fill="#000000" class="h-6 w-6" viewBox="0 0 64 64" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g transform="matrix(1,0,0,1,-352,0)"> <g id="car" transform="matrix(1,0,0,1,18.8303,0)"> <rect height="64" style="fill:none;" width="64" x="333.17" y="0"></rect> <g transform="matrix(1,0,0,1,269.17,-64)"> <path d="M78.342,106L72,106C71.47,106 70.961,105.789 70.586,105.414C70.211,105.039 70,104.53 70,104C70,100.707 70,94.282 70,92C70,91.47 70.211,90.961 70.586,90.586C71.938,89.234 75.321,85.851 77.414,83.757C78.539,82.632 80.066,82 81.657,82C86.201,82 95.799,82 100.343,82C101.934,82 103.461,82.632 104.586,83.757L110.828,90L114,90L114,90L116,90C117.591,90 119.117,90.632 120.243,91.757C121.368,92.883 122,94.409 122,96C122,98.822 122,101.999 122,104C122,104.53 121.789,105.039 121.414,105.414C121.039,105.789 120.53,106 120,106L113.658,106C112.834,108.329 110.61,110 108,110C105.39,110 103.166,108.329 102.342,106L89.658,106C88.834,108.329 86.61,110 84,110C81.39,110 79.166,108.329 78.342,106ZM108,102C106.896,102 106,102.896 106,104C106,105.104 106.896,106 108,106C109.104,106 110,105.104 110,104C110,102.896 109.104,102 108,102ZM84,102C82.896,102 82,102.896 82,104C82,105.104 82.896,106 84,106C85.104,106 86,105.104 86,104C86,102.896 85.104,102 84,102ZM113.658,102L118,102L118,96C118,94.895 117.105,94 116,94C113.396,94 109.172,94 109.172,94L109.172,94L92,94C90.895,94 90,93.105 90,92C90,91.47 90.211,90.961 90.586,90.586C90.961,90.211 91.47,90 92,90C96.12,90 105.172,90 105.172,90C105.172,90 102.868,87.697 101.757,86.586C101.382,86.211 100.874,86 100.343,86C97.055,86 84.945,86 81.657,86C81.126,86 80.618,86.211 80.243,86.586C78.588,88.24 74,92.828 74,92.828L74,102L78.342,102C79.166,99.671 81.39,98 84,98C86.61,98 88.834,99.671 89.658,102L102.342,102C103.166,99.671 105.39,98 108,98C110.61,98 112.834,99.671 113.658,102Z"></path> </g> </g> </g> </g></svg>',
        'svg_onsite' => '<svg fill="#000000" class="h-6 w-6" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>home-user</title> <path d="M30.814 13.051l-14.001-12c-0.217-0.187-0.502-0.3-0.813-0.3s-0.596 0.114-0.815 0.302l0.002-0.001-14 12c-0.268 0.23-0.437 0.57-0.437 0.948 0 0 0 0.001 0 0.001v-0 16c0 0.69 0.56 1.25 1.25 1.25h28c0.69-0.001 1.249-0.56 1.25-1.25v-16c-0-0.379-0.168-0.718-0.434-0.948l-0.002-0.001zM28.75 28.75h-25.5v-14.175l12.75-10.929 12.75 10.929zM11.68 14.088c0 2.386 1.934 4.32 4.32 4.32s4.32-1.934 4.32-4.32-1.934-4.32-4.32-4.32v0c-2.385 0.003-4.318 1.935-4.32 4.32v0zM17.82 14.088c-0 1.005-0.815 1.82-1.82 1.82s-1.82-0.815-1.82-1.82 0.815-1.82 1.82-1.82v0c1.005 0.002 1.819 0.816 1.82 1.82v0zM8.778 25.145c-0.018 0.080-0.028 0.171-0.028 0.265 0 0.691 0.56 1.251 1.251 1.251 0.595 0 1.093-0.416 1.22-0.973l0.002-0.008c0.5-2.213 2.449-3.842 4.779-3.842s4.278 1.627 4.772 3.807l0.006 0.033c0.126 0.567 0.625 0.984 1.221 0.984 0.69 0 1.249-0.559 1.249-1.249 0-0.094-0.010-0.186-0.030-0.274l0.002 0.008c-0.753-3.346-3.7-5.809-7.221-5.809s-6.467 2.461-7.212 5.757l-0.009 0.049z"></path> </g></svg>',
        'svg_ellipsis' => '<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M8 12C8 12.5523 7.55228 13 7 13C6.44772 13 6 12.5523 6 12C6 11.4477 6.44772 11 7 11C7.55228 11 8 11.4477 8 12Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M18 12C18 12.5523 17.5523 13 17 13C16.4477 13 16 12.5523 16 12C16 11.4477 16.4477 11 17 11C17.5523 11 18 11.4477 18 12Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M13 12C13 12.5523 12.5523 13 12 13C11.4477 13 11 12.5523 11 12C11 11.4477 11.4477 11 12 11C12.5523 11 13 11.4477 13 12Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>',
        'svg_flag_blue' => '<svg fill="#0e0aeb" class="h-6 w-6" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#0e0aeb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.25 2.979c-5 0-6.333-3-12.666-3-4.084 0-6.584 3.084-6.584 3.084v27.958c0 0.552 0.448 1 1 1s1-0.448 1-1v-12.746c1.055-0.68 2.511-1.296 4.334-1.296 6.333 0 8.166 3 13.166 3s8.5-3 8.5-3v-17s-3.75 3-8.75 3zM28 15.96c-1.13 0.737-3.524 2.019-6.5 2.019-1.966 0-3.308-0.54-5.007-1.223-2.071-0.832-4.419-1.777-8.159-1.777-1.709 0-3.159 0.43-4.334 1.005v-12.108c0.753-0.685 2.394-1.897 4.584-1.897 2.941 0 4.597 0.714 6.35 1.469 1.746 0.752 3.552 1.531 6.316 1.531 2.664 0 5.004-0.737 6.75-1.529v12.509z"></path> </g></svg>',
        'svg_flag_yellow' => '<svg fill="#2feb0a" class="h-6 w-6" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#2feb0a"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M21.25 2.979c-5 0-6.333-3-12.666-3-4.084 0-6.584 3.084-6.584 3.084v27.958c0 0.552 0.448 1 1 1s1-0.448 1-1v-12.746c1.055-0.68 2.511-1.296 4.334-1.296 6.333 0 8.166 3 13.166 3s8.5-3 8.5-3v-17s-3.75 3-8.75 3zM28 15.96c-1.13 0.737-3.524 2.019-6.5 2.019-1.966 0-3.308-0.54-5.007-1.223-2.071-0.832-4.419-1.777-8.159-1.777-1.709 0-3.159 0.43-4.334 1.005v-12.108c0.753-0.685 2.394-1.897 4.584-1.897 2.941 0 4.597 0.714 6.35 1.469 1.746 0.752 3.552 1.531 6.316 1.531 2.664 0 5.004-0.737 6.75-1.529v12.509z"></path> </g></svg>',
        'svg_bell_red' => '<svg class="h-6 w-6" viewBox="-6.4 -6.4 76.80 76.80" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#fcfcfc" fill="none" transform="rotate(0)"><g id="SVGRepo_bgCarrier" stroke-width="0"><rect x="-6.4" y="-6.4" width="76.80" height="76.80" rx="38.4" fill="#ee1f11" strokewidth="0"></rect></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M13.4,51V46.21s4.83-.24,4.83-4.83V26.1s-.05-12.67,13.63-12.67c12.06,0,15,7,15,12.21V42.23s-.36,4,4.8,4V51Z"></path><path d="M36.24,13.79V12.47a3.74,3.74,0,0,0-7.48,0v1.2"></path><path d="M36.33,51a4.57,4.57,0,0,1-9.13,0"></path><path d="M50.5,33.49A4.67,4.67,0,0,1,52,41.08"></path><path d="M53.3,30a8,8,0,0,1,2.59,13"></path><path d="M14,33.74a4.66,4.66,0,0,0-1.51,7.59"></path><path d="M11.17,30.26a8,8,0,0,0-2.59,13"></path></g></svg>',
        'svg_cross_x_complete' => '<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" /></svg>',
        'svg_logout' => '<svg fill="#000000" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490.3 490.3" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-slate-500"><g><g><path d="M0,121.05v248.2c0,34.2,27.9,62.1,62.1,62.1h200.6c34.2,0,62.1-27.9,62.1-62.1v-40.2c0-6.8-5.5-12.3-12.3-12.3s-12.3,5.5-12.3,12.3v40.2c0,20.7-16.9,37.6-37.6,37.6H62.1c-20.7,0-37.6-16.9-37.6-37.6v-248.2c0-20.7,16.9-37.6,37.6-37.6h200.6c20.7,0,37.6,16.9,37.6,37.6v40.2c0,6.8,5.5,12.3,12.3,12.3s12.3-5.5,12.3-12.3v-40.2c0-34.2-27.9-62.1-62.1-62.1H62.1C27.9,58.95,0,86.75,0,121.05z" /><path d="M385.4,337.65c2.4,2.4,5.5,3.6,8.7,3.6s6.3-1.2,8.7-3.6l83.9-83.9c4.8-4.8,4.8-12.5,0-17.3l-83.9-83.9c-4.8-4.8-12.5-4.8-17.3,0s-4.8,12.5,0,17.3l63,63H218.6c-6.8,0-12.3,5.5-12.3,12.3c0,6.8,5.5,12.3,12.3,12.3h229.8l-63,63C380.6,325.15,380.6,332.95,385.4,337.65z" /></g></g></svg>',
        'svg_account' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-slate-500"> <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /></svg>',
        'svg_role' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#000000" viewBox="0 0 219 256" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-slate-500"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g> <path stroke-linecap="round" stroke-linejoin="round" d="M74.497,26.841C74.497,13.122,85.619,2,99.338,2s24.841,11.122,24.841,24.841s-11.122,24.841-24.841,24.841 S74.497,40.56,74.497,26.841z M194.263,116.041l11.666-60.649l-11.088-2.133l-10.773,56.007h-28.586 c0.112-0.662,0.186-1.336,0.19-2.029c0.032-6.86-5.503-12.446-12.363-12.478l-49.004-0.225L80.906,58.619 c-2.479-9.253-8.64-15.714-19.406-15.714c-11.473,0-19.169,10.43-23.135,21.196c-7.904,21.453-13.549,57.585-11.26,81.05 c1.239,10.961,4.18,19.949,11.597,23.958H18.041V93.835H2.234v159.959h15.808v-68.876h74.535l-10.394,51.496 c-1.604,7.947,3.538,15.689,11.484,17.293c0.98,0.197,1.957,0.293,2.92,0.293c6.843,0,12.967-4.811,14.373-11.777l9.152-45.342 l12.66,33.953c2.202,5.906,7.802,9.555,13.756,9.555c1.704,0,3.436-0.299,5.126-0.93c7.596-2.832,11.458-11.286,8.625-18.882 l-25.734-69.015c-2.141-5.743-7.625-9.55-13.753-9.55H82.342l-0.018-9.033h118.634v120.816h15.808V116.041H194.263z" /></g></svg>',
        'svg_user' => '<svg xmlns="http://www.w3.org/2000/svg" fill="#000000" viewBox="0 0 472.615 472.615" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-slate-500"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g> <path d="M181.231,101.739c-50.572,0-91.482,40.911-91.482,91.362c0,21.47,7.394,41.149,19.68,56.774 c16.698,21.111,42.7,34.708,71.802,34.708s54.984-13.597,71.682-34.708c12.285-15.625,19.681-35.304,19.681-56.774 C272.594,142.65,231.683,101.739,181.231,101.739z" /> <path d="M272.464,257.105c-1.222,1.745-2.42,3.502-3.748,5.193c-21.461,27.122-53.526,42.65-88.029,42.65 c-34.58,0-66.694-15.527-88.116-42.601c-1.335-1.698-2.538-3.464-3.767-5.217C36.472,280.319,0,332.574,0,393.473v55.53h361.368 v-55.53C361.368,332.58,324.808,280.233,272.464,257.105z" /> <path d="M291.933,23.613c-39.593,0-73.225,24.875-86.388,59.775c49.9,11.352,87.293,55.992,87.293,109.283 c0,5.275-0.492,10.455-1.207,15.583c0.101,0.001,0.199,0.018,0.302,0.018c29.39,0,55.529-13.731,72.393-35.052 c12.407-15.779,19.875-35.654,19.875-57.337C384.201,64.93,342.884,23.613,291.933,23.613z" /></g></svg>',
        'svg_customer' => '<svg viewBox="0 0 1024 1024" class="h-6 w-6" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g> <path d="M841.2 841.1H182.9V182.9h292.5v-73.2H109.7v804.6h804.6V621.7h-73.1z" /> <path d="M402.3 585.1h73.1c0-100.8 82-182.9 182.9-182.9s182.9 82 182.9 182.9h73.1c0-102.2-60.2-190.6-147-231.6 23.2-25.9 37.3-60.1 37.3-97.5 0-80.8-65.5-146.3-146.3-146.3-80.8 0-146.3 65.5-146.3 146.3 0 37.5 14.1 71.7 37.3 97.5-86.8 41.1-147 129.4-147 231.6z m256-402.2c40.3 0 73.1 32.8 73.1 73.1s-32.8 73.1-73.1 73.1-73.1-32.8-73.1-73.1 32.8-73.1 73.1-73.1zM219.4 256h219.4v73.1H219.4zM219.4 658.3h585.1v73.1H219.4zM219.4 402.3h146.3v73.1H219.4z" /> </g> </svg>',
        'svg_spanner' => '<svg fill="#000000" class="h-6 w-6" viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" class=" text-slate-500"> <g id="SVGRepo_bgCarrier" stroke-width="0"></g> <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g> <g id="SVGRepo_iconCarrier" stroke-width="0"></g> <g> <path d="m773.596 1069.654 711.086 711.085c39.632 39.632 104.336 39.632 144.078 0l138.276-138.385c19.268-19.269 29.888-44.778 29.888-71.93 0-27.26-10.62-52.77-29.888-72.039l-698.714-698.714 11.495-32.625c63.5-178.675 18.284-380.45-115.284-514.018-123.715-123.605-305.126-171.01-471.648-128.313l272.281 272.282c32.516 32.406 50.362 75.652 50.362 121.744 0 45.982-17.846 89.227-50.362 121.744L654.48 751.17c-67.222 67.003-176.375 67.003-243.488 0L138.711 478.889c-42.589 166.522 4.707 347.934 128.313 471.648 123.714 123.715 306.22 172.325 476.027 127.218l30.545-8.101ZM1556.611 1920c-54.084 0-108.168-20.692-149.333-61.857L740.095 1190.96c-198.162 41.712-406.725-19.269-550.475-163.019C14.449 852.771-35.256 582.788 65.796 356.27l32.406-72.696 390.194 390.193c24.414 24.305 64.266 24.305 88.68 0l110.687-110.686c11.824-11.934 18.283-27.59 18.283-44.34 0-16.751-6.46-32.516-18.283-44.34L297.569 84.207 370.265 51.8C596.893-49.252 866.875.453 1041.937 175.515c155.026 155.136 212.833 385.157 151.851 594.815l650.651 650.651c39.961 39.852 61.967 92.95 61.967 149.443 0 56.383-22.006 109.482-61.967 149.334l-138.275 138.385c-41.275 41.165-95.36 61.857-149.553 61.857Z" fill-rule="evenodd"/> </g> </svg>',
        'svg_product' => '<svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" xml:space="preserve" class="h-6 w-6" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;} .st1{fill:none;stroke:#000000;stroke-width:2;stroke-linejoin:round;stroke-miterlimit:10;} </style> <polyline class="st0" points="29,6 29,4 3,4 3,23 14,23 "></polyline> <polyline class="st0" points="15,29 10,29 12,26 "></polyline> <path class="st0" d="M27,29h-7c-1.1,0-2-0.9-2-2V12c0-1.1,0.9-2,2-2h7c1.1,0,2,0.9,2,2v15C29,28.1,28.1,29,27,29z"></path> <line class="st0" x1="18" y1="23" x2="29" y2="23"></line> <line class="st0" x1="22" y1="26" x2="25" y2="26"></line> </g></svg>',
        'svg_sla' => '<svg fill="#000000" class="h-6 w-6" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 490 490" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g id="line_20_"> <path d="M245,490c120.595,0,218.693-98.328,218.693-219.182c0-55.125-20.568-105.428-54.222-143.979l17.477-17.584l15.748,14.08 l20.385-22.818l-56.38-50.38l-20.385,22.818l17.768,15.87l-16.283,16.375c-34.709-30.133-78.907-49.386-127.497-52.783V30.608 h45.59V0H184.121v30.608h45.575v21.808C116.248,60.343,26.307,155.135,26.307,270.802C26.307,391.672,124.405,490,245,490z M245,82.243c103.699,0,188.085,84.585,188.085,188.559c0,103.99-84.386,188.575-188.085,188.575S56.915,374.792,56.915,270.802 C56.915,166.828,141.301,82.243,245,82.243z"></path> <polygon points="387.449,338.078 260.334,237.562 260.334,113.83 229.727,113.83 229.727,252.376 368.457,362.075 "></polygon> </g> </g></svg>',
        'svg_supplier' => '<svg fill="#000000" class="h-6 w-6" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>box-open</title> <path d="M29.742 5.39c-0.002-0.012-0.010-0.022-0.012-0.034-0.014-0.057-0.032-0.106-0.055-0.152l0.002 0.004c-0.017-0.046-0.036-0.086-0.059-0.124l0.002 0.003c-0.033-0.044-0.069-0.082-0.108-0.117l-0.001-0.001c-0.023-0.028-0.046-0.053-0.071-0.076l-0-0-0.023-0.011c-0.044-0.027-0.095-0.050-0.149-0.067l-0.005-0.002c-0.034-0.016-0.073-0.031-0.115-0.043l-0.005-0.001-0.028-0.010-12.999-2c-0.034-0.006-0.074-0.009-0.114-0.009s-0.080 0.003-0.119 0.009l0.004-0.001-13.026 2.010c-0.054 0.014-0.101 0.032-0.146 0.054l0.004-0.002c-0.052 0.018-0.096 0.039-0.138 0.064l0.003-0.002-0.024 0.011c-0.025 0.023-0.047 0.048-0.068 0.074l-0.001 0.001c-0.041 0.036-0.078 0.075-0.11 0.118l-0.001 0.002c-0.020 0.034-0.039 0.074-0.055 0.115l-0.002 0.005c-0.021 0.042-0.039 0.090-0.052 0.141l-0.001 0.005c-0.003 0.013-0.011 0.023-0.013 0.036l-1 6.75c-0.005 0.033-0.008 0.071-0.008 0.11 0 0.361 0.255 0.663 0.595 0.734l0.005 0.001 1.445 0.296c-0.025 0.065-0.041 0.14-0.044 0.218l-0 0.002v12.5c0 0 0 0 0 0 0 0.36 0.254 0.66 0.592 0.733l0.005 0.001 12 2.5c0.046 0.010 0.099 0.016 0.153 0.016s0.107-0.006 0.158-0.017l-0.005 0.001 11.999-2.5c0.344-0.073 0.597-0.374 0.598-0.734v-12.5c-0.004-0.080-0.020-0.155-0.046-0.225l0.002 0.005 1.445-0.296c0.345-0.072 0.6-0.373 0.6-0.734 0-0.039-0.003-0.077-0.009-0.115l0.001 0.004zM16 4.259l8.351 1.285-8.351 1.446-8.351-1.446zM3.629 6.37l11.295 1.955-2.364 5.319-9.714-1.987zM4.75 13.578l8.1 1.657c0.046 0.010 0.099 0.016 0.153 0.016 0.303 0 0.564-0.181 0.681-0.441l0.002-0.005 1.564-3.52v16.294l-10.5-2.188zM27.25 25.391l-10.5 2.188v-16.294l1.564 3.52c0.12 0.264 0.382 0.445 0.685 0.445h0c0 0 0 0 0 0 0.053 0 0.105-0.006 0.155-0.017l-0.005 0.001 8.1-1.657zM19.441 13.645l-2.365-5.319 11.295-1.955 0.783 5.287z"></path> </g></svg>',
        'svg_fileManager' => '<svg class="h-6 w-6" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g fill="none" fill-rule="evenodd" stroke="#000000" stroke-linecap="round" stroke-linejoin="round" transform="translate(3 2)"> <path d="m14.5 12.5v-7l-5-5h-5c-1.1045695 0-2 .8954305-2 2v10c0 1.1045695.8954305 2 2 2h8c1.1045695 0 2-.8954305 2-2z"></path> <path d="m.5 2.5v10c0 2.209139 1.790861 4 4 4h8m-3-16v3c0 1.1045695.8954305 2 2 2h3"></path> </g> </g></svg>',
        'svg_previous' => '<svg class="h-6 w-6" viewBox="0 0 24 24" fill="#000000" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M14.2893 5.70708C13.8988 5.31655 13.2657 5.31655 12.8751 5.70708L7.98768 10.5993C7.20729 11.3805 7.2076 12.6463 7.98837 13.427L12.8787 18.3174C13.2693 18.7079 13.9024 18.7079 14.293 18.3174C14.6835 17.9269 14.6835 17.2937 14.293 16.9032L10.1073 12.7175C9.71678 12.327 9.71678 11.6939 10.1073 11.3033L14.2893 7.12129C14.6799 6.73077 14.6799 6.0976 14.2893 5.70708Z" class="fill-current"></path> </g></svg>',
        'svg_next' => '<svg class="h-6 w-6" viewBox="0 0 24 24" fill="#000000" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.71069 18.2929C10.1012 18.6834 10.7344 18.6834 11.1249 18.2929L16.0123 13.4006C16.7927 12.6195 16.7924 11.3537 16.0117 10.5729L11.1213 5.68254C10.7308 5.29202 10.0976 5.29202 9.70708 5.68254C9.31655 6.07307 9.31655 6.70623 9.70708 7.09676L13.8927 11.2824C14.2833 11.6729 14.2833 12.3061 13.8927 12.6966L9.71069 16.8787C9.32016 17.2692 9.32016 17.9023 9.71069 18.2929Z" class="fill-current"></path> </g></svg>',
        'svg_calendar' => '<svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M3 9H21M7 3V5M17 3V5M6 13H8M6 17H8M11 13H13M11 17H13M16 13H18M16 17H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>',
        'svg_asset' => '<svg fill="#000000" class="h-9 w-9" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="m47.44 61.66a1 1 0 0 1 1 .91v14.37a3.06 3.06 0 0 1 -2.87 3h-20.49a3.06 3.06 0 0 1 -3-2.88v-14.38a1 1 0 0 1 .91-1h24.5zm29.51 0a1 1 0 0 1 1 .91v14.37a3.06 3.06 0 0 1 -2.87 3h-20.49a3.06 3.06 0 0 1 -3-2.88v-14.38a1 1 0 0 1 .91-1h24.5zm-37.36 4.23-.09.11-5.82 6.32-2.63-2.55a.77.77 0 0 0 -1-.08l-.09.08-1.09 1a.62.62 0 0 0 -.07.9l.07.08 3.73 3.54a1.56 1.56 0 0 0 1.08.45 1.43 1.43 0 0 0 1.09-.45l3.14-3.32.63-.67 3.14-3.31a.78.78 0 0 0 .06-.9l-.06-.08-1.09-1a.76.76 0 0 0 -1-.12zm29.51 0-.1.11-5.82 6.32-2.64-2.55a.75.75 0 0 0 -1-.08l-.09.08-1.09 1a.62.62 0 0 0 -.07.9l.07.08 3.73 3.54a1.54 1.54 0 0 0 1.08.45 1.43 1.43 0 0 0 1.09-.45l3.14-3.32.63-.67 3.14-3.31a.78.78 0 0 0 .06-.9l-.06-.08-1.07-1.01a.76.76 0 0 0 -1-.11zm-23.43-14.41a3 3 0 0 1 2.85 2.87v3.24a1 1 0 0 1 -.84 1h-26.68a1 1 0 0 1 -.94-.9v-3.16a3 3 0 0 1 2.69-3.05h23zm31.48 0a3 3 0 0 1 2.85 2.87v3.24a1 1 0 0 1 -.84 1h-26.73a1 1 0 0 1 -1-.9v-3.16a3 3 0 0 1 2.68-3.05h23zm-15-21.29a1 1 0 0 1 1 .91v14.37a3.06 3.06 0 0 1 -2.87 3.05h-20.44a3.06 3.06 0 0 1 -3.05-2.87v-14.44a1 1 0 0 1 .9-1h24.51zm-7.85 4.22-.09.08-5.82 6.32-2.59-2.56a.76.76 0 0 0 -1-.07l-.09.07-1.08 1a.61.61 0 0 0 -.07.9l.07.08 3.72 3.53a1.56 1.56 0 0 0 1.09.45 1.43 1.43 0 0 0 1.08-.45l3.14-3.31.64-.67 3.13-3.32a.78.78 0 0 0 .06-.9l-.06-.07-1.08-1a.77.77 0 0 0 -1-.08zm7.9-14.41a3.06 3.06 0 0 1 3 2.88v3.23a1 1 0 0 1 -.91 1h-28.52a1 1 0 0 1 -1-.91v-3.14a3.06 3.06 0 0 1 2.87-3h24.56z"></path></g></svg>',
        
    ],

    /*
    |--------------------------------------------------------------------------
    | Elements Classes
    |--------------------------------------------------------------------------
    */

    'tableClasses' => [
        'table' => 'w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400',
        'tbody' => 'bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200',
        'thead' => 'text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400',
        'td' => 'text-gray-600 px-6 py-3 border-t border-gray-100 whitespace-nowrap px-6 py-4',
        'th' => 'text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 px-6 py-3',
        'colTr' => 'text-left',
        'divTop' => 'mt-10 ml-10 mr-10',
        'divSeparator' => '', //shadow-slate-400 shadow-md h-0 mb-5 mt-5
    ],

    'shadow' => 'shadow-[rgba(0,0,15,0.3)_0px_5px_4px_0px]',

    'standardTextColor' => 'text-zinc-100',
    
    'standardBgColor' => 'bg-zinc-900',

    'widget' => [
        'text' => 'text-sm text-stone-900',
        'title' => 'mt-2 text-title-sm font-bold text-stone-900',
        'header' => 'mt-2 text-center text-2xl font-bold text-stone-900',
        'container' => 'shadow-default rounded-2xl px-5 pb-11 pt-5 bg-stone-300 sm:px-6 sm:pt-6 border border-stone-400 shadow-[rgba(0,0,15,0.3)_0px_5px_4px_0px]',
        'grid' => 'col-span-4 xl:col-span-4',
        'content' => 'flex items-center justify-center gap-5 px-6 py-3.5 sm:gap-8 sm:py-5',
    ],

    'buttonClasses' => [
        'btnX' => 'text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white',
        'btnGrey' => 'bg-white text-gray-800 hover:bg-gray-100 font-semibold py-2 px-4 border border-gray-400 rounded shadow',
        'btnRed' => 'bg-red-800 text-white hover:bg-red-300 font-semibold py-2 px-4 border border-gray-400 rounded shadow',
        'btnBlue' => 'bg-blue-800 hover:bg-blue-500 text-white hover:bg-blue-300 font-semibold py-2 px-4 border border-gray-400 rounded shadow',
        'btnToggleLink' => 'inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150',
        'btnToggleContent' => 'block px-4 py-2 text-xs text-gray-400',
        'btnEdit' => "text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800",
        'btnDelete' => 'text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800',
    ],

    'buttonGroup' => [
        'groupContainer' => "inline-flex rounded-md shadow-xs",
        'groupBtnFirst' => "px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white",
        'groupBtnMiddle' => "px-4 py-2 text-sm font-medium text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white",
        'groupBtnLast' => "px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white",
    ],

    /*
        Use with <div></div>
    */

    'alert' => [
        'info' => "p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400",
        'danger' => "p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400",
        'success' => "p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400",
        'warning' => "p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300",
        'dark' => 'p-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300',
        'resolved' => 'block bg-green-800 text-yellow-400 p-1',
    ],

    'form' => [
        'label' => "block uppercase tracking-wide text-xs font-bold mb-2 text-base leading-relaxed text-dark dark:text-white",
        'value' => "tracking-wide text-sm    mb-2 text-base leading-relaxed text-dark dark:text-white",
        'input-normal' => "appearance-none text-black block w-full border border-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500",
        'input-required' => "appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white",
        'field-info' => "text-gray-600 text-xs italic",
        'field-warning' => "text-red-500 text-xs italic",
        'textarea' => "block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500",
        'select' => "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500",
        'checkbox' => "w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:border-gray-600",
        'checkboxLabel' => "ms-2 text-sm font-medium text-gray-900 dark:text-gray-300",
        'fileInput' => 'block w-full text-xl text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400x',
    ],

    /* 
        Use with <span> tag 
        example ..
        <span class="{{ $container }}">
            <span class="{{ $blue }}></span>
            Some text
        </span>
    */
    'indicators' => [
        'container' => "flex items-center text-sm font-medium text-gray-900 dark:text-white me-3",
        'gray' => "flex w-3 h-3 me-3 bg-gray-200 rounded-full",
        'dark' => "flex w-3 h-3 me-3 bg-gray-900 rounded-full dark:bg-gray-700",
        'blue' => "flex w-3 h-3 me-3 bg-blue-600 rounded-full",
        'green' => "flex w-3 h-3 me-3 bg-green-500 rounded-full",
        'red' => "flex w-3 h-3 me-3 bg-red-500 rounded-full",
        'yellow' => "flex w-3 h-3 me-3 bg-yellow-300 rounded-full",
    ],

    /*
        use with <span></span>
    */
    'badges' => [
        'blue' => 'bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300',
        'red' => 'bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300',
        'green' => 'bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-green-900 dark:text-green-300',
        'yellow' => 'bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-yellow-900 dark:text-yellow-300',
    ],

    'tabs' => [
        'activeTab' => 'inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500',
        'inactiveTab' => 'inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300',
    ],

    'fullWidthTab' => [
        'tabUl' => "hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm sm:flex dark:divide-gray-700 dark:text-gray-400",
        'tabLi' => "w-full focus-within:z-10",
        'tabHrefActive' => "inline-block w-full p-4 text-gray-900 bg-gray-100 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 active focus:outline-none dark:bg-gray-700 dark:text-white",
        'tabHrefInActive' => "inline-block w-full p-4 bg-white border-r border-gray-200 dark:border-gray-700 hover:text-gray-700 hover:bg-gray-50 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700",
    ],

    'whiteBox' => "block mt-3 p-6 border border-gray-600 rounded-lg shadow-sm",

    "link" => "font-medium text-blue-600 dark:text-blue-500 hover:underline",

    'linkDanger' => "font-medium text-red-600 dark:text-red-500 hover:underline",

    "tooltip" => "absolute z-50 whitespace-normal break-words rounded-lg bg-black py-1.5 px-3 font-sans text-sm font-normal text-white focus:outline-none",

    'descriptionList' => [
        'dl' => "w-full text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700",
        'dlSection' => "flex flex-col pb-3",
        'dt' => "mb-1 text-gray-500 md:text-lg dark:text-gray-400",
        'dd' => "text-lg font-semibold",
    ],

    'timeline' => [
        "ol-header" => "relative border-s border-blue-200 dark:border-gray-300",
        "li-item" => "mb-10 ms-6",
        "li-svg-span" => "absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-dark dark:ring-white dark:bg-blue-900",
        "li-svg" => [
            "class" => "w-2.5 h-2.5 text-blue-800 dark:text-blue-300",
            "aria-hidden" => "true",
            "xmlns" => "http://www.w3.org/2000/svg",
            "fill" => "currentColor",
            "viewBox" => "0 0 20 20",
        ],
        "li-svg-path-d" => "M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z",
        "li-h3-header" => "flex items-center mb-1 text-sm font-semibold text-gray-900 dark:text-white",
        "li-header-span-info" => "bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300 ms-3",
        "li-header-span-urgent" => "bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300 ms-3",
        "li-datetime" => "block mb-2 text-sm font-normal leading-none text-gray-400 dark:text-white",
        "li-p-content" => "mb-4 text-base font-normal text-gray-500 dark:text-white border rounded-md  border-slate-500 dark:border-slate-200 p-4",
        "li-ahref" => "inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-100 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700",
    ],

    /*
    |--------------------------------------------------------------------------
    | List of Product Types
    |--------------------------------------------------------------------------
    */

    'productTypes' => [
        'Hardware',
        'Software',
        'Services',
        'Network'
    ],

    /*
    |--------------------------------------------------------------------------
    | List of Product Manufacturer or Service Provider
    |--------------------------------------------------------------------------
    */

    'productManufacturer' => [
        'Mitel',
        'Avaya',
        'Microsoft',
        'Huawei',
        'Cisco',
    ],

    /*
    |--------------------------------------------------------------------------
    | List of SLA types
    |--------------------------------------------------------------------------
    */

    'slaTypes' => [
        'Support',
        'Service',
    ],

    /*
    |--------------------------------------------------------------------------
    | Ticket Management Config
    |--------------------------------------------------------------------------
    */

    'ticketManagement' => [

        'priority' => [
            'Urgent',
            'Not-Urgent',
        ],

        'state' => [
            'open' => 'Open',
            'closed' => 'Closed',
            'resolved' => 'Resolved',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
        ],

        'category' => [
            'Failure',
            'Part Replacement',
            'Technical Support',
        ],

        'source' => [
            'Phone',
            'Email',
            'Portal',
        ],
        'resolution' => [
            'No Fault Found',
            'Part Replacement',
            'User Error',
            'Configuration Changes',
            'Software Upgrade',
            'Software Downgrade',
            'System Reset',
            'Technical Support',
            'System Features',
            'Network Configuration',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Task Management Config
    |--------------------------------------------------------------------------
    */

    'taskManagement' => [
        'type' => [
            'sla' => 'Service Level Agreement',
        ],
        'state' => [
            'Completed' => 'completed',
            'Paused' => 'paused',
            'In Progress' => 'in_progress',
            'Open' => 'open',
            'Resolved' => 'resolved',
        ],
    ],

    'logs' => [
        'type' => [
            'system' => 'system_log',
            'error' => 'error_log',
            'sla_tasks' => 'sla_tasks_log',
            'ticket' => 'ticket_log',
            'resolution' => 'resolution',
            'completed' => 'completed',
            'site_visit' => 'site_visit',
            'site_visit_first' => 'site_visit_first',
            'site_visit_note' => 'site_visit_note',
            'site_visit_onsite' => 'site_visit_onsite',
            'site_visit_enroute' => 'site_visit_enroute',
            'site_visit_offsite' => 'site_visit_offsite',
        ],
        'source' => [
            'system' => 'system',
            'external' => 'external',
            'internal' => 'internal',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | List of Routes for Access/Edit Configuration 
    |--------------------------------------------------------------------------
    */

    'routes' => [
        'Dashboard' => 'dashboard',
        'User List' => 'userList',
        'User Profile' => 'userProfile',
        'User Roles' => 'userRoles',
        'Customer List' => 'customerList',
        'Customer Profile' => 'customerProfile',
        'Project File Manager' => 'projectFileManager',
        'Product List' => 'productList',
        'Supplier List' => 'supplierList',
        'Asset Profile' => 'assetProfile',
        'Service Level Agreement List' => 'serviceLevelAgreementList',
        'SLA Application' => 'slaApplicationTable',
        'Create New Ticket' => 'createNewTicket',
        'Ticket Profile' => 'ticketProfile',
        'Progress Log Timeline' => 'progressLogTimeline',
        'Ticket List' => 'ticketList',
        'Add New Roles' => 'addNewRoles',
        'Add Route to Roles' => 'addRoutesToRoles',
        'Create New Role' => 'createNewRole',
        'Add User to Role' => 'addUserToRole',
        'Admin Dashboard' => 'adminDashboard',
        'Assets List' => 'assetTable',
        'Create New Asset' => 'createNewAsset',
        'Create New Customer' => 'createNewCustomer',
        'Create New Product' => 'createNewProduct',
        'Create New Service Level Agreement' => 'createNewServiceLevelAgreement',
        'Create New Supplier' => 'createNewSupplier',
        'Create New User' => 'createNewUser',
        'Create SLA Application' => 'createSlaApplication',
        'Add Customer Contact to Role' => 'addCustomerContactToRole',
        'Edit Customer Details' => 'editCustomerDetails',
        'Edit Service Level Agreement' => 'editServiceLevelAgreement',
        'Edit SLA Application' => 'editSlaApplication',
        'Edit User Details' => 'editUserDetails',
        'Delete User' => 'deleteUser',
        'Customer Contact' => 'customerContact',
        'Ticket Audit Log' => 'ticketAuditLog',
        'Deleted Ticket List' => 'ticketDeletedList',
        'Failed Attempts' => 'failedAttempts',
        'Successful Logins' => 'successfulLogins',
        'Cache Table' => 'cacheTable',
        'Route List' => 'routeList',
        'Configuration List' => 'configurationList',
        'Asset List' => 'assetList',
        'Roles Administration' => 'rolesAdmin',        
    ],

];

