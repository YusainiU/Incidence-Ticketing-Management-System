@php
    $whiteBox = Config::get('steps.whiteBox');
    $textColor = Config::get('steps.standardTextColor');
    $fileInput = Config::get('steps.form.fileInput');
    $submit = Config::get('steps.buttonClasses.btnBlue');
    $delete = Config::get('steps.linkDanger');
@endphp

<div>
    <x-page-profile>
        <x-slot name="title">
            {{-- <span class="block text-2xl">Upload Image</span> --}}
            <div>
                <div class="mt-3 mb-3 py-5 px-5 text-center text-3xl font-bold">
                    UPLOAD IMAGE
                </div>
            </div>
        </x-slot>
        <x-slot name="nav">
            <span></span>
        </x-slot>
        <x-slot name="left_panel">
            <div class="{{ $whiteBox }} {{ $textColor }}">
                <h4 class="mb-5">Uploaded File ..</h4>
                @if ($imagePath)
                    <img src="{{ url('storage/public_images/' . $imagePath) }}" alt="" title="" />
                    <h4 class="mt-5">File Name: {{ $imagePath }}</h4>
                @endif
            </div>
        </x-slot>
        <x-slot name="right_panel">
            <div class="{{ $whiteBox }} {{ $textColor }}">
                <div class="mb-3">
                    @if ($imagePath)
                        <button type="button" class="{{ $submit }} mt-3 w-full" wire:click='restart()'>
                            Upload More ..
                        </button>
                    @else
                        <form wire:submit='uploadImage'>
                            <h4>Start Upload ..</h4>
                            <div class="items-center mt-5" x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false"
                                x-on:livewire-upload-cancel="uploading = false"
                                x-on:livewire-upload-error="uploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <input type="file" wire:model="image" class="{{ $fileInput }}">
                                <div x-show="uploading" class="mt-3">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                                <div>
                                    <button type="submit" class="{{ $submit }} mt-3 w-full">
                                        Upload
                                    </button>
                                </div>
                                <div>
                                    @error('image')
                                        <span class="{{ $textColor }}">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
        </x-slot>
        <x-slot name="bottom_panel">
            <div class="">
            </div>
        </x-slot>
    </x-page-profile>
    <div class="{{ $whiteBox }} {{ $textColor }} m-9">
        <h4 class="mb-5">Gallery ..</h4>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @if (is_array($files))
                @foreach ($files as $file)
                    <div class="text-zinc-900 dark:text-zinc-200">
                        <a href="{{ asset('storage/' . $file) }}" target="_blank">
                            {{-- h-auto max-w-xs --}}
                            <img class="h-auto max-w-xs rounded-lg" src="{{ url('storage/' . $file) }}" alt="">
                        </a>
                        <div class="flex gap-2">
                            <span>{{ $file }}</span>
                            <span>[
                                <a href="#" class="{{ $delete }}"
                                    wire:click="removeImage('{{ $file }}')"
                                    wire:confirm="Are you sure you want to delete this image?">
                                    Delete
                                </a>
                                ]</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
