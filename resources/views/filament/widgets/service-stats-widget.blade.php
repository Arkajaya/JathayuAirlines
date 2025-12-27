@php($d = $this->getData())
<x-filament::card class="p-4">
    <div class="grid grid-cols-4 gap-4">
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Total Services</div>
        <div class="text-2xl font-semibold">{{ $d['total'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Active</div>
        <div class="text-2xl font-semibold">{{ $d['active'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">New (7d)</div>
        <div class="text-2xl font-semibold">{{ $d['recent'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Most Booked ID</div>
        <div class="text-2xl font-semibold">{{ $d['popular'] ?? '-' }}</div>
    </div>
    </div>
</x-filament::card>
