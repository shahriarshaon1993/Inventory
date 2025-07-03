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
                        Voucher No.
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Sales invoice
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Date
                    </th>
                    <th v-if="search" class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Reference
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Total journal
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Created at
                    </th>
                    <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody>
                @forelse ($groups as $key => $group)
                    <tr class="border-b [&:not(:last-child)]:border-b transition duration-300 ease-in-out hover:bg-blue-100 cursor-pointer">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ ++$key }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $group->voucher_no }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $group->invoice_no ?? '--' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $group->date->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ ucfirst($group->slug) }} #{{ $group->reference_id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $group->total }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $group->created_at->format('M d, Y') }}
                        </td>
                        <td class="flex gap-2 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <a 
                                href="{{ route('journals.show', [$group->reference_id, $group->slug]) }}" 
                                class="p-1 rounded shadow bg-blue-500 hover:bg-blue-600 text-white"
                            >
                                <x-icon.viewfinder-circle class="size-4"/>
                            </a>
                        </td>
                    </tr>
                @empty
                    <p>No journals</p>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $groups->links() }}
        </div>
    </div>
</x-app-layout>
