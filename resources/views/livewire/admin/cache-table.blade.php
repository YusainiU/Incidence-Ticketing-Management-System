@php


    $th = Config::get('steps.tableClasses.th');
    $td = Config::get('steps.tableClasses.td');
    $thAlign = Config::get('steps.tableClasses.colTr');
    $marginTop = Config::get('steps.tableClasses.divTop');
    $btnBlue = Config::get('steps.buttonClasses.btnBlue');

@endphp

<div class="w-full p-5">

    <div>
        <div class="mt-3 mb-3 py-5 px-5 text-center text-3xl font-bold">
            CACHES
        </div>
    </div>

    <div>
        <div class="mt-3 mb-3 py-5 px-5">
            <button 
                type="button" 
                class="{{ $btnBlue }}" 
                wire:click='clearCaches'
                wire:confirm.prompt="Are you sure?\n\nType CLEAR to confirm|CLEAR"
            >
                Clear All Caches
            </button>
        </div>
    </div>    

    <div>
        <div class="mt-3 mb-3 py-5 px-5">
            <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
        </div>
    </div>

    @if ($caches)
        {{ $caches->links() }}
    @endif

    <x-table>
        <x-slot name="tableColumns">
            <th class="{{ $th }}">
                Key
            </th>
            <th class="{{ $th }}">
                Value
            </th>
            <th class="{{ $th }}">
                Expired
            </th>

        </x-slot>
        <x-slot name="tableRows">
            @if ($caches)
                @foreach ($caches as $cache)
                    <tr class="{{ $thAlign }}">
                        <td class="{{ $td }} align-top">
                            {{ $cache->key }}
                        </td>
                        <td class="{{ $td }} align-top">
                            {{ $cache->value }}
                        </td>
                        <td class="{{ $td }} align-top">
                            {{ date('d-m-Y H:i:s', $cache->expiration) }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </x-slot>
    </x-table>
</div>

