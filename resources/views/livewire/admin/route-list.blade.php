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
            ROUTES
        </div>
    </div>

    {{ $t_routes->links() }}    

    <x-table>

        <x-slot name="tableColumns">
            <th class="{{ $th }}">
                Name
            </th>
            <th class="{{ $th }}">
                URI
            </th>
        </x-slot>

        <x-slot name="tableRows">
            @if ($t_routes)
                @foreach ($t_routes as $key => $t_route)
                    <tr class="{{ $thAlign }}">
                        <td class="{{ $td }} align-top">
                            {{ $key }}
                        </td>
                        <td class="{{ $td }} align-top">
                            {{ $t_route->uri }}
                        </td>
                    </tr>
                @endforeach
            @endif
        </x-slot>

    </x-table>
</div>


