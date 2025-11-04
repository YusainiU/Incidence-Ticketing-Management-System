

@php
    $tabContainer = "flex flex-wrap text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400"
@endphp

<div class="w-full">

    <ul class="{{ $tabContainer }}">
        {{ $tabContent }}
    </ul>
    <div class="p-3">
        {{ $tabMore }}
    </div>

</div>
