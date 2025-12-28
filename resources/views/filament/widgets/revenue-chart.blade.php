<x-filament::card>
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-600">Revenue (14d)</h3>
            <p class="text-2xl font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</p>
        </div>
    </div>

    <div id="revenue-chart" wire:ignore.self data-labels='{{ json_encode($labels) }}' data-series='{{ json_encode($series) }}' class="mt-3" style="height:280px;"></div>

    @once
        <script src="https://code.highcharts.com/highcharts.js"></script>
    @endonce

    <script>
        (function () {
            function initOnce() {
                const el = document.getElementById('revenue-chart');
                if (!el) return;
                if (el.dataset.hcInitialized) return;
                if (typeof Highcharts === 'undefined') return;
                const labels = JSON.parse(el.dataset.labels || '[]');
                const series = JSON.parse(el.dataset.series || '[]');
                console.debug('RevenueChart init', { hasHighcharts: typeof Highcharts !== 'undefined', id: el.id, labelsLength: labels.length, seriesLength: series.length });

                Highcharts.chart(el.id, {
                    chart: { type: 'line', height: 280 },
                    title: { text: null },
                    xAxis: { categories: labels },
                    yAxis: { title: { text: 'Revenue' }, labels: { formatter: function(){ return 'Rp ' + Highcharts.numberFormat(this.value, 0, ',', '.'); } } },
                    series: [{ name: 'Revenue', data: series, color: '#578FCA' }],
                    tooltip: { pointFormatter: function(){ return '<b>Rp ' + Highcharts.numberFormat(this.y, 0, ',', '.') + '</b>'; } },
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
