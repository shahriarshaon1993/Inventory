<x-app-layout>
    <nav class="flex items-center justify-between py-2 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('journals.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Journals
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
                        Date
                    </th>
                    <th v-if="search" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Type
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Amount
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Reference
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Created at
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($journals as $journal)
                    <tr class="border-b [&:not(:last-child)]:border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $journal->date->format('M d, Y') }}
                        </td>
                        <td v-if="search" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ ucfirst($journal->type) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $journal->amount }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            @if($journal->reference_type === 'App\Models\Sale')
                                Sale #{{ $journal->reference_id }}
                            @else
                                {{ $journal->reference_type }} #{{ $journal->reference_id }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $journal->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <p>No journals</p>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $journals->links() }}
        </div>
    </div>
</x-app-layout>
