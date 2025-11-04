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

    $delete = Config::get('steps.buttonClasses.btnDelete');

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
                    component: 'progressLogTimeline', 
                    arguments: {ticket:{{ $ticket }}}
                })">
                    Progress Log
                </button>
            @endif
            
            <button 
                class="{{ $tdActionLink }} ml-2"
                wire:click="$dispatch('openModal', { 
                component: 'ticketAuditLog', 
                arguments: {ticket:{{ $ticket }}}
            })">
                Changes Audit
            </button>

        </x-slot>
        <x-slot name="tabMore">
            @isset($tabMore)
                @if ($selectedTab)
                    @if ($selectedTab == 'SLA Tasks')
                        @include('livewire.sla-tasks-table')
                    @endif
                    @if ($selectedTab == 'Visit')
                        @include('livewire.ticket-visit')
                    @endif                    
                    @if ($selectedTab == 'Actions')
                        @if($canEdit)
                            @include('livewire.ticket-actions')
                        @else
                            @include('livewire.no-permission')
                        @endif
                    @endif
                    @if ($selectedTab == 'Update Details')
                        @if($canEdit)
                            @include('livewire.ticket-update')
                        @else
                            @include('livewire.no-permission')
                        @endif
                    @endif
                    @if ($selectedTab == 'Resolution')
                        @if($canEdit)
                            @include('livewire.ticket-resolution')
                        @else
                            @include('livewire.no-permission')
                        @endif
                    @endif
                    @if($selectedTab == "Delete $moniker")
                        @if($canEdit)
                        <div class="text-center mt-10">
                            <button 
                                type="button" 
                                class="{{ $delete }}"
                                wire:confirm="Are you sure you want to delete this ticket?"
                                wire:click="delete"
                            >
                                Delete {{ $moniker }}
                            </button>
                        </div>
                        @else
                            @include('livewire.no-permission')
                        @endif
                    @endif
                @endif
            @endisset
        </x-slot>
    </x-tab>
</div>
