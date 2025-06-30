<x-app-layout>
    <nav class="flex items-center justify-between py-2 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Products
                </a>
            </li>
        </ol>

        <div class="flex pr-2">
            <x-primary-button-link href="{{ route('products.create') }}">
                Create
            </x-primary-button-link>
        </div>
    </nav>

    <div class="overflow-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        #
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Name
                    </th>
                    <th v-if="search" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Purchase price
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Sell price
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Opening stock
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Current stock
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center">
                            {{ $product->name }}
                        </td>
                        <td v-if="search" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->purchase_price }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->sell_price }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->opening_stock }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $product->current_stock }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Edit|Delete
                        </td>
                    </tr>
                @empty
                    <p>No products</p>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>
