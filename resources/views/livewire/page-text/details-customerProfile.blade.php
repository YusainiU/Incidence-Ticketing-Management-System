@php

    $listContainer = 'flex flex-col';
    $listArrow = 'flex flex-row gap-2 align-middle text-white';
    $listSmallInfo = 'pl-8 text-sm italic text-gray-400 w-8/12';
    $listLine = $horizontalLine;
    $next = Config('steps.svg.svg_next');

@endphp

<div>
    <div class="mb-3">
        Customer profile provides information of a site, and actions that
        can be executed against it .. 
    </div>
    <div class="flex flex-col md:flex-row md:gap-4">
        <ul class="space-y-1 text-left">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Ability to edit the site details if user has the permission</span>
            </li>
            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Ability to deactive the site if user has the permission</span>
            <li>
            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Link the site to a document folder</span>
            <li>
            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Ability to create assets if user has the permission</span>
            <li>
        </ul>
        <ul class="space-y-1 text-left">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Ability to create Service Level Agreement for the site is user has the permission</span>
            </li>
            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Ability to create a new case if user has the permission</span>
            <li>
            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total currently engineers/technicians enroute to sites</span>
            <li>
            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>View the list of site contacts</span>
            <li>                
        </ul>
        <ul class="space-y-1 text-left">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>View the list of site assets</span>
            </li>
            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>View the list of site Service Level Agreement</span>
            <li>
            <li class="flex items-center space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>View the list of site current open cases/incidences</span>
            <li>
        </ul>                  
    </div>
</div>
