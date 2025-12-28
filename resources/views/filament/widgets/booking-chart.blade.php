<x-filament::card>
    <h3 class="text-sm font-medium text-gray-600">Bookings (14d)</h3>
    <div id="booking-chart" wire:ignore.self data-labels='{{ json_encode($labels) }}' data-series='{{ json_encode($series) }}' class="mt-3" style="height:260px;"></div>

    @once
        <script src="https://code.highcharts.com/highcharts.js"></script>
    @endonce

    <script>
        (function () {
            function initOnce() {
                const el = document.getElementById('booking-chart');
                if (!el) return;
                if (el.dataset.hcInitialized) return;
                if (typeof Highcharts === 'undefined') return;
                const labels = JSON.parse(el.dataset.labels || '[]');
                const series = JSON.parse(el.dataset.series || '[]');
                console.debug('BookingChart init', { hasHighcharts: typeof Highcharts !== 'undefined', id: el.id, labelsLength: labels.length, seriesLength: series.length });

                Highcharts.chart(el.id, {
                    chart: { type: 'column', height: 260 },
                    title: { text: null },
                    xAxis: { categories: labels },
                    yAxis: { title: { text: 'Bookings' } },
                    series: [{ name: 'Bookings', data: series, color: '#A1E3F9' }],
                    credits: { enabled: false }
                });

                el.dataset.hcInitialized = '1';
            }

            document.addEventListener('DOMContentLoaded', initOnce);

            if (window.Livewire && Livewire.hook) {
                Livewire.hook('message.processed', (message, component) => {
                    initOnce();
                });
            } else {
                setTimeout(initOnce, 200);
            }
        })();
    </script>
</x-filament::card>
