@php($d = $this->getData())

<x-filament::card class="p-4">
    <div class="grid grid-cols-3 gap-4">
    <div class="col-span-2 bg-white rounded-lg shadow-sm p-5">
        <form method="get" class="mb-4">
            <div class="flex items-center gap-2">
                <input type="date" name="dashboard_start" value="{{ request('dashboard_start') }}" class="border rounded p-2 text-sm">
                <input type="date" name="dashboard_end" value="{{ request('dashboard_end') }}" class="border rounded p-2 text-sm">
                <button class="ml-2 inline-flex items-center px-3 py-1.5 bg-primary-600 text-white rounded">Apply</button>
                <a href="{{ url()->current() }}" class="ml-2 text-sm text-gray-500">Reset</a>
            </div>
        </form>

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded p-4 border">
                <div class="text-sm text-gray-500">Net Revenue</div>
                <div class="text-2xl font-semibold mt-2">Rp {{ $d['netRevenue'] }}</div>
                <div class="text-xs text-green-600 mt-1">+6.5% Since last week</div>
            </div>
            <div class="bg-white rounded p-4 border">
                <div class="text-sm text-gray-500">Total Products</div>
                <div class="text-2xl font-semibold mt-2">{{ $d['totalProducts'] }}</div>
                <div class="text-xs text-green-600 mt-1">+6.5% Since last week</div>
            </div>
            <div class="bg-white rounded p-4 border">
                <div class="text-sm text-gray-500">Total Transactions</div>
                <div class="text-2xl font-semibold mt-2">{{ $d['totalTransactions'] }}</div>
                <div class="text-xs text-red-600 mt-1">-6.5% Since last week</div>
            </div>
        </div>
    </div>

    <div class="col-span-1 bg-white rounded-lg shadow-sm p-5 border">
        <div class="text-sm text-gray-500">Top Traffic By Source</div>
        <ul class="mt-3 space-y-3">
            <li class="flex items-center justify-between"><span>Google</span><span class="text-sm text-gray-600">9.6k</span></li>
            <li class="flex items-center justify-between"><span>Facebook</span><span class="text-sm text-gray-600">9.6k</span></li>
            <li class="flex items-center justify-between"><span>Instagram</span><span class="text-sm text-gray-600">9.6k</span></li>
            <li class="flex items-center justify-between"><span>Twitter</span><span class="text-sm text-gray-600">9.6k</span></li>
        </ul>
    </div>
    </div>
</x-filament::card>
