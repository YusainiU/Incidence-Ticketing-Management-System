<div>
<?php
    $btnClose="
    text-gray-400 
    bg-transparent 
    hover:bg-gray-200 
    hover:text-gray-900 
    rounded-lg 
    text-sm 
    w-8 
    h-8 
    ms-auto 
    inline-flex 
    justify-center 
    items-center
    dark:hover:bg-gray-600 
    dark:hover:text-white";
?>

<div class="justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Create New Role
                </h3>
                <button 
                    type="button" 
                    class="{{ $btnClose }}"
                    wire:click="$dispatch('closeModal')"
                >
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form wire:submit='createNewRole'>
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    <x-label value="Role Name" class="mb-3"></x-label>
                    <x-input name="name" class="w-full" wire:model='name'/>
                    <div>
                        @error('name')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </p>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    <x-label value="Short Description" class="mb-3"></x-label>
                    <x-input name="description" class="w-full" wire:model='description'/>
                    <div>
                        @error('description')
                            <span class="text-red-600">{{ $message }}</span>
                        @enderror
                    </div>
                </p>                            
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                    <label>
                        <x-checkbox name="active" class="mr-2" wire:model='active' />
                        Active
                    </label>
                </p>                
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button 
                    type="submit" 
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                    >
                        Create
                </button>
                <button 
                    type="button" 
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    wire:click="$dispatch('closeModal')"
                    >
                        Close
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>
