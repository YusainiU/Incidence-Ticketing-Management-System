@php
    $svg_logo = Config::get('steps.svg.svg_logo');
    $svg_logo = str_replace('h-6 w-6', 'h-16 w-16', $svg_logo);
    $png_logo = Config::get('steps.logo_path');
    $moniker = strtoupper(Config::get('steps.ticket'));

@endphp
<div class="flex flex-col w-full justify-center bg-slate-400 py-3 px-3">
    <a href="/" class="flex flex-col items-center justify-center">
        <img src="{{ url($png_logo)  }}" alt="logo" title="logo" class="w-48 h-22 mb-4" />        
    </a>
    <span class="block ml-3 text-xl">{{ $moniker }} MANAGEMENT SYSTEM</span>
</div>
