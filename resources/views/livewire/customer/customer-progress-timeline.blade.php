@php
    $info = Config::get('steps.alert.info');
    $danger = Config::get('steps.alert.danger');
    $olHeader = Config::get('steps.timeline.ol-header');
    $liItem = Config::get('steps.timeline.li-item');
    $liSvg = Config::get('steps.timeline.li-svg');
    $liSvgSpan = Config::get('steps.timeline.li-svg-span');
    $liSvgPathd = Config::get('steps.timeline.li-svg-path-d');
    $liH3Header = Config::get('steps.timeline.li-h3-header');
    $liHeaderSpanInfo = Config::get('steps.timeline.li-header-span-info');
    $liHeaderSpanUrgent = Config::get('steps.timeline.li-header-span-urgent');
    $liDatetime = Config::get('steps.timeline.li-datetime');
    $liPContent = Config::get('steps.timeline.li-p-content');
    $liHref = Config::get('steps.timeline.li-ahref');
    $divTopClass = Config::get('steps.tableClasses.divTop');
    $divTopClass .= " bg-white dark:bg-gray-700 p-4";

    $typeVisit = Config::get('steps.logs.type.site_visit');
    $typeOnsite = Config::get('steps.logs.type.site_visit_onsite');
    $typeEnroute = Config::get('steps.logs.type.site_visit_enroute');
    $typeOffsite = Config::get('steps.logs.type.site_visit_offsite');

    $textArea = Config::get('steps.form.textarea');

    $external = Config::get('steps.logs.source.external');
    $internal = Config::get('steps.logs.source.internal');

    $buttonBlue = Config::get('steps.buttonClasses.btnBlue');
    $buttonGrey = Config::get('steps.buttonClasses.btnGrey');

    $header = Config::get('steps.alert.dark');

    $scrollbar = "max-height: 500px; overflow-y: auto;";
    $rootDiv = "justify-center p-4 items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-white dark:bg-gray-700";

@endphp

<div class="{{ $rootDiv }}" style="{{ $scrollbar }}">
    <div class="mb-4 mt-5">
        <h2 class="text-center text-xl mb-3 text-dark dark:text-white">{{ $customerName }}</h2>
        <hr class="border-slate-500 mb-10" />
    </div>
    @if ($taskLogs)
        <ol class="{{ $olHeader }} ml-5">
            @foreach ($taskLogs as $taskLog)
                <li class="{{ $liItem }}">
                    <span class="{{ $liSvgSpan }}">
                        <svg class= "{{ $liSvg['class'] }}" aria-hidden = "{{ $liSvg['aria-hidden'] }}"
                            xmlns = "{{ $liSvg['xmlns'] }}" fill = "{{ $liSvg['fill'] }}"
                            viewBox = "{{ $liSvg['viewBox'] }}">
                            <path d="{{ $liSvgPathd }}" />
                        </svg>
                    </span>
                    <h3 class="{{ $liH3Header }}">
                        {{ $taskLog->number }}
                        @if ($taskLog->require_attention)
                            <span class="{{ $liHeaderSpanUrgent }}">
                                Urgent Attention
                            </span>
                        @endif
                        @if ($taskLog->notification_sent_at)
                            <span class="{{ $liHeaderSpanInfo }}">
                                Notification Sent
                            </span>
                        @endif
                        @if($taskLog->type == $typeVisit)
                            <span class="{{ $liHeaderSpanInfo }}">
                                Site Visit
                            </span>
                        @endif
                        @if($taskLog->type == $typeEnroute)
                            <span class="{{ $liHeaderSpanInfo }}">
                                Enroute Flag
                            </span>
                        @endif                        
                        @if($taskLog->type == $typeOnsite)
                            <span class="{{ $liHeaderSpanInfo }}">
                                Onsite Flag
                            </span>
                        @endif
                        @if($taskLog->type == $typeOffsite)
                            <span class="{{ $liHeaderSpanInfo }}">
                                Offsite Flag
                            </span>
                        @endif
                        @if($taskLog->response_to_external_comment)          
                            <span class="{{ $liHeaderSpanInfo }}">
                                @php
                                    $respondTo = $taskLog->logNumber($taskLog->response_to_external_comment)->user_id;
                                @endphp                                
                                Response to {{ $respondTo }}
                            </span>                                                
                        @endif
                    </h3>
                    <time class="{{ $liDatetime }}">
                        {{ date('F jS, Y', strtotime($taskLog->created_at)) }} 
                        Created by {{ $taskLog->user_id }}
                    </time>
                    <p class="{{ $liPContent }}">
                        {{ $taskLog->description }}
                    </p>
                    @if($taskLog->source == $internal)
                        <button class="{{ $buttonGrey }}" wire:click='responseTrigger({{ $taskLog }})'>
                            Response to Comment        
                        </button>
                        <div class="mt-3" wire:show='openResponse'>
                            @if($taskLog->id == $responseToLog)
                                <form wire:submit='responseToComment({{ $taskLog }})'>
                                    <textarea class="{{ $textArea }}" cols="5" rows="5" wire:model='responseComment'></textarea>
                                    <button type="submit" class="mt-3 {{ $buttonBlue }}">Add Response</button>
                                </form>
                            @endif
                        </div>
                    @endif
            @endforeach
            </li>
        </ol>
    @else
        <div class="{{ $info }}">
            No progress activities currently available
        </div>
    @endif        
</div>
