@php

    $listContainer = 'flex flex-col';
    $listArrow = 'flex flex-row gap-2 align-middle text-white';
    $listSmallInfo = 'pl-8 text-sm italic text-gray-400 w-8/12';
    $listLine = $horizontalLine;
    $next = Config('steps.svg.svg_next');

@endphp

<div>
    <div class="mb-3">
        Ticket/Case/Incidence profile provides information on the issues raised
        for it to be progressed to completion.
    </div>
    <div class="flex flex-col md:flex-row md:gap-4">
        <ul class="space-y-1 text-left flex-1 flex-grow">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Provide the current status, action and progress of the case
                </span>
            </li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Provide the current SLA status and alert user if it has been breached.
                </span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Alert user of any urgent notification for internal user and customer
                </span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Details of the ticket/case/incidence are provided here, which include, amongst others,
                    site contact details, full description, assets related to the issue raised etc.,
                </span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    The Visit Tab provides the ability to schedule site visit. It also
                    list the current scheduled visits. User can manage all visits from here.
                </span>
            <li>
        </ul>
        <ul class="space-y-1 text-left flex-1 flex-grow">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    The SLA Task Tab provides the currently applied SLA 
                </span>
            </li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Action Tab will allow user to progress the ticket/case/incidence, in terms of
                    task assignment, managing remote response, fix and closure times. Adding progress
                    note and the ability to email that note to other users and customers. 
                </span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>All user activities in the action tab are logged and recorded in the progress logs</span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    The update tab provides user the ability to change editable details
                </span>
            <li>                                
        </ul>
        <ul class="space-y-1 text-left flex-1 flex-grow">
            <li class="flex flex-row items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    If the issue has been resolved, the details can be input in the
                    resolution tab. The date and time, resolved by, resolution type and
                    resolution note are the required fields. 
                </span>
            </li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>View of the progress logs</span>
            <li>
            <li class="flex items-middle space-x-3 rtl:space-x-reverse">
                <span>{!! $next !!}</span>
                <span>
                    Changes Audit provide the history of the changes made to the ticket/case/incident.
                </span>
            <li>
        </ul>                  
    </div>
</div>
