@php
    $activeTab = Config::get('steps.tabs.activeTab');
    $inactiveTab = Config::get('steps.tabs.inactiveTab');

    $tdClass = Config::get('steps.tableClasses.td');
    $thClass = Config::get('steps.tableClasses.th');
    $trThClass = Config::get('steps.tableClasses.colTr');
    $divTopClass = Config::get('steps.tableClasses.divTop');
    $divSeparator = Config::get('steps.tableClasses.divSeparator');

    $tdActionLink = Config::get('steps.buttonClasses.btnGrey');
    $tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');
    $btnProg = Config::get('steps.buttonGroup.groupBtnMiddle');
    $failed = Config::get('steps.alert.danger');

@endphp

<div>
    <x-tab>
        <x-slot name="tabContent">
            @foreach ($tabContents as $tab)
                @php
                    if ($tab['active']) {
                        $thisTabIsActive = $tab['name'];
                    }
                @endphp

                <li class="me-2">
                    <a href="#EndOfSection" class="{{ $tab['name'] == $selectedTab ? $activeTab : $inactiveTab }}"
                        wire:click="selectTab('{{ $tab['name'] }}')">
                        {{ $tab['name'] }}
                    </a>
                </li>
            @endforeach
            @if ($ticket->taskLogs->count())
                <button class="{{ $tdActionLink }}"
                    wire:click="$dispatch('openModal', { 
                    component: 'customer.CustomerProgressTimeline', 
                    arguments: {ticket:{{ $ticket }}}
                })">
                    Progress Log
                </button>
            @endif
        </x-slot>
        <x-slot name="tabMore">
            @isset($tabMore)
                @if ($selectedTab)
                    @if ($selectedTab == 'Comment')
                        @include('livewire.customer.customer-ticket-comment')
                    @endif
                @endif
            @endisset
        </x-slot>
    </x-tab>
</div>
