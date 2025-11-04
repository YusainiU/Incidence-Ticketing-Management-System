@php

$text = Config::get('steps.standardTextColor');
$link = Config::get('steps.link');
$tooltip = Config::get('steps.tooltip');
$prev = Config::get('steps.svg.svg_previous');
$next = Config::get('steps.svg.svg_next');

$table = Config::get('steps.tableClasses.table');
$theader = Config::get('steps.tableClasses.thead');
$tbody = Config::get('steps.tableClasses.tbody');
$th = Config::get('steps.tableClasses.th');
$td = Config::get('steps.tableClasses.td');

$td = str_replace(['border-t','border-gray-100'],['border','border-gray-600'], $td);
$th = "$th w-32 h-24 text-center";
$td = "$td w-32 h-24 align-top";

$eventBox = 'text-xs flex flex-col gap-1';

$cellCounter = 0;
$rowCounter = 0;

$today = date('d');
$todayYear = date('Y');
$todayMonth = date('m');

@endphp

<div>
    <div class="p-10">
        <div class="{{ $text }} flex flex-row w-full mb-5">
            <div class="flex flex-row w-full gap-5">
                <a href="#" class="{{ $link }} flex flex-row align-middle" wire:click='previousMonth()'>
                    {!! $prev !!} 
                    <span>previous</span>
                </a> 
            </div>
            <div class="{{ $text }} w-full text-2xl grid grid-flow-col justify-items-center">
                <div class="pt-1">{!! $prev !!}</div> 
                <span>
                <a href="#" class="{{ $link }}" wire:click='currentMonth'>
                {{ $monthDetails['nameOfTheMonth'] }} 
                {{ $monthDetails['paddedMonthNumber'] }} 
                {{ $selectedYear }}
                </a>
                </span>
                <div class="pt-1">{!! $next !!}</div>
            </div>
            <div class="flex flex-row-reverse w-full gap-5">
                <a href="#" class="{{ $link }} flex flex-row align-middle" wire:click='nextMonth()'>
                    Next
                    {!! $next !!}
                </a>
            </div>
        </div>
        <table class="{{ $table }}">
            <theader class="{{ $theader }}">
                <tr class="">
                    @foreach($daysOftheWeek as $dayNumber => $dayName)                    
                        <th class="{{ $th }}">{{ $dayName }}</th>
                    @endforeach
                </tr>
            </theader>
            <tbody class="{{ $tbody }}">
                @while($rowCounter < $totalRows)
                    @php $rowCounter++ @endphp
                    <tr>
                        @foreach($daysOftheWeek as $dayNumber => $dayName)
                            @php

                                $cellCounter++;
                                $date = null;
                                $dateNum = null;
                                $event_respondBy = null;
                                $event_respondByBreach = null;
                                $event_fixBy = null;
                                $event_visit = null;
                                $event_enroute = null;
                                $event_onsite = null;
                                $onsite = [];
                                $offsite = [];

                                if(in_array($cellCounter, array_keys($events))) {

                                    $evt = $events[$cellCounter];
                                    $date = $evt['Date'];
                                    $dn = explode("-",$date);
                                    $dateNum = $dn[0];

                                    if($evt['RespondBy']){
                                        $event_respondBy = $evt['RespondBy'];
                                    }
                                    
                                    if($evt['RespondByBreach']) {
                                        $event_respondByBreach = $evt['RespondByBreach'];
                                    }

                                    if($evt['FixBy']) {
                                        $event_fixBy = $evt['FixBy'];
                                    }
                                    
                                    if($evt['Visit']) {
                                        $event_visit = $evt['Visit'];
                                    }

                                    if($evt['Enroute']) {
                                        $event_enroute = $evt['Enroute'];
                                    }

                                    if($evt['Onsite']) {
                                        $event_onsite = $evt['Onsite'];
                                        foreach($event_onsite as $ons){ 
                                            $onsite[] = $ons->ticket->ticket_number;
                                        }
                                    }
                                    
                                    if($evt['Offsite']){
                                        foreach($evt['Offsite'] as $ofs ){
                                            $offsite[] = $ofs->ticket->ticket_number;
                                        }
                                    }
                                    
                                }

                                $todayColor = null;
                                if(
                                    intval($today) == intval($dateNum) && 
                                    intval($todayYear) == intval($selectedYear) &&
                                    intval($todayMonth) == intval($selectedMonth)
                                )
                                {
                                    $todayColor = 'bg-zinc-200';
                                }
                                
                            @endphp               
                            <td class="{{ $td }} {{ $todayColor }}">
                                <div class="flex flex-row-reverse font-extrabold"><span>{{ $dateNum }}</span></div>
                                <div class="flex flex-col {{ $text }}">
                                    @if($event_respondBy)
                                        <div class="{{ $eventBox }}">
                                            <div class=""></div>
                                            @foreach($event_respondBy as $respondby_item)
                                                <div class=" bg-orange-200 p-1 mt-2" x-data="{ tp_respby: false }">
                                                    <a 
                                                        href="{{ route('ticketProfile',['ticket' => $respondby_item->ticket]) }}" 
                                                        class="text-gray-900 font-bold" 
                                                        target="_blank"
                                                        x-on:mouseover="tp_respby = true"
                                                        x-on:mouseleave="tp_respby = false"                                                        
                                                    > 
                                                       Respond By: {{ $respondby_item->ticket->ticket_number  }}
                                                    </a>
                                                    <div 
                                                        x-show="tp_respby"
                                                        class="{{ $tooltip }}"
                                                    >
                                                            {{ $respondby_item->ticket->customer->name }}
                                                    </div>                                                    
                                                </div>
                                            @endforeach
                                        </div>                                    
                                    @endif
                                    @if($event_fixBy)
                                        <div class="{{ $eventBox }} mt-2">
                                            <div class=""></div>
                                            @foreach($event_fixBy as $fixBy_item)
                                                <div class="bg-orange-200 p-1 mt-2" x-data="{ tp_fixby: false }">
                                                    <a 
                                                        href="{{ route('ticketProfile',['ticket' => $fixBy_item->ticket]) }}" 
                                                        class="text-gray-900 font-bold" 
                                                        target="_blank"
                                                        x-on:mouseover="tp_fixby = true"
                                                        x-on:mouseleave="tp_fixby = false"                                                             
                                                    > 
                                                        Fix By: {{ $fixBy_item->ticket->ticket_number  }}
                                                    </a>
                                                    <div 
                                                        x-show="tp_fixby"
                                                        class="{{ $tooltip }}"
                                                    >
                                                            {{ $fixBy_item->ticket->customer->name }}
                                                    </div>                                                       
                                                </div>
                                            @endforeach
                                        </div>                                    
                                    @endif                                    
                                    @if($event_respondByBreach)
                                        <div class="{{ $eventBox }} mt-2">
                                            <div class=""></div>
                                            @foreach($event_respondByBreach as $respondbyBreach_item)
                                                <div class="bg-red-800 p-1 mt-2"  x-data="{ tp_respbreach: false }">
                                                    <a 
                                                        href="{{ route('ticketProfile',['ticket' => $respondbyBreach_item->ticket]) }}" 
                                                        class="text-gray-200 font-bold" 
                                                        target="_blank"
                                                        x-on:mouseover="tp_respbreach = true"
                                                        x-on:mouseleave="tp_respbreach = false"                                                          
                                                    > 
                                                        Breach: {{ $respondbyBreach_item->ticket->ticket_number  }}
                                                    </a>
                                                    <div 
                                                        x-show="tp_respbreach"
                                                        class="{{ $tooltip }}"
                                                    >
                                                            {{ $respondbyBreach_item->ticket->customer->name }}
                                                    </div>                                                      
                                                </div>
                                            @endforeach
                                        </div>                                    
                                    @endif
                                    @if($event_visit)
                                        <div class="{{ $eventBox }} mt-2">
                                            <div class=""></div>
                                            @foreach($event_visit as $visit_item)
                                                @php
                                                    $strike = null;
                                                    $visited = null;
                                                    if(in_array($visit_item->ticket->ticket_number, $offsite)){
                                                            $strike = 'line-through';
                                                            $visited = "Visited: ";
                                                    }
                                                @endphp
                                                <div class="bg-blue-500 p-1 mt-2"  x-data="{ tp_visit: false }">
                                                    <a 
                                                        href="{{ route('ticketProfile',['ticket' => $visit_item->ticket]) }}" 
                                                        class="text-zinc-100 font-bold {{ $strike }}" 
                                                        target="_blank"
                                                        x-on:mouseover="tp_visit = true"
                                                        x-on:mouseleave="tp_visit = false"                                                          
                                                    > 
                                                        Visit Scheduled: {{ $visit_item->ticket->ticket_number  }}
                                                    </a>
                                                    <div 
                                                        x-show="tp_visit"
                                                        class="{{ $tooltip }}"
                                                    >
                                                            {{ $visited }}{{ $visit_item->ticket->customer->name }}
                                                    </div>                                                      
                                                </div>
                                            @endforeach
                                        </div>                                    
                                    @endif
                                    @if($event_enroute)
                                        <div class="{{ $eventBox }} mt-2">
                                            <div class=""></div>
                                            @foreach($event_enroute as $enroute_item)
                                                <div class="bg-emerald-800 p-1 mt-2"  x-data="{ tp_enroute: false }">
                                                    @php
                                                        $strike = null;
                                                        $visited = null;
                                                        if(in_array($enroute_item->ticket->ticket_number, $onsite)){
                                                            $strike = 'line-through';
                                                            $visited = "Visited: ";
                                                        } 
                                                    @endphp
                                                    <a 
                                                        href="{{ route('ticketProfile',['ticket' => $enroute_item->ticket]) }}" 
                                                        class="text-gray-200 font-bold {{ $strike }}" 
                                                        target="_blank"
                                                        x-on:mouseover="tp_enroute = true"
                                                        x-on:mouseleave="tp_enroute = false"                                                          
                                                    >                                                        
                                                        Enroute To: {{ $visit_item->ticket->ticket_number  }}                                                        
                                                    </a>
                                                    <div 
                                                        x-show="tp_enroute"
                                                        class="{{ $tooltip }}"
                                                    >
                                                            {{ $visited }}{{ $enroute_item->ticket->customer->name }}
                                                    </div>                                                      
                                                </div>
                                            @endforeach
                                        </div>                                    
                                    @endif
                                    @if($event_onsite)
                                        <div class="{{ $eventBox }} mt-2">
                                            <div class=""></div>
                                            @foreach($event_onsite as $onsite_item)
                                                @php
                                                    $strike = null;
                                                    $visited = null;
                                                    if(in_array($onsite_item->ticket->ticket_number, $offsite)){
                                                            $strike = 'line-through';
                                                            $visited = "Offsite: ";
                                                    }
                                                @endphp                                            
                                                <div class="bg-stone-800 p-1 mt-2"  x-data="{ tp_onsite: false }">
                                                    <a 
                                                        href="{{ route('ticketProfile',['ticket' => $onsite_item->ticket]) }}" 
                                                        class="text-gray-200 font-bold {{ $strike }}" 
                                                        target="_blank"
                                                        x-on:mouseover="tp_onsite = true"
                                                        x-on:mouseleave="tp_onsite = false"                                                          
                                                    > 
                                                        Onsite: {{ $onsite_item->ticket->ticket_number  }}
                                                    </a>
                                                    <div 
                                                        x-show="tp_onsite"
                                                        class="{{ $tooltip }}"
                                                    >
                                                           {{ $visited }} {{ $onsite_item->ticket->customer->name }}
                                                    </div>                                                      
                                                </div>
                                            @endforeach
                                        </div>                                    
                                    @endif                                                                                                                 
                                </div>
                            </td>
                        @endforeach                    
                    </tr>
                @endwhile
            </tbody>
        </table>
    </div>
</div>
