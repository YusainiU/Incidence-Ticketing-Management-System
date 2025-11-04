@php

    $rootDiv = 'mx-auto max-w-(--breakpoint-2xl) p-4 md:p-6';
    $gridDiv = 'grid grid-cols-12 gap-4 md:gap-6';
    $svg_ellipsis = Config::get('steps.svg.svg_ellipsis');
    $useGroup5 = true;


@endphp

<div>

    <div name="rootDiv" class="{{ $rootDiv }}">
        @if($permissionAlert)
            <span>No Permission</span>
        @endif
        <div name="gridDiv" class="{{ $gridDiv }}">

            @if($useGroup5)
                <livewire:MainDashboardOpenTicketWidget />
                <livewire:MainDashboardToRespondTodayWidget />
                <livewire:MainDashboardTicketCreatedTodayWidget />
                <livewire:MainDashboardTicketBreachedWidget />
                <livewire:MainDashboardUnrespondedComment />
                <livewire:MainDashboardOutstandingVisitWidget />
                <livewire:MainDashboardEnrouteVisitWidget />
                <livewire:MainDashboardOnsiteWidget />                   
            @endif

        </div>
    </div>

</div>
