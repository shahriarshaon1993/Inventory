<x-app-layout>
    <nav class="flex items-center justify-between pb-1 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('journals.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Journals
                </a>

                <div class="flex items-center">
                    <x-icon.chevron-right class="w-5 h-5 text-gray-400" />
                    <a class="ml-2 text-sm font-medium text-gray-700 hover:text-blue-600">
                        Details
                    </a>
                </div>
            </li>
        </ol>

        <div class="flex"></div>
    </nav>

    <div class="overflow-auto">
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
                        Referance
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ ucfirst($journal->type) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $journal->amount }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ ucfirst($journal->slug) }} #{{ $journal->reference_id }}
                        </td>
                        <td class="flex gap-2 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $journal->created_at->format('M d, Y') }}
                        </td>
                    </tr>
                @empty
                    <p>No journals</p>
                @endforelse
            </tbody>
        </table>


        {{-- <div class="max-w-7xl mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            Create a new product
                        </h2>
                    </header>

                    <div class="mt-6 space-y-6">
                        @foreach ($journals as $journal)
                            <li>{{$journal->id}}</li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</x-app-layout>
