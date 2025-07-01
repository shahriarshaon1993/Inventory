<x-app-layout>
    <nav class="flex items-center justify-between py-2 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('sale-items.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Sale Items
                </a>
            </li>
        </ol>

        <div class="flex pr-2"></div>
    </nav>

    <div class="overflow-auto">
        <x-alert-message />

        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        #
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Product
                    </th>
                    <th v-if="search" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Quantity
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Unit price
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Total price
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Created at
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($salesItems as $item)
                    <tr class="border-b [&:not(:last-child)]:border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->product->name }}
                        </td>
                        <td v-if="search" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->unit_price }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->total }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $item->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <p>No sales items</p>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $salesItems->links() }}
        </div>
    </div>
</x-app-layout>
