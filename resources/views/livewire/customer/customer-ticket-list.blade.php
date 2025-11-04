@php

    $tabul = Config::get('steps.fullWidthTab.tabUl');
    $tabli = Config::get('steps.fullWidthTab.tabLi');
    $tabActive = Config::get('steps.fullWidthTab.tabHrefActive');
    $tabInactive = Config::get('steps.fullWidthTab.tabHrefInActive');

    $th = Config::get('steps.tableClasses.th');
    $td = Config::get('steps.tableClasses.td');
    $thAlign = Config::get('steps.tableClasses.colTr');
    $marginTop = Config::get('steps.tableClasses.divTop');

    $info = Config::get('steps.alert.info');
    $alert = Config::get('steps.alert.warning');
    $select = Config::get('steps.form.select');
    $btnGrey = Config::get('steps.buttonClasses.btnGrey');
    $link = Config::get('steps.link');
    $tooltip = Config::get('steps.tooltip');

    $svg_bell_red = Config::get('steps.svg.svg_bell_red');
    $svg_flag_yellow = Config::get('steps.svg.svg_flag_yellow');
    $svg_flag_blue = Config::get('steps.svg.svg_flag_blue');
    $svg_enroute = Config::get('steps.svg.svg_enroute');
    $svg_onsite = Config::get('steps.svg.svg_onsite');

    $badgeBlue = Config::get('steps.badges.blue');
    $badgeRed = Config::get('steps.badges.red');
    $badgeYellow = Config::get('steps.badges.yellow');
    $badgeGreen = Config::get('steps.badges.green');

    $resolved = Config::get('steps.alert.resolved');
    $text = Config::get('steps.standardTextColor');
    $moniker = Config::get('steps.ticket');

@endphp

