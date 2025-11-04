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
            FAILED ATTEMPTS
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
                Failed Attempts Counter
            </th>
            <th class="{{ $th }}">
                Blocked Date Time
            </th>
            <th class="{{ $th }}">
                Unblocked Date Time
            </th>
            <th class="{{ $th }}">
                Expired?
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
                            {{ $attempt->failedAttemptsCounter }}
                        </td>
                        <td class="{{ $td }} align-top">
                            @if ($attempt->blockedDateTime)
                                {{ date('d-m-Y H:i', strtotime($attempt->blockedDateTime)) }}
                            @endif
                        </td>
                        <td class="{{ $td }} align-top">
                            @if ($attempt->unblockedDateTime)
                                {{ date('d-m-Y H:i', strtotime($attempt->unblockedDateTime)) }}
                            @endif
                        </td>
                        <td class="{{ $td }} align-top">
                            {{ $attempt->expired ? 'expired' : 'blocked' }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </x-slot>
    </x-table>
</div>
