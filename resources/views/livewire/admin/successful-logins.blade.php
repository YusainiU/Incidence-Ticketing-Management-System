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
            SUCCESSFUL LOGINS   
        </div>
    </div>

    <div>
        <div class="mt-3 mb-3 py-5 px-5">
            <button 
                type="button" 
                class="{{ $btnBlue }}" 
                wire:click='clearAll'
                wire:confirm.prompt="Are you sure?\n\nType CLEAR to confirm|CLEAR"
            >
                Clear All Records
            </button>
        </div>
    </div>

    <div>
        <div class="mt-3 mb-3 py-5 px-5">
            <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
        </div>
    </div>
    
    @if ($attempts)
        {{ $attempts->links() }}
    @endif

    <x-table>
        <x-slot name="tableColumns">
            <th class="{{ $th }}">
                Created At
            </th>
            <th class="{{ $th }}">
                Email
            </th>
            <th class="{{ $th }}">
                Ip Address
            </th>
            <th class="{{ $th }}">
                Access Type
            </th>
        </x-slot>
        <x-slot name="tableRows">
            @if ($attempts)
                @foreach ($attempts as $attempt)
                    <tr class="{{ $thAlign }}">
                        <td class="{{ $td }} align-top">
                            {{ date('d-m-Y H:i', strtotime($attempt->created_at)) }}
                        </td>
                        <td class="{{ $td }} align-top">
                            {{ $attempt->username }}
                        </td>
                        <td class="{{ $td }} align-top">
                            {{ $attempt->ipAddress }}
                        </td>
                        <td class="{{ $td }} align-top">
                            {{ $attempt->userType }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </x-slot>
    </x-table>
</div>
