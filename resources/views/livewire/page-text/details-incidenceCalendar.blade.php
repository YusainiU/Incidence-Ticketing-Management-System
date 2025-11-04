@php

    $listContainer = 'flex flex-col';
    $listArrow = 'flex flex-row gap-2 align-middle text-white';
    $listSmallInfo = 'pl-8 text-sm italic text-gray-400 w-8/12';
    $listLine = $horizontalLine;
    $next = Config('steps.svg.svg_next');

@endphp

<div>
    <div class="mb-3">
        The ticket/case/incidence Calendar provide a monthly visual of the activities and status.
    </div>
    <div class="flex flex-col gap-2">
        <ul class="space-y-1 text-left">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Provide a calendar view of all status and activities of tickets/cases/incidences
                    for the selected month. 
                </span>
            </li>
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Clicking the item will take the user to the selected ticket/case/incidence
                </span>
            <li>
        </ul>
    </div>
</div>
