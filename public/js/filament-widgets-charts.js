// Global initializer for Filament widget charts
(function(){
    console.debug('[FW-CHARTS] initializer loaded');
    function loadScript(src){
        return new Promise(function(resolve, reject){
            if (window.Highcharts) return resolve(window.Highcharts);
            var s = document.createElement('script');
            s.src = src;
            s.onload = function(){ resolve(window.Highcharts); };
            s.onerror = reject;
            document.head.appendChild(s);
        });
    }

    async function ensureHighcharts(){
        console.debug('[FW-CHARTS] ensureHighcharts called');
        try {
            if (!window.Highcharts){
                await loadScript('https://code.highcharts.com/highcharts.js');
            }
            return window.Highcharts;
        } catch (e) {
            console.error('Failed to load Highcharts', e);
            return null;
        }
    }

    function initCharts(){
        console.debug('[FW-CHARTS] initCharts running');
        const nodes = document.querySelectorAll('[data-fw-chart]');
        console.debug('[FW-CHARTS] found chart nodes:', nodes.length);
        if (!nodes.length) return;
        ensureHighcharts().then(function(Highcharts){
            console.debug('[FW-CHARTS] Highcharts loaded:', !!Highcharts);
            if (!Highcharts) return;
            nodes.forEach(function(node){
                // skip if already inited
                if (node.dataset.fwInited) return;
                const type = node.dataset.fwType || 'pie';
                const labels = JSON.parse(node.dataset.fwLabels || '[]');
                const values = JSON.parse(node.dataset.fwValues || '[]');

                try {
                    if (type === 'pie'){
                        Highcharts.chart(node.id, {
                            chart: { type: 'pie', backgroundColor: 'transparent' },
                            title: { text: null },
                            tooltip: { pointFormat: '{series.name}: <b>{point.y}%</b>' },
                            plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: false } } },
                            series: [{ name: 'Value', colorByPoint: true, data: labels.map((l,i) => ({ name: l, y: values[i] })) }],
                            credits: { enabled: false }
                        });
                    } else if (type === 'column'){
                        Highcharts.chart(node.id, {
                            chart: { type: 'column', backgroundColor: 'transparent' },
                            title: { text: null },
                            xAxis: { categories: labels },
                            yAxis: { title: { text: 'Value' } },
                            series: [{ name: 'Value', data: values.map(v => Number(v)) }],
                            credits: { enabled: false }
                        });
                    }
                    node.dataset.fwInited = '1';
                } catch (e){
                    console.error('Chart init error', e, node);
                }
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function(){ initCharts(); });
    document.addEventListener('livewire:load', function(){ initCharts(); });
    // Re-init after Livewire updates
    if (window.Livewire && window.Livewire.hook){
        window.Livewire.hook('message.processed', function(){ initCharts(); });
    }
})();
