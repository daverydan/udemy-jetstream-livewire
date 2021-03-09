<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    @if (session('message'))
        <div class="rounded-md bg-blue-50 p-4" x-data="{show: true}" x-show="show">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">{{ session('message') }}</h3>
                </div>
                <div class="ml-auto pl-3">
                    <div class="-mx-1.5 -my-1.5">
                        <button class="inline-flex bg-blue-50 rounded-md p-1.5 text-blue-500 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-blue-50 focus:ring-blue-600" @click="show = false">
                            <span class="sr-only">Dismiss</span>
                            <!-- Heroicon name: solid/x -->
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <h1 class="mt-8 text-xl font-bold flex justify-between">
        <div>Items</div>
        <div class="mr-2">
            <x-jet-button wire:click="confirmItemAdd" class="bg-blue-500 hover:bg-blue-700">
                Add Item
            </x-jet-button>
        </div>
    </h1>

    {{-- <p class="mt-4 text-blue-600">{{ $query }}</p> --}}

    <div class="mt-6">
        <div class="flex justify-between">
            <div>
                <input wire:model.debounce.500ms="search" type="search" placeholder="Search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focud:shadow-outline">
            </div>
            <div class="mr-2">
                <label for="active">
                    <input wire:model="active" type="checkbox" id="active" class="mr-1 leading-tight"> Active Only
                </label>
            </div>
        </div>

        <table class="table-auto w-full">
            <thead>
                <th class="px-4 py-2">
                    <div class="flex items-center">
                        <button wire:click="sortBy('id')" class="font-bold">ID</button>
                        <x-sort-icon sortField="id" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </th>
                <th class="px-4 py-2">
                    <div class="flex items-center">
                        <button wire:click="sortBy('name')" class="font-bold">Name</button>
                        <x-sort-icon sortField="name" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </th>
                <th class="px-4 py-2">
                    <div class="flex items-center">
                        <button wire:click="sortBy('price')" class="font-bold">Price</button>
                        <x-sort-icon sortField="price" :sort-by="$sortBy" :sort-asc="$sortAsc" />
                    </div>
                </th>
                @if (!$active)
                    <th class="px-4 py-2">
                        <div>Status</div>
                    </th>
                @endif
                <th class="px-4 py-2">
                    <div>Action</div>
                </th>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <th class="border px-4 py-2">{{ $item->id }}</th>
                        <th class="border px-4 py-2">{{ $item->name }}</th>
                        <th class="border px-4 py-2">{{ number_format($item->price, 2) }}</th>
                        @if (!$active)
                            <th class="border px-4 py-2">{{ $item->status ? 'Active' : 'Not Active' }}</th>
                        @endif
                        <th class="border px-4 py-2">
                            <x-jet-button wire:click="confirmItemEdit({{ $item->id }})" class="bg-blue-500 hover:bg-blue-700">
                                Edit
                            </x-jet-button>
                            <x-jet-danger-button wire:click="confirmItemDeletion({{ $item->id }})" wire:loading.attr="disabled">
                                Delete
                            </x-jet-danger-button>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>

    {{-- Modals --}}
    <x-jet-confirmation-modal wire:model="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item?') }}
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteItem({{ $confirmingItemDeletion }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <x-jet-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ isset($this->item->id) ? 'Edit Item' : 'Add Item' }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="item.name" />
                <x-jet-input-error for="item.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mt-4">
                <x-jet-label for="price" value="{{ __('Price') }}" />
                <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="item.price" />
                <x-jet-input-error for="item.price" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mt-4">
                <div class="flex">
                    <label for="active-add" class="flex items-center">
                        <input wire:model.defer="item.status" type="checkbox" id="active-add" class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded shadow-sm">
                        <span class="ml-2">Active</span>
                    </label>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="saveItem()" wire:loading.attr="disabled">
                Save
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
