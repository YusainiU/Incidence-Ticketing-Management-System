 @php   
    $table = Config::get('steps.tableClasses.table');
    $tbody = Config::get('steps.tableClasses.tbody');
    $thead = Config::get('steps.tableClasses.thead');
    $th = Config::get('steps.tableClasses.th');
    $td = Config::get('steps.tableClasses.td');
    $thAlign = Config::get('steps.tableClasses.colTr');
    $marginTop = Config::get('steps.tableClasses.divTop');

    $info = Config::get('steps.alert.info');
    $link = Config('steps.link');
    $nodata = Config::get('steps.alert.dark');
@endphp
<div>
    <div class="{{ $marginTop }} mb-3">
        <div class="{{ $info }}"><span class="block text-center">Currently Onsite</span></div>
        @if($onsites)
            <x-table>
                <x-slot name="tableColumns">
                    <tr>
                        <th class="{{ $td }}">
                            Ref #
                        </th>
                        <th class="{{ $td }}">
                            Site
                        </th>
                        <th class="{{ $td }}">
                            Onsite at
                        </th>
                        <th class="{{ $td }}">
                            onsite Assigned To
                        </th>
                    </tr>
                </x-slot>
                <x-slot name="tableRows">
                    @foreach($onsites as $onsite)
                        <tr>
                            <td class="{{ $td }}">
                                <a 
                                    href="{{ route('ticketProfile', ['ticket' => $onsite->ticket]) }}" 
                                    target="_blank"
                                    class="{{ $link }}"
                                >                                
                                    {{ $onsite->ticket->ticket_number }}
                                </a>
                            </td>
                            <td class="{{ $td }}">
                                {{ $onsite->ticket->customer->name }}
                            </td>
                            <td class="{{ $td }}">
                                {{ $onsite->onsite_at ? date('d-m-Y H:i', strtotime($onsite->onsite_at)) : null  }}
                            </td>
                            <td class="{{ $td }}">
                                {{ $onsite->assigned_to ? $onsite->assignedTo->name : null }}
                            </td>                                                        
                        </tr>
                    @endforeach
                </x-slot>
            </x-table>
        @endif
    </div>    
</div>
