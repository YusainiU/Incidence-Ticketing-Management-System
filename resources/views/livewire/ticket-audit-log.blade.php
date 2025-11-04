@php
    $table = Config::get('steps.tableClasses.table');
    $tbody = Config::get('steps.tableClasses.tbody');
    $thead = Config::get('steps.tableClasses.thead');
    $th = Config::get('steps.tableClasses.th');
    $td = Config::get('steps.tableClasses.td');
    $thAlign = Config::get('steps.tableClasses.colTr');
    $marginTop = Config::get('steps.tableClasses.divTop');

    $info = Config::get('steps.alert.info');
    $link = Config::get('steps.link');
    $text = Config::get('steps.standardTextColor');

    $colspan = 0;
    if ($contents) {
        $colspan = sizeof($columnNames);
    }

@endphp

<div style="max-height: 400px; overflow-y: auto;">
    <div class="{{ $marginTop }} mb-3">
        <div class="{{ $info }}"><span class="block text-center">Changes Audit</span></div>

        @if (count($contents))
            <x-table class="{{ $table }}">
                <x-slot name="tableColumns">
                    <tr>
                        @foreach ($columnNames as $column)
                            <th class="{{ $td }}">
                                {{ $column }}
                            </th>
                        @endforeach
                    </tr>
                </x-slot>
                <x-slot name="tableRows">
                    @foreach ($contents as $position => $content)
                        <tr>
                            <td colspan="{{ $colspan }}" class="p-2 {{ $text }} pl-6 bg-gray-600">
                                @php
                                    $sectionName = 'Ticket Change Audit';
                                    if ($position == 1) {
                                        $sectionName = 'Visit Change Audit';
                                    }
                                    if ($position == 2) {
                                        $sectionName = 'Response Change Audit';
                                    }
                                @endphp
                                <span>{{ $sectionName }}</span>
                            </td>
                        </tr>
                        @if ($content)
                            @foreach ($content as $rows)
                                <tr>
                                    @foreach ($rows as $key => $value)
                                        <td class="{{ $td }}">
                                            {{ $value }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="{{ $td }} text-center" colspan="{{ $colspan }}">
                                    No Audit Record
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </x-slot>
            </x-table>
        @endif
    </div>
</div>
