<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <h1 class="mt-8 text-xl font-bold">
        Items
    </h1>

    <p class="mt-4 text-blue-600">{{ $query }}</p>

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
                        <th class="border px-4 py-2">Edit | Delete</th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>
