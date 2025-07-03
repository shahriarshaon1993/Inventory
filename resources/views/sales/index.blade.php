<x-app-layout>
    <nav class="flex items-center justify-between py-2 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('sales.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Sales
                </a>
            </li>
        </ol>

        <div class="flex pr-2">
            <x-primary-button-link href="{{ route('sales.create') }}">
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
                        Invoice
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Subtotal
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Discount
                    </th>
                    <th v-if="search" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Vat
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Total amount
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Paid amount
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Due amount
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Date
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Actions
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($sales as $sale)
                    <tr class="border-b [&:not(:last-child)]:border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sale->invoice_no }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sale->subtotal }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sale->discount }}
                        </td>
                        <td v-if="search" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sale->vat }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sale->total_amount }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sale->paid_amount }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sale->due_amount }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $sale->date->format('M d, Y') }}
                        </td>
                        <td class="flex gap-2 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <form method="POST" action="{{ route('sales.destroy', $sale->id) }}" class="inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1 bg-red-500 hover:bg-red-600 shadow rounded text-white delete-button">
                                    <x-icon.trash class="size-4" />
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <p>No sales</p>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $sales->links() }}
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
