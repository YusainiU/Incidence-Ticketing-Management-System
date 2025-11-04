
@php
    $whiteBox = Config::get('steps.whiteBox');
@endphp

<div class="mb-10">
    <div class="text-3xl font-bold text-gray-800 dark:text-white p-3 text-center mt-10 ml-10 mr-10">
        <p>{{ $title }}</p>       
    </div>
    <div class="flex md:order-2 space-x-3 gap-5 md:space-x-0 rtl:space-x-reverse mt-10 ml-10 mr-10">
        {{ $nav }}
    </div>    
    <div class="grid grid-cols-2 gap-4 mt-10 ml-10 mr-10 mb-10">
        <div class="{{ $whiteBox }} rounded-md p-3 shadow-2xl mb-10">
            {{ $left_panel }}
        </div>
        <div class="{{ $whiteBox }} rounded-md p-3 shadow-2xl mb-10">
            {{ $right_panel }}
        </div>
    </div>
    <div class="mt-5 ml-10 mr-10">
        {{ $bottom_panel }}
    </div>
</div>
