@php

    $listContainer = 'flex flex-col';
    $listArrow = 'flex flex-row gap-2 align-middle text-white';
    $listSmallInfo = 'pl-8 text-sm italic text-gray-400 w-8/12';
    $listLine = $horizontalLine;
    $next = Config('steps.svg.svg_next');

@endphp

<div>
    <div class="mb-3">
        Provide the paginated view of the list of all tickets/cases/incidences created ..
    </div>
    <div class="flex flex-col gap-2">
        <ul class="space-y-1 text-left">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    View all created tickets/cases/incidences in the system. 
                </span>
            </li>
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Tabs that groups the tickets/cases/incidences based on their status.
                </span>
            <li>
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Provide the summary of current actions, status and progresses of each ticket
                </span>
            <li>                
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Ability to change ticket/case/incidence assignment
                </span>
            <li>
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    User can access progress log for each ticket/case/incidence
                </span>
            <li>
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    A link to open a selected ticket/case/incidence profile
                </span>
            <li>                                
        </ul>
    </div>
</div>
