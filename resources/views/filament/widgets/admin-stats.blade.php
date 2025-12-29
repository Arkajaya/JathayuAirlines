<x-filament::card>
    <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
        <div>
            <h3 class="text-lg font-semibold text-slate-700">Bookings — Last 14 days</h3>
            <p class="text-sm text-gray-500 mt-1">Overview of recent bookings to help you spot trends.</p>
            <div id="admin-booking-chart" wire:ignore.self data-labels='{{ json_encode($labels) }}' data-series='{{ json_encode($bookingsSeries) }}' data-fw-chart="1" data-fw-type="column" data-fw-labels='{{ json_encode($labels) }}' data-fw-values='{{ json_encode($bookingsSeries) }}' class="mt-3 w-full" style="height:300px;"></div>
            <p class="mt-3 text-sm text-gray-600">Total bookings: <strong class="text-indigo-600">{{ $totals['bookings'] }}</strong></p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-slate-700">Revenue — Last 14 days</h3>
            <p class="text-sm text-gray-500 mt-1">Income captured from completed bookings (formatted).</p>
            <div id="admin-revenue-chart" wire:ignore.self data-labels='{{ json_encode($labels) }}' data-series='{{ json_encode($revenueSeries) }}' data-fw-chart="1" data-fw-type="area" data-fw-labels='{{ json_encode($labels) }}' data-fw-values='{{ json_encode($revenueSeries) }}' class="mt-3 w-full" style="height:300px;"></div>
            <p class="mt-3 text-sm text-gray-600">Total revenue: <strong class="text-emerald-600">Rp {{ number_format($totals['revenue'], 0, ',', '.') }}</strong></p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-slate-700">Cancellations — Last 14 days</h3>
            <p class="text-sm text-gray-500 mt-1">Track cancellations to monitor service issues or refund trends.</p>
            <div id="admin-cancel-chart" wire:ignore.self data-labels='{{ json_encode($labels) }}' data-series='{{ json_encode($cancellationsSeries) }}' data-fw-chart="1" data-fw-type="spline" data-fw-labels='{{ json_encode($labels) }}' data-fw-values='{{ json_encode($cancellationsSeries) }}' class="mt-3 w-full" style="height:300px;"></div>
            <p class="mt-3 text-sm text-gray-600">Total cancellations: <strong class="text-rose-600">{{ $totals['cancellations'] }}</strong></p>
        </div>

        <div>
            <h3 class="text-lg font-semibold text-slate-700">Payments Breakdown</h3>
            <p class="text-sm text-gray-500 mt-1">Distribution of payment statuses across recent transactions.</p>
            <div id="admin-payments-pie" wire:ignore.self data-series='{{ json_encode(array_values($paymentsData)) }}' data-labels='{{ json_encode(array_keys($paymentsData)) }}' data-fw-chart="1" data-fw-type="pie" data-fw-labels='{{ json_encode(array_keys($paymentsData)) }}' data-fw-values='{{ json_encode(array_values($paymentsData)) }}' class="mt-3 w-full" style="height:300px;"></div>
            <p class="mt-3 text-sm text-gray-600">Paid / Pending / Refunded / Failed</p>
        </div>
    </div>

    <!-- Chart diinisialisasi oleh filament-widgets-charts.js -->
</x-filament::card>
