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
        <x-alert-message />

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
                        Created at
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b [&:not(:last-child)]:border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
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
                            {{ $product->created_at->format('M d, Y') }}
                        </td>
                        <td class="flex gap-2 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <a href="{{ route('products.edit', $product->id) }}" class="p-1 rounded shadow bg-blue-500 hover:bg-blue-600 text-white">
                                <x-icon.pencil-square class="size-4"/>
                            </a>

                            <form method="POST" action="{{ route('products.destroy', $product->id) }}" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 bg-red-500 hover:bg-red-600 rounded shadow delete-button text-white">
                                    <x-icon.trash class="size-4" />
                                </button>
                            </form>
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

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.delete-form').on('submit', function(e) {
                    if (!confirm('Are you sure you want to delete this sale?')) {
                        e.preventDefault();
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
