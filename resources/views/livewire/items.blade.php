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

        @php
            $theads = ['ID', 'Name', 'Price', 'Status', 'Action'];
        @endphp
        <table class="table-auto w-full">
            <thead>
                @foreach ($theads as $th)
                    <th class="px-4 py-2">
                        <div class="flex-items-center">{{ $th }}</div>
                    </th>
                @endforeach
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <th class="border px-4 py-2">{{ $item->id }}</th>
                        <th class="border px-4 py-2">{{ $item->name }}</th>
                        <th class="border px-4 py-2">{{ number_format($item->price, 2) }}</th>
                        <th class="border px-4 py-2">{{ $item->status ? 'Active' : 'Not Active' }}</th>
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
