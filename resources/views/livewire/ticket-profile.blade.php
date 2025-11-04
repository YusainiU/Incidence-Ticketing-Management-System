@php

    $moniker = Config::get('steps.ticket');

    $tabContents = [
        ['name' => 'SLA Tasks', 'active' => true],
        ['name' => 'Visit', 'active' => false],
        ['name' => 'Actions', 'active' => false],
        ['name' => 'Update Details', 'active' => false],
        ['name' => 'Resolution', 'active' => false],
        ['name' => "Delete $moniker", 'active' => false],
    ];

    $tabMore[$tabContents[0]['name']] = $tasks;
    $tabMore[$tabContents[1]['name']] = 'Actions';
    $tabMore[$tabContents[2]['name']] = 'Site Visit';
    $tabMore[$tabContents[3]['name']] = 'Update Details';
    $tabMore[$tabContents[4]['name']] = 'Resolution';

    if($canEdit){
        $tabMore[$tabContents[5]['name']] = 'Delete';
    }

    $selectedTab = $selectedTab ? $selectedTab : $tabContents[0]['name'];

    $fieldClass = 'flex flex-col pb-3';
    $reopened = 'block mt-3 p-6 text-dark text-center font-bold bg-yellow-200 border border-gray-200 rounded-lg shadow-sm';

    $labelClass = Config::get('steps.form.label');
    $valueClass = Config::get('steps.form.value');
    $buttonEditClass = Config::get('steps.buttonClasses.btnEdit');
    $buttonDeleteClass = Config::get('steps.buttonClasses.btnDelete');
    $btnGroupContainer = Config::get('steps.buttonGroup.groupContainer');
    $btnGroupFirst = Config::get('steps.buttonGroup.groupBtnFirst');
    $btnGroupLast = Config::get('steps.buttonGroup.groupBtnLast');
    $dl = Config::get('steps.descriptionList.dl');
    $dlSection = Config::get('steps.descriptionList.dlSection');
    $dt = Config::get('steps.descriptionList.dt');
    $dd = Config::get('steps.descriptionList.dd');
    $whiteBox = Config::get('steps.whiteBox');
    $info = Config::get('steps.alert.info');
    $link = Config::get('steps.link');
    $text = Config::get('steps.standardTextColor');
    

    $fieldMargin = "mt-2 mb-2";
    $valueMargin = "ml-2";
    $insetBox = "block mt-3 p-3 border border-zinc-700 rounded-md border-dashed";

    $isClosedStyle="";
    $ticketLabel = "{$moniker} Profile";
    if($ticketIsClosed){
        $isClosedStyle = "bg-red-300 p-3";
        $ticketLabel = "Closed {$moniker}";
    }

@endphp

