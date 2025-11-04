@php

    $listContainer = 'flex flex-col';
    $listArrow = 'flex flex-row gap-2 align-middle text-white';
    $listSmallInfo = 'pl-8 text-sm italic text-gray-400 w-8/12';
    $listLine = $horizontalLine;
    $next = Config('steps.svg.svg_next');

@endphp

<div>
    <div class="mb-3">
        The dashboard provides current states of all open incidences/cases that require attention. The states are ..
    </div>
    <div class="flex flex-col gap-2">
        <ul class="flex-1 space-y-1 text-left">
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total open cases</span>
            </li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total cases to be responded today</span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total cases created today</span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total Service Level Agreement Breached</span>
            <li>
        </ul>
        <ul class="flex-1 space-y-1 text-left">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total unresponded customer comments</span>
            </li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total scheduled site visits</span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total currently engineers/technicians enroute to sites</span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>Total currently engineers/technicians on sites</span>
            <li>
        </ul>        
    </div>
</div>
