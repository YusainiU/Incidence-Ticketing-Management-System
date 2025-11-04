@php

    $text = Config::get('steps.standardTextColor');
    $errorMsg = "text-red-600 $text";
    $fieldClass = 'flex flex-col pb-3';
    $labelClass = Config::get('steps.form.label'); //'md:text-lg text-gray-500 dark:text-gray-400';
    $valueClass = Config::get('steps.form.value'); //'text-lg font-semibold';
    $buttonEditClass = Config::get('steps.buttonClasses.btnEdit');
    $buttonDeleteClass = Config::get('steps.buttonClasses.btnDelete');
    $moniker = Config::get('steps.ticket');

@endphp
<div class="mb-10">
    <form wire:submit='createNewTicket'>
        <x-page-profile>
            <x-slot name="title">
                <span class="block text-2xl">Create New {{ $moniker }}</span>
                <span class="block">{{ $customer->name }}</span>
            </x-slot>
            <x-slot name="nav">
                <span class="w-full block text-2xl text-center text-dark dark:text-white">{{ $customer->customer_type }}</span>
            </x-slot>
            <x-slot name="left_panel">
                <div class="">
                    <x-label value="Type" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='sla_applications_id'>
                        <x-slot name="options">
                            <option value="">--- SELECT TYPE ---</option>
                            @if ($slaps)
                                @foreach ($slaps as $slap)
                                    <option value="{{ $slap->id }}">
                                        {{ $slap->name }}
                                    </option>
                                @endforeach
                            @endif
                        </x-slot>
                    </x-select>
                    <div>
                        @error('sla_application_id')
                            <span class="{{ $errorMsg }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mt-2">
                    <x-label value="Category" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='category'>
                        <x-slot name="options">
                            <option value="">--- SELECT CATEGORY ---</option>
                            @if ($categories)
                                @foreach ($categories as $category)
                                    <option value="{{ $category }}">
                                        {{ $category }}
                                    </option>
                                @endforeach
                            @endif
                        </x-slot>
                    </x-select>
                    <div>
                        @error('category')
                            <span class="{{ $errorMsg }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- <div class="mt-2">
                    <x-label value="Source" class="mb-2"></x-label>
                    <x-select class="w-full" wire:model='source'>
                        <x-slot name="options">
                            <option value="">--- SELECT SOURCE ---</option>
                            @if ($sources)
                                @foreach ($sources as $source)
                                    <option value="{{ $source }}">
                                        {{ $source }}
                                    </option>
                                @endforeach
                            @endif
                        </x-slot>
                    </x-select>
                    <div>
                        @error('category')
                            <span class="{{ $errorMsg }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div> --}}
                <div 
                    x-data="{
                        options: [],
                        open: false,
                        filter: ''
                    }" 
                    class="w-full relative mt-2"
                >
                    <x-label value="Assets" class="mb-2"></x-label>
                    <div 
                        @click="open = !open"
                        class="p-3 rounded-lg flex gap-2 w-full border border-neutral-300 cursor-pointer truncate h-12 bg-white"
                        x-text="options.length + ' items selected'">
                    </div>
                    <div 
                        class="p-3 rounded-lg flex gap-3 w-full shadow-lg x-50 absolute flex-col bg-white mt-3 z-50"
                        x-show="open" 
                        x-trap="open" 
                        @click.outside="open = false"
                        @keydown.escape.window="open = false"
                        x-transition:enter=" ease-[cubic-bezier(.3,2.3,.6,1)] duration-200"
                        x-transition:enter-start="!opacity-0 !mt-0" 
                        x-transition:enter-end="!opacity-1 !mt-3"
                        x-transition:leave=" ease-out duration-200" 
                        x-transition:leave-start="!opacity-1 !mt-3"
                        x-transition:leave-end="!opacity-0 !mt-0"
                    >
                        <input                             
                            x-model="filter" 
                            placeholder="filter" 
                            class="border-b outline-none p-3 -mx-3 pt-0"
                            type="text"
                        >
                        <p x-show="! $el.parentNode.innerText.toLowerCase().includes(filter.toLowerCase())"
                            class="text-neutral-400 text-center font-bolc text-2xl">
                        </p>

                        @if ($assets)
                            @foreach ($assets as $asset)
                                <div 
                                    x-show="$el.innerText.toLowerCase().includes(filter.toLowerCase())"
                                    class="flex items-center"
                                >
                                    <input 
                                        x-model="options" 
                                        id="{{ $asset->id }}" 
                                        type="checkbox"
                                        value="{{ $asset->id }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                        wire:model="selected_assets" 
                                    >
                                    <label 
                                        for="{{ $asset->short_description }}"
                                        class="ml-2 text-sm font-medium text-gray-900 flex-grow"
                                    >
                                        {{ $asset->short_description }}
                                    </label>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>                
            </x-slot>
            <x-slot name="right_panel">
                <div 
                    x-data="{
                        selectedContacts: [],
                        selectedContactName: '',
                        open: false,
                        nonuser: false,
                        filter: ''
                    }" 
                    class="w-full relative"
                >
                    <x-label value="Contact Name" class="mb-2"></x-label>
                    <div 
                        @click="open = !open"
                        x-show="!nonuser"
                        class="p-3 rounded-lg flex gap-2 w-full border border-neutral-300 cursor-pointer truncate h-12 bg-white"
                        x-text=" selectedContactName ? selectedContactName : filter "
                    >                        
                    </div>
                    <x-input wire:model='nonuser' x-show='nonuser' />
                    <button 
                        type="button" 
                        class="mt-2 mb-2 text-xs {{ $text }}" 
                        @click="selectedContactName='';selectedContacts=[];nonuser = !nonuser"
                        x-text=" nonuser ? 'Contact is in the system' : 'Contact is not in the system'";
                        wire:click='resetContactValues'
                    >                        
                    </button>
                    <div class="mt-2" x-show='nonuser'>
                        <x-label value="Contact Telephone" class="mb-2"></x-label>
                        <x-input name="contact_telephone" class="w-full" wire:model='contact_telephone' />
                        <div>
                            @error('contact_telephone')
                                <span class="{{ $errorMsg }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2" x-show='nonuser'>
                        <x-label value="Contact Email" class="mb-2"></x-label>
                        <x-input name="contact_email" class="w-full" wire:model='contact_email' />
                        <div>
                            @error('contact_email')
                                <span class="{{ $errorMsg }}">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>                    
                    <div 
                        class="p-3 rounded-lg flex gap-3 w-full shadow-lg x-50 absolute flex-col bg-white mt-3 z-50"
                        x-show="open && nonuser == false" 
                        x-trap="open" 
                        @click.outside="open = false"
                        @keydown.escape.window="open = false"
                        x-transition:enter=" ease-[cubic-bezier(.3,2.3,.6,1)] duration-200"
                        x-transition:enter-start="!opacity-0 !mt-0" 
                        x-transition:enter-end="!opacity-1 !mt-3"
                        x-transition:leave=" ease-out duration-200" 
                        x-transition:leave-start="!opacity-1 !mt-3"
                        x-transition:leave-end="!opacity-0 !mt-0"
                    >
                        <input                             
                            x-model="filter" 
                            placeholder="Contact Name" 
                            class="border-b outline-none p-3 -mx-3 pt-0"
                            type="text"
                            x-on:change="selectedContactName = ''; selectedContacts = []"
                        >
                        <p x-show="! $el.parentNode.innerText.toLowerCase().includes(filter.toLowerCase())"
                            class="text-neutral-400 text-center font-bolc text-2xl">
                        </p>

                        @if ($contacts)
                            @foreach ($contacts as $contact)
                                <div 
                                    x-show="$el.innerText.toLowerCase().includes(filter.toLowerCase())"
                                    class="flex items-center"
                                >
                                    <input 
                                        x-model="selectedContacts" 
                                        id="{{ $contact->id }}" 
                                        type="radio"
                                        value="{{ $contact->id }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500"
                                        wire:model="selected_contacts"
                                        @click="selectedContactName = '{{  $contact->name }}'" 
                                    >
                                    <label 
                                        for="{{ $contact->name }}"
                                        class="ml-2 text-sm font-medium text-gray-900 flex-grow"
                                    >
                                        {{ $contact->name }}
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>      
                <div class="mt-2">
                    <x-label value="Customer Reference" class="mb-2"></x-label>
                    <x-input name="customer_reference" class="w-full" wire:model='customer_reference' />
                    <div>
                        @error('customer_reference')
                            <span class="{{ $errorMsg }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>                                                                   
            </x-slot>
            <x-slot name="bottom_panel">
                <div class="w-1/2">
                    <x-label value="Short Description" class="mb-2"></x-label>
                    <x-input name="short_description" class="w-full" wire:model='short_description' />
                    <div>
                        @error('short_description')
                            <span class="{{ $errorMsg }}">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-1/2 mt-4">
                    <x-label value="Full Description" class="mb-2"></x-label>
                    <x-text name="description" rows="8" class="w-full" wire:model='description'>
                        <x-slot name="textValue">

                        </x-slot>
                    </x-text>
                </div>                
                <div class="mt-4 pb-4 w-1/2">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Create
                    </button>
                </div>            
            </x-slot>            
        </x-page-profile>
    </form>
</div>