<div>

    <x-page-profile>
        <x-slot name="title">
            <div class="{{ $isClosedStyle }}">
                <span class="block text-2xl">{{ $ticketLabel }}</span>
                <span class="block">
                    <a href="{{ route('customerProfile',['customer' => $ticket->customer]) }}" class="{{ $link }}" target="_blank">
                        {{ $ticket->customer->name }}
                    </a>
                </span>
            </div>
        </x-slot>
        <x-slot name="nav">
            <div class="w-full">
                @include('livewire.ticket-status')
            </div>
        </x-slot>
        <x-slot name="left_panel">
            <div class="flex flex-col text-left gap-3">
                <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" x-data="{}"
                    x-init="setTimeout(() => { $wire.checkResponseTime() }, 2000);">
                    {{ $ticketDuration }} Hours since {{ $moniker }} was created
                </div>

                <div class="">
                    <div class="{{ $valueClass }}">
                        <span class="font-bold">{{ $ticket->ticket_number }}</span>
                    </div>
                    <div class="{{ $valueClass }}">
                        Created: {{ $ticket->createdAtFormatted }}
                    </div>
                    <div class="{{ $fieldMargin }}" x-data="{ 'showSlap': false }">
                        <button class="{{ $link }}" @click="showSlap = !showSlap">
                            Expand to view the SLA ..
                        </button>
                        <div class="block mt-3 max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"
                            x-show="showSlap">
                            <ul class="max-w-md space-y-1 text-gray-500 list-none list-inside dark:text-gray-400">
                                <li>Description: {{ $ticket->slaApplication->short_description }}</li>
                                <li>SLA: {{ $ticket->slaApplication->getServiceLevelAgreement->name }}</li>
                                <li>Days Covered:
                                    {{ $ticket->slaApplication->getServiceLevelAgreement->getServiceDays }}
                                </li>
                                <li>Service Start:
                                    {{ $ticket->slaApplication->getServiceLevelAgreement->service_start_time['formatted'] }}
                                <li>
                                <li>Service End:
                                    {{ $ticket->slaApplication->getServiceLevelAgreement->service_end_time['formatted'] }}
                                <li>
                                <li>Public Holidays Covered?
                                    {{ $ticket->slaApplication->getServiceLevelAgreement->include_public_holiday }}
                                <li>
                                <li>Response Time:
                                    {{ $ticket->slaApplication->getServiceLevelAgreement->response_time['formatted'] }}
                                <li>
                                <li>Fixed Time:
                                    {{ $ticket->slaApplication->getServiceLevelAgreement->fixed_time['formatted'] }}
                                <li>
                            </ul>
                        </div>
                    </div>

                    @if ($ticket->raised_by_user)
                        @php
                            $rbu = $ticket->raisedByUser();
                        @endphp
                        <div class="{{ $fieldMargin }}">
                            <label class="{{ $labelClass }}">Raised By:</label> 
                            <span class="{{ $valueClass }} {{ $valueMargin }}">
                                {{ $ticket->raised_by_user }}
                            </span>
                        </div>
                        <div class="{{ $fieldMargin }}">
                            <label class="{{ $labelClass }}">Telephone:</label> 
                            <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $rbu->phone_number }}</span>
                        </div>
                        <div class="{{ $fieldMargin }}">
                            <label class="{{ $labelClass }}">Email:</label> 
                            <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $rbu->email }}</span>
                        </div>
                    @endif

                    @if ($ticket->raised_by_nonuser)
                        <div class="{{ $fieldMargin }}">
                            <label class="{{ $labelClass }}">Raised By:</label> 
                            <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $ticket->raised_by_nonuser }}</span>
                        </div>
                        <div class="{{ $fieldMargin }}">
                            <label class="{{ $labelClass }}">Telephone:</label> 
                            <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $ticket->contact_telephone }}</span>
                        </div>
                        <div class="{{ $fieldMargin }}">
                            <label class="{{ $labelClass }}">Email:</label> 
                            <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $ticket->contact_email }}</span>
                        </div>
                    @endif

                    <div class="{{ $fieldMargin }}">
                        <label class="{{ $labelClass }}">Customer Reference:</label> 
                        <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $ticket->customer_reference }}</span>
                    </div>

                    <div class="{{ $fieldMargin }}">
                        <label class="{{ $labelClass }}">Assigned To:</label> 
                        <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $ticket->assigned_to ? $ticket->assigned_to : null }}</span>
                    </div>

                    <div class="{{ $fieldMargin }}">
                        <label class="{{ $labelClass }}">Assignment Group:</label> 
                        <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $ticket->assigned_group }}</span>
                    </div>

                </div>

            </div>
        </x-slot>
        <x-slot name="right_panel">
            <div x-data="{ display: 'ticket_details' }">
                <div class="{{ $btnGroupContainer }} mb-3">
                    <button type="button" class="{{ $btnGroupFirst }}" @click="display='ticket_details'">
                        Show {{ $moniker }} Details
                    </button>
                    <button type="button" class="{{ $btnGroupLast }}" @click="display='asset'">
                        Show Assets Affected
                    </button>
                </div>
                <div x-show="display == 'asset'" class="flex flex-col gap-3">
                    <span class="{{ $labelClass }}">Affected Assets:</span>
                    <div class="{{ $insetBox }} flex flex-col">
                        @if ($assets)
                            @foreach ($assets as $asset)
                                <button 
                                    class="{{ $valueClass }} text-left"
                                    wire:click="$dispatch('openModal', { 
                                        component: 'ModalAsset', 
                                        arguments: {asset:{{ $asset }}}
                                    })"                                    
                                >
                                    <span class="block underline">{{ $asset->short_description }}</span>
                                    <span class="block text-xs">Asset Number: {{ $asset->asset_number }}</span>
                                    <span class="block text-xs">Location: {{ $asset->location }}</span>
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div x-show="display == 'ticket_details'" class="w-full">
                    <span class="{{ $labelClass }}">{{ $moniker }} Details:</span>
                    <div class="mt-3 {{ $insetBox }}">
                        @if($ticket->closed_datetime)
                        <dl class="{{ $dl }}">
                            <div class="{{ $dlSection }}">
                                <dt class="{{ $labelClass }}">
                                    Closed
                                </dt>
                                <dd class="">
                                    {{ date('d-m-Y H:i', $ticket->closed_datetime) }}
                                    @if($canEdit)
                                        <button type="button" class="{{ $buttonEditClass }} ml-2" wire:click='reopen'>REOPEN</button>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                        @endif
                        <dl class="{{ $dl }}">
                            <div class="{{ $dlSection }}">
                                <dt class="{{ $labelClass }}">Short Description</dt>
                                <dd class="">{{ $ticket->short_description }}</dd>
                            </div>
                        </dl>
                        <dl class="{{ $dl }}">
                            <div class="{{ $dlSection }}">
                                <dt class="{{ $labelClass }}">Full Description</dt>
                                <dd class="">{{ $ticket->description }}</dd>
                            </div>
                        </dl>
                        <dl class="{{ $dl }}">
                            <div class="{{ $dlSection }}">
                                <dt class="{{ $labelClass }}">Resolution</dt>
                                <dd class="">{{ $ticket->resolution }}</dd>
                            </div>
                        </dl>
                        <dl class="{{ $dl }}">
                            <div class="{{ $dlSection }}">
                                <dt class="{{ $labelClass }}">Resolution Details</dt>
                                <dd class="">{{ $ticket->resolution_details }}</dd>
                            </div>
                        </dl>
                    </div>
                    @if($ticket->closed_ticket_id)
                        <div class="mt-3 {{ $whiteBox }} {{ $text }} flex flex-col justify-items justify-items-center gap-3">                            
                            <a
                                href="{{ url(route('ticketProfile',['ticket' => $ticket->closed_ticket_id])) }}" 
                                class="{{ $buttonEditClass }} w-1/4"
                                target="_blank"
                            >
                                See closed {{ $moniker }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>
        <x-slot name="bottom_panel">
            <span class="block text-center {{ $info }}">{{ $selectedTab }}</span>
            @include('livewire.ticket-tabs')
        </x-slot>
    </x-page-profile>
    <div id="EndOfSection">&nbsp;</div>
</div>
