<x-app-layout>
    <nav class="flex items-center justify-between py-2 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('payments.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Payments
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
                        Amount
                    </th>
                    <th v-if="search" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Method
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Date
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Created at
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($payments as $payment)
                    <tr class="border-b [&:not(:last-child)]:border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $payment->amount }}
                        </td>
                        <td v-if="search" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $payment->method }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $payment->date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $payment->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <p>No payments</p>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