<div class="{{ $marginTop }}">

    <div class="m-3 text-center text-dark dark:{{ $text }}" wire:poll.15s>
        {{ date('H:i:s', time()) }}
    </div>

    <ul class="{{ $tabul }}">
        <li class="{{ $tabli }}">
            <button type="button" class="{{ $selectTicket == 'open' ? $tabActive : $tabInactive }}"
                wire:click="changeTicketSelection('open')">
                Open {{ $moniker }}
            </button>
        </li>
        <li class="{{ $tabli }} }}">
            <button type="button" class="{{ $selectTicket == 'resolved' ? $tabActive : $tabInactive }}"
                wire:click="changeTicketSelection('resolved')">
                Resolved Open {{ $moniker }}s
            </button>
        </li>
        <li class="{{ $tabli }}">
            <button type="button" class="{{ $selectTicket == 'closed' ? $tabActive : $tabInactive }}"
                wire:click="changeTicketSelection('closed')">
                Closed {{ $moniker }}s
            </button>
        </li>
        <li class="{{ $tabli }}">
            <button type="button" class="{{ $selectTicket == 'myticket' ? $tabActive : $tabInactive }}"
                wire:click="changeTicketSelection('myticket')">
                All
            </button>
        </li>
    </ul>
    <div>

        <div>
            <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
                <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
            </div>
        </div>

        {{ $tickets->links() }}

        <x-table>
            <x-slot name="tableColumns">
                <tr class="{{ $thAlign }}">
                    <th class="{{ $th }}">
                        {{ $moniker }} #
                    </th>
                    <th class="{{ $th }}">
                        Created At
                    </th>
                    <th class="{{ $th }}">
                        Site
                    </th>
                    <th class="{{ $th }}">
                        Summary
                    </th>
                    <th class="{{ $th }}">
                        Assigned To
                    </th>
                    <th class="{{ $th }}">
                        Status  
                    </th>
                </tr>
            </x-slot>
            <x-slot name="tableRows">
                @if ($tickets)
                    @foreach ($tickets as $ticket)
                        <tr class="{{ $thAlign }}">
                            <td class="{{ $td }} align-top">
                                <a href="{{ route('customerTicketProfile', ['ticket' => $ticket]) }}" target="_blank"
                                    class="{{ $link }}">
                                    {{ $ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ date('d-m-Y H:i', strtotime($ticket->created_at)) }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ Str::of($ticket->customer->name)->limit(20) }}
                            </td>
                            <td class="{{ $td }} align-top">
                                {{ Str::of($ticket->short_description)->limit(30) }}
                                <button class="{{ $link }}"
                                    x-on:click="$wire.showDescription({{ $ticket }})">[more]</button>
                            </td>
                            <td class="{{ $td }} align-top">

                                @if ($ticket->assigned_to)
                                    {{ $ticket->assigned_to }}
                                @else
                                    <span class="{{ $badgeYellow }}">No Assignment</span>
                                @endif
                                
                            </td>
                            <td class="{{ $td }} align-top">
                                <div class="flex flex-col flex-wrap">
                                    @if ($ticketInfos && $ticketInfos[$ticket->id])
                                        @if ($ticketInfos[$ticket->id]['taskBreached'])
                                            <div x-data="{ tooltipbreach{{ $ticket->id }}: false }" class="flex-1">
                                                <div x-on:mouseover="tooltipbreach{{ $ticket->id }} = true"
                                                    x-on:mouseleave="tooltipbreach{{ $ticket->id }} = false"
                                                    class="{{ $badgeRed }}">
                                                    SLA Breach
                                                    <div x-show="tooltipbreach{{ $ticket->id }}"
                                                        class="{{ $tooltip }}">
                                                        SLA Breach
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($ticketInfos[$ticket->id]['numberOfUrgetLogs'])
                                            <div x-data="{ tooltipurgent{{ $ticket->id }}: false }" class="flex-1">
                                                <div x-on:mouseover="tooltipurgent{{ $ticket->id }} = true"
                                                    x-on:mouseleave="tooltipurgent{{ $ticket->id }} = false"
                                                    class="{{ $badgeYellow }}">
                                                    Urgent Attention

                                                    <div x-show="tooltipurgent{{ $ticket->id }}"
                                                        class="{{ $tooltip }}">
                                                        Urgent Attention
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($ticketInfos[$ticket->id]['lastUrgentLogCreatedAt'])
                                            <div x-data="{ tooltipcustomer{{ $ticket->id }}: false }" class="flex-1">
                                                <div x-on:mouseover="tooltipcustomer{{ $ticket->id }} = true"
                                                    x-on:mouseleave="tooltipcustomer{{ $ticket->id }} = false"
                                                    class="{{ $badgeGreen }}">

                                                    Urgent Note
                                                    <div x-show="tooltipcustomer{{ $ticket->id }}"
                                                        class="{{ $tooltip }}">
                                                        Customer Comment -
                                                        {{ $ticketInfos[$ticket->id]['lastUrgentLogCreatedAt'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($ticketInfos[$ticket->id]['visitScheduled'])
                                            <div x-data="{ tooltipcustomer{{ $ticket->id }}: false }" class="flex-1">
                                                <div x-on:mouseover="tooltipcustomer{{ $ticket->id }} = true"
                                                    x-on:mouseleave="tooltipcustomer{{ $ticket->id }} = false"
                                                    class="{{ $badgeBlue }}">
                                                    Visit Scheduled
                                                    <div x-show="tooltipcustomer{{ $ticket->id }}"
                                                        class="{{ $tooltip }}">
                                                        Visit Scheduled
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($ticketInfos[$ticket->id]['currentlyEnroute'])
                                            <div x-data="{ tooltipcustomer{{ $ticket->id }}: false }" class="flex-1">
                                                <div x-on:mouseover="tooltipcustomer{{ $ticket->id }} = true"
                                                    x-on:mouseleave="tooltipcustomer{{ $ticket->id }} = false"
                                                    class="{{ $badgeBlue }}">
                                                    Currently Enroute
                                                    <div x-show="tooltipcustomer{{ $ticket->id }}"
                                                        class="{{ $tooltip }}">
                                                        Currently Enroute
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($ticketInfos[$ticket->id]['currentlyOnsite'])
                                            <div x-data="{ tooltipcustomer{{ $ticket->id }}: false }" class="flex-1">
                                                <div x-on:mouseover="tooltipcustomer{{ $ticket->id }} = true"
                                                    x-on:mouseleave="tooltipcustomer{{ $ticket->id }} = false"
                                                    class="{{ $badgeBlue }}">
                                                    Currently Onsite
                                                    <div x-show="tooltipcustomer{{ $ticket->id }}"
                                                        class="{{ $tooltip }}">
                                                        Currently Onsite
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($ticket->currently_working)
                                            <div x-data="{ tooltipcustomer{{ $ticket->id }}: false }" class="flex-1">
                                                <div x-on:mouseover="tooltipcustomer{{ $ticket->id }} = true"
                                                    x-on:mouseleave="tooltipcustomer{{ $ticket->id }} = false"
                                                    class="{{ $badgeBlue }}">
                                                    Currently Working
                                                    <div x-show="tooltipcustomer{{ $ticket->id }}"
                                                        class="{{ $tooltip }}">
                                                        Currently Working
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if ($ticket->resolved_datetime)
                                        <div x-data="{ tooltipbreach{{ $ticket->id }}: false }" class="flex-1">
                                            <div x-on:mouseover="tooltipbreach{{ $ticket->id }} = true"
                                                x-on:mouseleave="tooltipbreach{{ $ticket->id }} = false"
                                                class="{{ $badgeGreen }}">
                                                Resolved
                                                <div x-show="tooltipbreach{{ $ticket->id }}"
                                                    class="{{ $tooltip }}">
                                                    Resolved
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        @if ($moreOnThis && $moreOnThis->id == $ticket->id)
                            <tr class="{{ $thAlign }}" wire:show="showFilter">
                                <td class="{{ $td }}" colspan="6">
                                    <div class="{{ $info }}">
                                        <span class="block">
                                            Description: {{ $moreOnThis->description }}
                                        </span>
                                        <span class="block">
                                            Raised By:
                                            {{ $ticket->raised_by_user ? $ticket->raised_by_user : $ticket->raised_by_nonuser }}
                                        </span>
                                        <span class="block">
                                            Respond By:
                                            {{ $slaTask->respond_by ? date('d-m-Y H:i', strtotime($slaTask->respond_by)) : 'Not Available' }}
                                        </span>
                                        <span class="block">
                                            Fix By:
                                            {{ $slaTask->fix_by ? date('d-m-Y H:i', strtotime($slaTask->fix_by)) : 'Not Available' }}
                                        </span>
                                        <span class="block">
                                            Remote response at:
                                            {{ $slaTask->responded_at ? date('d-m-Y H:i', strtotime($slaTask->responded_at)) : 'Not Available' }}
                                        </span>
                                        <span class="block">
                                            Fixed at:
                                            {{ $slaTask->fixed_at ? date('d-m-Y H:i', strtotime($slaTask->fixed_at)) : 'Not Available' }}
                                        </span>
                                        <button class="{{ $btnGrey }} mt-3"
                                            wire:click="$dispatch('openModal', { 
                                                component: 'Customer.CustomerProgressTimeline', 
                                                arguments: {ticket:{{ $ticket }}}
                                            })">
                                            Open Progress Logs
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </x-slot>

        </x-table>

    </div>

</div>
