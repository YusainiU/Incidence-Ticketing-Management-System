@php

    $tabContents = [
        ['name' => 'Customer Contacts', 'active' => true],
        ['name' => 'Assets', 'active' => false],
    ];

    $tabMore[$tabContents[0]['name']] = $contacts;
    $tabMore[$tabContents[1]['name']] = $assets;

    $selectedTab = $selectedTab ? $selectedTab : $tabContents[0]['name'];

    $text = Config::get('steps.standardTextColor');
    $fieldClass = 'flex flex-col pb-3';
    $labelClass = Config::get('steps.form.label');
    $valueClass = Config::get('steps.form.value');
    $whiteBox = Config::get('steps.whiteBox');
    $buttonEditClass = Config::get('steps.buttonClasses.btnBlue');
    $buttonDeleteClass = Config::get('steps.buttonClasses.btnDelete');

    $insetBox = "block mt-3 p-3 border border-zinc-700 rounded-md border-dashed";

@endphp

<div>

    <x-page-profile>
        <x-slot name="title">
            {{ $customer->name }}
        </x-slot>
        <x-slot name="nav">
            @if ($canCreate)
                <a href="{{ route('customerCreateTicket') }}" target="_blank"
                    class="{{ $buttonEditClass }}">
                    Create New Ticket
                </a>
            @endif
            @if ($displayModal)
                <div class="z-50">
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                        <x-modal-onpage showSubmitButton='hide'>
                            <x-slot name="title">
                                File Manager
                            </x-slot>
                            <x-slot name="modalContent">
                                <x-livewire-filemanager />
                            </x-slot>
                        </x-modal-onpage>
                    </div>
                </div>
            @endif
        </x-slot>
        <x-slot name="left_panel">
            <div class="">
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Type:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->primary_type->toName($customer->primary_type->toString()) }}
                    </div>
                </div>
                @if ($customer->child_type)
                    <div class="{{ $fieldClass }}">
                        <div class="{{ $labelClass }}">Secondary Type:</div>
                        <div class="{{ $valueClass }}">
                            {{ $customer->child_type->toName($customer->child_type->toString()) }}
                        </div>
                    </div>
                @endif
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Url:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->url }}
                    </div>
                </div>
                @if ($customer->child_type)
                    <div class="{{ $fieldClass }}">
                        <div class="{{ $labelClass }}">Parent Company:</div>
                        <div class="{{ $valueClass }}">
                            {{ $customer->getParent($customer->parent_company)->name }}
                        </div>
                    </div>
                @endif
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Status:</div>
                    <div class="{{ $valueClass }}">
                        @if ($customer->active)
                            <span class="text-dark dark:{{ $text }} font-bold">Active</span>
                        @else
                            <span class="text-red-300 dark:text-red-700 font-bold">Not Active</span>
                        @endif
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Portal Enabled:</div>
                    <div class="{{ $valueClass }}">
                        @if ($customer->portal_enabled)
                            <span class="text-dark dark:{{ $text }} font-bold">Enabled</span>
                        @else
                            <span class="text-red-300 dark:text-red-700 font-bold">Disabled</span>
                        @endif
                    </div>
                </div>                
            </div>
        </x-slot>
        <x-slot name="right_panel">
            <div class="">
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Address 1:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->address_1 }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Address 2:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->address_2 }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Address 3:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->address_3 }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Telephone:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->telephone_1 }}
                    </div>
                </div>
                <div class="{{ $fieldClass }}">
                    <div class="{{ $labelClass }}">Short Information:</div>
                    <div class="{{ $valueClass }}">
                        {{ $customer->short_description }}
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="bottom_panel">
            @include('livewire.customer.customer-profile-tabs')
        </x-slot>
    </x-page-profile>

    <div class="h-7 mb-10"></div>    

</div>
