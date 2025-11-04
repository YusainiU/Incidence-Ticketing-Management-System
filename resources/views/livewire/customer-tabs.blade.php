@php
    $activeTab = 'inline-block p-4 text-blue-600 bg-gray-100 rounded-t-lg active dark:bg-gray-800 dark:text-blue-500';
    $inactiveTab =
        'inline-block p-4 rounded-t-lg hover:text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 dark:hover:text-gray-300';

    $tdClass = Config::get('steps.tableClasses.td');
    $thClass = Config::get('steps.tableClasses.th');
    $trThClass = Config::get('steps.tableClasses.colTr');
    $divTopClass = Config::get('steps.tableClasses.divTop');
    $divSeparator = Config::get('steps.tableClasses.divSeparator');

    $tdActionLink = Config::get('steps.buttonClasses.btnGrey');
    $tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');

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
                    <a href="#bottom" class="{{ $tab['name'] == $selectedTab ? $activeTab : $inactiveTab }}"
                        wire:click="selectTab('{{ $tab['name'] }}')">
                        {{ $tab['name'] }}
                    </a>
                </li>
            @endforeach
        </x-slot>
        <x-slot name="tabMore">
            @isset($tabMore)
                @if ($selectedTab)
                    @if ($selectedTab == 'Service Level Agreements')
                        <livewire:sla-application-table :customer="$customer">
                    @endif                        
                    @if($selectedTab == 'Assets')
                        <livewire:asset-table :customer="$customer">  
                    @endif
                    @if($selectedTab == 'Customer Contacts')
                        <livewire:customer-contacts-table :customer="$customer">  
                    @endif
                    @if($selectedTab == "Open {$moniker}s")
                        <livewire:customer-ticket-table :customer="$customer">
                    @endif
                @endif
            @endisset
        </x-slot>
    </x-tab>
</div>
