@php
    $thCols = [
        [
            'name' => 'Contact Name',
            'field' => 'name',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Email',
            'field' => 'email',
            'columnClasses' => '',
            'rowClasses' => '',
        ],
        [
            'name' => 'Role',
            'field' => 'role',
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

@endphp
<div>
    <div class="{{ $divTopClass }}">

        <x-section-title>
            <x-slot name="title">
                Customer Contacts
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
                @foreach ($contacts as $contact)
                    <tr>
                        <td class="{{ $tdClass }}">
                            {{ $contact->name }}
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $contact->email }}
                        </td>
                        <td class="{{ $tdClass }}">
                            @if ($contact->customerRoles)
                                @foreach ($contact->customerRoles as $role)
                                    <span class="block">{{ $role->customerRole }}</span>
                                @endforeach
                            @endif
                        </td>
                        <td class="{{ $tdClass }}">
                            {{ $contact->active ? 'Active' : 'Not Active' }}
                        </td>
                    </tr>
                @endforeach
            </x-slot>

        </x-table>
    </div>
</div>
