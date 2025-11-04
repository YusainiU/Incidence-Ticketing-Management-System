@php

    $moniker = Config::get('steps.ticket');

    $tabContents = [
        ['name' => 'Customer Contacts', 'active' => true],
        ['name' => 'Assets', 'active' => false],
        ['name' => 'Service Level Agreements', 'active' => false],
        ['name' => "Open {$moniker}s", 'active' => false],
    ];

    $tabMore[$tabContents[0]['name']] = $contactsWithRoles;
    $tabMore[$tabContents[1]['name']] = $assets;
    $tabMore[$tabContents[2]['name']] = $slas;
    $tabMore[$tabContents[3]['name']] = $tickets;

    $selectedTab = $selectedTab ? $selectedTab : $tabContents[0]['name'];

    $warn = Config::get('steps.alert.warning');
    $text = Config::get('steps.standardTextColor');
    $fieldClass = 'flex flex-col pb-3';
    $labelClass = Config::get('steps.form.label');
    $valueClass = Config::get('steps.form.value');
    $whiteBox = Config::get('steps.whiteBox');
    $link = Config::get('steps.link');
    $buttonEditClass =
        'text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800';
    $buttonDeleteClass =
        'text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800';

@endphp

<div>

    <x-page-profile>
        <x-slot name="title">
            {{ $customer->name }}
            @if(count($slaAssetWarning))
                <div class="block mt-3 {{ $warn }} text-lg">
                    {{ implode(" | ", $slaAssetWarning) }} 
                </div>
            @endif            
        </x-slot>
        <x-slot name="nav">
            @if ($canEdit)
                <button type="button" class="{{ $buttonEditClass }}"
                    wire:click="$dispatch('openModal', { 
                        component: 'EditCustomerDetails', 
                        arguments: {customer:{{ $customer }}}
                    })">
                    Edit
                </button>
            @endif
            @if ($customer->active && $canEdit)
                <button type="button" class="{{ $buttonDeleteClass }} ml-5" wire:click='deactivate()'>
                    Deactivate
                </button>
            @elseif($canEdit)
                <button type="button" class="{{ $buttonEditClass }} ml-5" wire:click='activate()'>
                    Activate
                </button>
            @endif
            @if($canEdit)
                <button type="button" class="{{ $buttonEditClass }} ml-5" wire:click='showModal(true)'>
                Open Folder
                </button>
            @endif
            @if ($canEdit)
                <button type="button" class="{{ $buttonEditClass }}"
                    wire:click="$dispatch('openModal', { 
                        component: 'CreateNewAsset', 
                        arguments: {customer:{{ $customer }}}
                    })">
                    Create a New Asset
                </button>
            @endif
            @if ($canEdit)
                <button type="button" class="{{ $buttonEditClass }}"
                    wire:click="$dispatch('openModal', { 
                        component: 'CreateSlaApplication', 
                        arguments: {customer:{{ $customer }}}
                    })">
                    Add Service Level Agreement
                </button>
            @endif
            @if ($canEdit)
                <a href="{{ route('createNewTicket', ['customer' => $customer]) }}" target="_blank"
                    class="{{ $buttonEditClass }}">
                    Create New {{ $moniker }}
                </a>
            @endif
            @if($canEdit)
                <button type="button" class="{{ $buttonEditClass }}"
                wire:click="exportOpenTickets"
            >
                Export {{ env('TICKET_MONIKER_PLURAL') }} (Excel)
                </button>
            @endif

            @if ($displayModal)
                <div class="z-50">
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <x-modal-onpage showSubmitButton='hide'>
                            <x-slot name="title">
                                File Manager
                            </x-slot>
                            <x-slot name="modalContent">
                                <x-livewire-filemanager />
                            </x-slot>
                        </x-modal-onpage>
                    </div>
                </div>
            @endif
        </x-slot>
        <x-slot name="left_panel">
            <div class="">
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Type:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->primary_type->toName($customer->primary_type->toString()) }}
                    </div>
                </div>
                @if ($customer->child_type)
                    <div class="{{ $fieldClass }}">
                        <div class="{{ $labelClass }}">Secondary Type:</div>
                        <div class="{{ $valueClass }}">
                            {{ $customer->child_type->toName($customer->child_type->toString()) }}
                        </div>
                    </div>
                @endif
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Url:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->url }}
                    </div>
                </div>
                @if ($customer->child_type)
                    <div class="{{ $fieldClass }}">
                        <div class="{{ $labelClass }}">Parent Company:</div>
                        <div class="{{ $valueClass }}">
                            {{ $customer->getParent($customer->parent_company)->name }}
                        </div>
                    </div>
                @endif
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Status:</div>
                    <div class="{{ $valueClass }}">
                        @if ($customer->active)
                            <span class="text-dark dark:{{ $text }} font-bold">Active</span>
                        @else
                            <span class="text-red-300 dark:text-red-700 font-bold">Not Active</span>
                        @endif
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Portal Enabled:</div>
                    <div class="{{ $valueClass }}">
                        @if ($customer->portal_enabled)
                            <span class="text-dark dark:{{ $text }} font-bold">Enabled</span>
                        @else
                            <span class="text-red-300 dark:text-red-700 font-bold">Disabled</span>
                        @endif
                    </div>
                </div>                
            </div>
        </x-slot>
        <x-slot name="right_panel">
            <div class="">
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Address 1:</div>
                    <div class="{{ $valueClass }}">
                        <a href="{{ $this->mapQuery }}" class="{{ $link }}" target="_blank">
                            {{ $customer->address_1 }}
                        </a>
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Address 2:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->address_2 }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Address 3:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->address_3 }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Telephone:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->telephone_1 }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Short Information:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->short_description }}
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="bottom_panel">
            @include('livewire.customer-tabs')
        </x-slot>
    </x-page-profile>

    <div class="h-7 mb-10" id="bottom"></div>

</div>
