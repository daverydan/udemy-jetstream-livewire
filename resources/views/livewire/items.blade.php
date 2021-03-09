<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
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
                            Edit
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
    <x-jet-dialog-modal wire:model="confirmingItemDeletion">
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
    </x-jet-dialog-modal>

    <x-jet-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ __('Add Item') }}
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
