@php

    $listContainer = 'flex flex-col';
    $listArrow = 'flex flex-row gap-2 align-middle text-white';
    $listSmallInfo = 'pl-8 text-sm italic text-gray-400 w-8/12';
    $listLine = $horizontalLine;
    $next = Config('steps.svg.svg_next');

@endphp

<div>
    <div class="mb-3">
        The customer list view provide a paginated table of all customer sites ..
    </div>
    <div class="flex flex-col gap-2">
        <ul class="space-y-1 text-left">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    An ability to create a new one based on user roles's permission 
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
                    A link to open the selected customer site profile
                </span>
            <li>                
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Provide an information on the type, description, reference
                    to the parent company if specified, and the active or not-active status.
                </span>
            <li>
        </ul>
    </div>
</div>
