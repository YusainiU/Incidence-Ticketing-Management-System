@php
    $thCols = [
        [
            'name' => 'Name',
            'field' => 'name',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Description',
            'field' => 'short_description',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'SLA',
            'field' => 'service_level_agreement_id',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Days',
            'field' => 'days_covered',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Times',
            'field' => 'times_covered',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Public Holiday?',
            'field' => 'include_public_holiday',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Status',
            'field' => 'active',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
    ];

    $tdClass = Config::get('steps.tableClasses.td');
    $thClass = Config::get('steps.tableClasses.th');
    $trThClass = Config::get('steps.tableClasses.colTr');
    $divTopClass = Config::get('steps.tableClasses.divTop');
    $divSeparator = Config::get('steps.tableClasses.divSeparator');

    $tdActionLink = Config::get('steps.buttonClasses.btnGrey');
    $tdActionLinkDelete = Config::get('steps.buttonClasses.btnRed');
    $link = Config::get('steps.link');

@endphp

<div x-data="{slapName:''}">
    <div class="{{ $divTopClass }}">
        <x-section-title>
            <x-slot name="title">
                Service Level Agreement Applications
            </x-slot>
            <x-slot name="description">
                {{ $customer->name }}
            </x-slot>
        </x-section-title>

        <div class="{{ $divSeparator }}">
            &nbsp;
        </div>


        <div class="mt-3 mb-3 flex justify-between gap-x-6 py-5 px-5">
            <x-input name="filter" class="" placeholder="Search records" wire:model.live='filter' />
        </div>        

        {{ $slaps->links() }}

        <x-table>

            <x-slot name="tableColumns">
                <tr class="{{ $trThClass }}">
                    @foreach ($thCols as $col)
                        <th class="{{ $thClass }}">
                            {{ $col['name'] }}
                        </th>
                    @endforeach
                </tr>
            </x-slot>

            <x-slot name="tableRows">
                @if ($slaps)
                    @foreach ($slaps as $sla)
                        <tr>
                            <td class="{{ $tdClass }}">
                                @if($canEdit)
                                <button
                                    class="{{ $link }}"
                                    wire:click="$dispatch('openModal', { 
                                    component: 'EditSlaApplication', 
                                    arguments: {slap:{{ $sla }}}
                                })">
                                    {{ $sla->name }}
                                </button>
                                @else
                                    {{ $sla->name }}
                                @endif
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $sla->short_description }}
                            </td>
                            <td class="{{ $tdClass }}">
                                <button
                                    @click="slapName == '' ? slapName = 'openSlapInfo-{{ $sla->id }}' : slapName = ''">
                                    {{ $sla->serviceLevelAgreement->name }}
                                </button>
                                <div x-show="slapName == 'openSlapInfo-{{ $sla->id }}'">
                                    <ul class="mt-2 mb-2">
                                        <li>Response Time:
                                            {{ $sla->serviceLevelAgreement->response_time['formatted'] }}
                                        </li>
                                        <li>Fixed Time:
                                            {{ $sla->serviceLevelAgreement->fixed_time['formatted'] }}
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $sla->serviceLevelAgreement->start_day }} - {{ $sla->serviceLevelAgreement->end_day }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $sla->serviceLevelAgreement->service_start_time['formatted'] }} -
                                {{ $sla->serviceLevelAgreement->service_end_time['formatted'] }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $sla->serviceLevelAgreement->include_public_holiday }}
                            </td>
                            <td class="{{ $tdClass }}">
                                {{ $sla->slapActive ? 'Enabled' : 'Disabled' }}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </x-slot>

        </x-table>

    </div>
</div>
