<x-app-layout>
    <nav class="flex items-center justify-between pb-1 mb-3">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 gap-2">
                    <x-icon.home class="w-4 h-4" />
                    Dashboard
                </a>
            </li>
        </ol>

        <div class="flex"></div>
    </nav>

    <div>
        <x-text-input id="from_date" name="date" type="date" /> to
        <x-text-input id="to_date" name="date" type="date" />
    </div>

    <div class="grid grid-cols-3 gap-4 mb-4 mt-4">
        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
            <h5 class="mb-4 text-xl font-medium text-gray-500">Total Sales.</h5>
            <div class="flex items-baseline text-gray-900">
                <span class="text-3xl font-semibold">Tk</span>
                <span id="totalSale" class="text-5xl font-extrabold tracking-tight">
                    {{ $totalSale }}
                </span>
            </div>
        </div>

        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
            <h5 class="mb-4 text-xl font-medium text-gray-500">Total Expenses.</h5>
            <div class="flex items-baseline text-gray-900">
                <span class="text-3xl font-semibold">Tk</span>
                <span id="totalExpense" class="text-5xl font-extrabold tracking-tight">
                    {{ $totalExpense }}
                </span>
            </div>
        </div>

        <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
            <h5 class="mb-4 text-xl font-medium text-gray-500">Profit.</h5>
            <div class="flex items-baseline text-gray-900">
                <span class="text-3xl font-semibold">Tk</span>
                <span id="profit" class="text-5xl font-extrabold tracking-tight">
                    {{ $profit }}
                </span>
            </div>
        </div>
    </div>

@push('scripts')
    <script>
        $(document).ready(function () {
            function updateDashboard() {
                const fromDate = $('#from_date').val();
                const toDate = $('#to_date').val();

                // Make ajax request
                $.ajax({
                    url: '{{ route("dashboard") }}',
                    method: 'GET',
                    data: {
                        from: fromDate,
                        to: toDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#totalSale').text(response.totalSale);
                        $('#totalExpense').text(response.totalExpense);
                        $('#profit').text(response.profit);
                    },
                    error: function() {
                        alert('Error fetching data. Please try again.');
                    }
                });
            }

            // Trigger update when date inputs change
            let debounceTimeout;
            $('#from_date, #to_date').on('change', function() {
                clearTimeout(debounceTimeout);
                debounceTimeout = setTimeout(function() {
                    if ($('#from_date').val() && $('#to_date').val()) {
                        updateDashboard();
                    }
                }, 500);
            });
        });
    </script>
@endpush
</x-app-layout>
