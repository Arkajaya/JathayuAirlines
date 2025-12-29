// Inisialisasi global untuk chart widget Filament
(function(){

    function loadScript(src){
        return new Promise(function(resolve, reject){
            if (window.Highcharts) return resolve(window.Highcharts);
            var s = document.createElement('script');
            s.src = src;
            s.id = 'highcharts-script';
            s.onload = function(){ resolve(window.Highcharts); };
            s.onerror = reject;
            document.head.appendChild(s);
        });
    }

    async function ensureHighcharts(){
        // Pastikan Highcharts tersedia
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

    function queryChartNodes(){
        // Cari elemen chart (prefer atribut data-fw-chart, fallback ke ID umum)
        var nodes = Array.from(document.querySelectorAll('[data-fw-chart]'));
        if (nodes.length) return nodes;
        var fallbackIds = ['booking-chart','revenue-chart','admin-booking-chart','admin-revenue-chart','admin-cancel-chart','admin-payments-pie'];
        fallbackIds.forEach(function(id){
            var el = document.getElementById(id);
            if (el && !nodes.includes(el)) nodes.push(el);
        });
        return nodes;
    }

    function initCharts(){
        try {
            var nodes = queryChartNodes();
            if (!nodes.length) return false;
            ensureHighcharts().then(function(Highcharts){
                if (!Highcharts) return;
                nodes.forEach(function(node){
                    if (!node) return;
                    if (node.dataset.fwInited) return;
                    const type = (node.dataset.fwType || node.dataset.type || 'pie').toLowerCase();
                    var labels = [];
                    var values = [];
                    try {
                        if (node.dataset.fwLabels) labels = JSON.parse(node.dataset.fwLabels || '[]');
                        else if (node.dataset.labels) labels = JSON.parse(node.dataset.labels || '[]');
                    } catch(e){ console.warn('FW-CHARTS: labels parse failed', e); }
                    try {
                        if (node.dataset.fwValues) values = JSON.parse(node.dataset.fwValues || '[]');
                        else if (node.dataset.series) values = JSON.parse(node.dataset.series || '[]');
                    } catch(e){ console.warn('FW-CHARTS: values parse failed', e); }

                    // Inisialisasi node
                    try {
                        if (type === 'pie'){
                            Highcharts.chart(node.id || node, {
                                chart: { type: 'pie', backgroundColor: 'transparent' },
                                title: { text: null },
                                tooltip: { pointFormat: '{series.name}: <b>{point.y}</b>' },
                                plotOptions: { pie: { allowPointSelect: true, cursor: 'pointer', dataLabels: { enabled: false } } },
                                series: [{ name: 'Value', colorByPoint: true, data: labels.map((l,i) => ({ name: l, y: Number(values[i] || 0) })) }],
                                credits: { enabled: false }
                            });
                        } else if (type === 'column' || type === 'area' || type === 'line'){
                            Highcharts.chart(node.id || node, {
                                chart: { type: (type === 'column' ? 'column' : (type === 'area' ? 'area' : 'line')), backgroundColor: 'transparent' },
                                title: { text: null },
                                xAxis: { categories: labels },
                                yAxis: { title: { text: 'Value' } },
                                series: [{ name: 'Value', data: (values || []).map(v => Number(v)) }],
                                credits: { enabled: false }
                            });
                        } else {
                            // fallback: coba render sebagai kolom
                            Highcharts.chart(node.id || node, {
                                chart: { type: 'column', backgroundColor: 'transparent' },
                                title: { text: null },
                                xAxis: { categories: labels },
                                yAxis: { title: { text: 'Value' } },
                                series: [{ name: 'Value', data: (values || []).map(v => Number(v)) }],
                                credits: { enabled: false }
                            });
                        }
                        node.dataset.fwInited = '1';
                    } catch (e){
                        console.error('Chart init error', e, node);
                    }
                });
            });
            return true;
        } catch (e){
            console.error('FW-CHARTS initCharts failed', e);
            return false;
        }
    }

    // Jalankan sekali saat DOM siap
    document.addEventListener('DOMContentLoaded', function(){ initCharts(); });

    // Juga jalankan saat Livewire siap atau setelah pesan Livewire diproses
    document.addEventListener('livewire:load', function(){ initCharts(); });
    (function attachLivewireHook(){
        if (window.Livewire && window.Livewire.hook){
            window.Livewire.hook('message.processed', function(){ initCharts(); });
        } else {
            var attempts = 0;
            var t = setInterval(function(){
                attempts++;
                if (window.Livewire && window.Livewire.hook){
                    window.Livewire.hook('message.processed', function(){ initCharts(); });
                    clearInterval(t);
                }
                if (attempts > 20) clearInterval(t);
            }, 250);
        }
    })();

    // MutationObserver: amati penambahan node yang relevan
    try {
        var observer = new MutationObserver(function(mutations){
            var found = false;
            for (var i=0;i<mutations.length;i++){
                var m = mutations[i];
                if (m.addedNodes && m.addedNodes.length){
                    m.addedNodes.forEach(function(n){
                        if (n.nodeType !== 1) return;
                        if (n.matches && n.matches('[data-fw-chart]')) found = true;
                        if (n.querySelector && n.querySelector('[data-fw-chart]')) found = true;
                        var ids = ['booking-chart','revenue-chart','admin-booking-chart','admin-revenue-chart','admin-cancel-chart','admin-payments-pie'];
                        ids.forEach(function(id){ if (n.id === id || (n.querySelector && n.querySelector('#'+id))) found = true; });
                    });
                }
            }
            if (found) setTimeout(initCharts, 40);
        });
        observer.observe(document.documentElement || document.body, { childList: true, subtree: true });
    } catch(e){ console.warn('FW-CHARTS: MutationObserver not available', e); }

    // Polling fallback: coba beberapa kali jika timing bermasalah
    (function pollingFallback(){
        var attempts = 0;
        var max = 12;
        var iv = setInterval(function(){
            attempts++;
            var ok = initCharts();
            if (ok) clearInterval(iv);
            if (attempts >= max) clearInterval(iv);
        }, 500);
    })();

})();
