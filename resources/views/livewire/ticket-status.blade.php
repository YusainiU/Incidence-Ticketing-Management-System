@php
    $info = Config::get('steps.alert.info');
    $dark = Config::get('steps.alert.dark');
    $failed = Config::get('steps.alert.danger');
    $bulletGray = Config::get('steps.indicators.dark');
    $bulletBlue = Config::get('steps.indicators.blue');
    $bulletRed = Config::get('steps.indicators.red');
    $bulletDark = Config::get('steps.indicators.dark');
    $container = Config::get('steps.indicators.container');

    $svg_visit = Config::get('steps.svg.svg_visit');
    $svg_onsite = Config::get('steps.svg.svg_onsite');
    $svg_enroute = Config::get('steps.svg.svg_enroute');

    $stat = $ticketStatusInformation;
    $badgeDark = Config::get('steps.badges.blue');

    $whiteBox = 'block mt-3 p-3 border border-zinc-700 rounded-md border-dashed';

@endphp

<div class="w-full">
    @if ($stat)
        <div class="flex {{ $whiteBox }} w-full">
            @if ($stat['taskBreached'])
                <div class="{{ $container }}">
                    <span class="{{ $bulletRed }}"></span>
                    Breached: {{ $stat['taskBreached'] }} {{ $stat['breachType'] }}
                </div>
            @else
                <div class="{{ $container }}">
                    <span class="{{ $bulletBlue }}"></span>
                    Inside SLA
                </div>
            @endif
            @if ($stat['numberOfUrgetLogs'])
                <div class="{{ $container }}">
                    <span class="{{ $bulletBlue }}"></span>
                    Urgent attentions: {{ $stat['numberOfUrgetLogs'] }}
                </div>
            @endif
            @if ($stat['lastUrgentLogCreatedAt'])
                <div class="{{ $container }}">
                    <span class="{{ $bulletBlue }}"></span>
                    Last urgent log created: {{ $stat['lastUrgentLogCreatedAt'] }}
                </div>
            @endif
            @if ($stat['lastCustomerLogCreatedAt'])
                <div class="{{ $container }}">
                    <span class="{{ $bulletBlue }}"></span>
                    Last customer's log at: {{ $stat['lastCustomerLogCreatedAt'] }}
                </div>
            @endif
            @if ($stat['currentlyWorking'])
                <div class="{{ $container }}">
                    <span class="{{ $bulletBlue }}"></span>
                    Currently working
                </div>
            @endif
            @if ($stat['resolved'])
                <div class="{{ $container }}">
                    <span class="{{ $bulletBlue }}"></span>
                    Resolved at: {{ $stat['resolved'] }}
                </div>
            @endif
            @if ($stat['closed'])
                <div class="{{ $container }}">
                    <span class="{{ $bulletBlue }}"></span>
                    CLOSED
                </div>
            @endif
        </div>
        <div class="flex gap-4 {{ $whiteBox }} w-full">
            <div class="flex gap-3 {{ $badgeDark }}">
                Total Visits Scheduled: {{ $stat['totalVisits'] }}
            </div>
            <div class="flex gap-3 {{ $badgeDark }}">
                Total Visited: {{ $stat['totalVisited'] }}
            </div>
            <div class="flex gap-3 {{ $badgeDark }}">
                Currently Onsite: {{ $stat['currentlyOnsite'] }}
            </div>
            <div class="flex gap-3 {{ $badgeDark }}">
                Currently Enroute to Site: {{ $stat['currentlyEnroute'] }}
            </div>
        </div>
        <div class="flex gap-4 {{ $whiteBox }} w-full">
            <div class="flex gap-3 {{ $badgeDark }}">
                Respond By: {{ $stat['respondBy'] }}
            </div>
            <div class="flex gap-3 {{ $badgeDark }}">
                Fix By: {{ $stat['fixBy'] }}
            </div>
            <div class="flex gap-3 {{ $badgeDark }}">
                Responded At: {{ $stat['respondedAt'] }}
            </div>
            <div class="flex gap-3 {{ $badgeDark }}">
                Fixed At: {{ $stat['fixedAt'] }}
            </div>
        </div>
    @endif
</div>
