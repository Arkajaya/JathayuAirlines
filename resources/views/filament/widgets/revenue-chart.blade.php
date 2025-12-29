<x-filament::card>
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-600">Revenue (14d)</h3>
            <p class="text-2xl font-semibold">Rp {{ number_format($total, 0, ',', '.') }}</p>
        </div>
    </div>

    <div id="revenue-chart" wire:ignore.self data-labels='{{ json_encode($labels) }}' data-series='{{ json_encode($series) }}' data-fw-chart="1" data-fw-type="column" data-fw-labels='{{ json_encode($labels) }}' data-fw-values='{{ json_encode($series) }}' class="mt-3" style="height:280px;"></div>

    <script>
        (function () {
            console.debug('revenue-chart script loaded');
            function loadHighcharts(callback) {
                if (typeof Highcharts !== 'undefined') return callback();
                if (document.getElementById('highcharts-script')) {
                    document.getElementById('highcharts-script').addEventListener('load', callback);
                    return;
                }
                const s = document.createElement('script');
                s.id = 'highcharts-script';
                s.src = 'https://code.highcharts.com/highcharts.js';
                s.onload = callback;
                document.head.appendChild(s);
            }

            function initOnce() {
                const el = document.getElementById('revenue-chart');
                if (!el) return;
                if (el.dataset.hcInitialized) return;
                if (typeof Highcharts === 'undefined') return;
                const labels = JSON.parse(el.dataset.labels || '[]');
                const series = JSON.parse(el.dataset.series || '[]');

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

            function ensure() { console.debug('revenue-chart ensure()'); loadHighcharts(initOnce); }

            document.addEventListener('DOMContentLoaded', ensure);
            if (window.Livewire && Livewire.hook) {
                Livewire.hook('message.processed', (message, component) => { ensure(); });
            } else {
                setTimeout(ensure, 200);
            }
        })();
    </script>
</x-filament::card>
