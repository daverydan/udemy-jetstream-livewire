<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div class="mt-8 text-2x1">
        Items
    </div>

    @php
        $theads = ['ID', 'Name', 'Price', 'Status', 'Action'];
    @endphp

    <div class="mt-6">
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
