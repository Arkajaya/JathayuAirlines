@php($d = $this->getData())
<x-filament::card class="p-4">
    <div class="grid grid-cols-3 gap-4">
    <div class="bg-white shadow-sm rounded-lg p-4 border">
        <div class="text-sm text-gray-500">Total Revenue</div>
        <div class="mt-2 text-2xl font-semibold">Rp {{ $d['totalRevenue'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded-lg p-4 border">
        <div class="text-sm text-gray-500">Today's Revenue</div>
        <div class="mt-2 text-2xl font-semibold text-green-600">Rp {{ $d['todayRevenue'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded-lg p-4 border">
        <div class="text-sm text-gray-500">Transactions</div>
        <div class="mt-2 text-2xl font-semibold">{{ $d['paidCount'] }} paid • {{ $d['pending'] }} pending</div>
    </div>
    </div>
</x-filament::card>