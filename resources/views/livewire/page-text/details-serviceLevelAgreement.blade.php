@php

    $listContainer = 'flex flex-col';
    $listArrow = 'flex flex-row gap-2 align-middle text-white';
    $listSmallInfo = 'pl-8 text-sm italic text-gray-400 w-8/12';
    $listLine = $horizontalLine;
    $next = Config('steps.svg.svg_next');

@endphp

<div>
    <div class="mb-3">
        Service Level Agreement provide user the ability to define a service contract template
        that can later be applied to individual sites. 
    </div>
    <div class="flex flex-col gap-2">
        <ul class="space-y-1 text-left">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    An ability to create a new SLA based on user roles permission 
                </span>
            </li>
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Ability to search the paginated list.
                </span>
            <li>
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Ability to update the SLA based on user roles permission
                </span>
            <li>                
        </ul>
    </div>
</div>
