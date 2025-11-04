@php

    $tabContents = [
        ['name' => 'Comment', 'active' => false],
    ];

    $tabMore[$tabContents[0]['name']] = 'Comment';

    $fieldClass = 'flex flex-col pb-3';
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

    $fieldMargin = "mt-2 mb-2";
    $valueMargin = "ml-2";
    $moniker = Config::get('steps.ticket');

    $insetBox = "block mt-3 p-3 border border-zinc-700 rounded-md border-dashed";

@endphp

<div>

    <x-page-profile>

        <x-slot name="title">
            <span class="block text-2xl">Ticket Profile</span>
            <span class="block">{{ $ticket->customer->name }} </span>
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

                <div class="{{ $insetBox }}">

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
                            <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $ticket->raised_by_user }}</span>
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
                        <span class="{{ $valueClass }} {{ $valueMargin }}">{{ $ticket->assigned_to }}</span>
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
                    <div class="{{ $insetBox }} flex flex-col gap-2">
                        @if ($assets)
                            @foreach ($assets as $asset)
                                <button class="{{ $valueClass }} text-left">
                                    <span class="block underline">{{ $asset->short_description }}</span>
                                    <span class="block text-xs">Asset Number: {{ $asset->asset_number }}</span>
                                    <span class="block text-xs">Location: {{ $asset->location }}</span>
                                </button>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div x-show="display == 'ticket_details'" class="w-full">
                    <span class="{{ $labelClass }}">Ticket Details:</span>
                    <div class="mt-3 {{ $insetBox }}">
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
                </div>
            </div>
        </x-slot>

        <x-slot name="bottom_panel">
            <span class="block text-center {{ $info }}">{{ $selectedTab }}</span>
            @include('livewire.customer.customer-ticket-tabs')
        </x-slot>
        
    </x-page-profile>

</div>
