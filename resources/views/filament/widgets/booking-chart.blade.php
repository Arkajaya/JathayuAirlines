<x-filament::card>
    <h3 class="text-sm font-medium text-gray-600">Bookings (14d)</h3>
    <div id="booking-chart" wire:ignore.self data-labels='{{ json_encode($labels) }}' data-series='{{ json_encode($series) }}' data-fw-chart="1" data-fw-type="column" data-fw-labels='{{ json_encode($labels) }}' data-fw-values='{{ json_encode($series) }}' class="mt-3" style="height:260px;"></div>

    <script>
        (function () {
            console.debug('booking-chart script loaded');
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

            function initChart() {
                const el = document.getElementById('booking-chart');
                if (!el) return;
                if (el.dataset.hcInitialized) return;
                if (typeof Highcharts === 'undefined') return;
                const labels = JSON.parse(el.dataset.labels || '[]');
                const series = JSON.parse(el.dataset.series || '[]');

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

            function ensure() {
                console.debug('booking-chart ensure()');
                loadHighcharts(initChart);
            }

            document.addEventListener('DOMContentLoaded', ensure);
            if (window.Livewire && Livewire.hook) {
                Livewire.hook('message.processed', () => { ensure(); });
            } else {
                setTimeout(ensure, 200);
            }
        })();
    </script>
</x-filament::card>
