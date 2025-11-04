@php
    $elip = Config::get('steps.svg.svg_ellipsis');
    $next = Config::get('steps.svg.svg_next');
    $ul = 'w-full space-y-1 list-inside';
    $li = 'flex items-center gap-3';
    $li_second = 'flex flex-col gap-2';
    $insetBox = 'block text-zinc-950 mt-3 ml-9 p-3 border border-zinc-700 rounded-md border-dashed bg-zinc-100';

@endphp
<div class="w-full p-5">

    <div>
        <div class="mt-3 mb-3 py-5 px-5 text-center text-3xl font-bold">
            CONFIGURATIONS
        </div>
    </div>

    <div x-data="{ key: '' }">
        @if ($configs)
            <ul class="{{ $ul }}">
                @foreach ($configs as $key => $config)
                    <li class="{{ $li }}">
                        {!! $elip !!}
                        <button x-on:click="key = key ? '' : '{{ $key }}'">
                            <span>{{ $key }}:</span>
                        </button>
                        @if (is_array($config))
                            <button x-on:click="key = key ? '' : '{{ $key }}'">
                                {!! $next !!}
                            </button>
                        @else
                            <span>{{ $config }}</span>
                        @endif
                    </li>
                    <div x-show="key == '{{ $key }}'" class="{{ $insetBox }}">
                        <ul class="{{ $ul }}">
                            @if (is_array($config))
                                @foreach ($config as $ckey => $cval)
                                    <li class="{{ $li_second }}">
                                        <span class="font-bold">{{ $ckey }} ..</span>
                                        <div class="pl-10 p-3 border border-dashed border-zinc-700">
                                            @if (is_array($cval))
                                                {{ json_encode($cval) }}
                                            @else
                                                {!! $cval !!}
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <span class="font-bold">{{ $config }}</span>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </ul>
        @endif
    </div>
</div>
