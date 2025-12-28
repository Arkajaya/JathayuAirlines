@extends('layouts.app')

@section('title', 'Infographics')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Infographics & Statistics</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-semibold mb-2">Monthly Revenue (12 months)</h3>
            @php
                $hasRevenue = collect($monthlyRevenue)->sum() > 0;
            @endphp
            <canvas id="chartRevenue" height="200"></canvas>
            @unless($hasRevenue)
                <div class="py-4 text-center text-sm text-gray-500">Tidak ada data pendapatan untuk 12 bulan terakhir.</div>
            @endunless
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-semibold mb-2">Bookings (last 30 days)</h3>
            @php
                $hasBookings = collect($bookings30)->sum() > 0;
            @endphp
            <canvas id="chartBookings30" height="200"></canvas>
            @unless($hasBookings)
                <div class="py-4 text-center text-sm text-gray-500">Tidak ada pemesanan dalam 30 hari terakhir.</div>
            @endunless
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <h3 class="font-semibold mb-2">Class Distribution</h3>
            <canvas id="chartClass" height="200"></canvas>
            @if(!count($classLabels))
                <div class="py-4 text-center text-sm text-gray-500">Tidak ada data kelas layanan.</div>
            @endif
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex flex-col items-center justify-center">
            <h3 class="font-semibold mb-2">Average Occupancy</h3>
            <div class="text-4xl font-bold text-primary">{{ $averageOccupancy }}%</div>
            <p class="text-sm text-gray-500 mt-2">Rata-rata okupansi per layanan</p>
        </div>
    </div>

</div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data from controller
        const months = @json($months);
        const monthlyRevenue = @json($monthlyRevenue);

        const labels30 = @json($labels30);
        const bookings30 = @json($bookings30);

        const classLabels = @json($classLabels);
        const classData = @json($classData);

        // Revenue chart: always init (zeros allowed). Format ticks as IDR.
        (function(){
            const ctxRevenue = document.getElementById('chartRevenue').getContext('2d');
            new Chart(ctxRevenue, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Revenue',
                        data: monthlyRevenue,
                        backgroundColor: 'rgba(59,130,246,0.08)',
                        borderColor: 'rgba(59,130,246,1)',
                        tension: 0.25,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const v = context.parsed.y ?? context.parsed;
                                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(v);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
                                }
                            }
                        }
                    }
                }
            });
        })();

        // Bookings 30 days chart: always init
        (function(){
            const ctxB30 = document.getElementById('chartBookings30').getContext('2d');
            new Chart(ctxB30, {
                type: 'bar',
                data: {
                    labels: labels30,
                    datasets: [{
                        label: 'Bookings',
                        data: bookings30,
                        backgroundColor: 'rgba(16,185,129,0.8)'
                    }]
                },
                options: { 
                    responsive: true, 
                    scales: { y: { beginAtZero: true, ticks: { precision:0 } } } 
                }
            });
        })();

        // Class distribution pie (guard if empty)
        (function(){
            const ctxClass = document.getElementById('chartClass').getContext('2d');
            const labels = (Array.isArray(classLabels) && classLabels.length) ? classLabels : ['No data'];
            const data = (Array.isArray(classData) && classData.length) ? classData : [0];
            new Chart(ctxClass, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#60A5FA', '#34D399', '#FBBF24', '#F87171', '#C4B5FD'
                        ]
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
        })();
    </script>
@endsection
