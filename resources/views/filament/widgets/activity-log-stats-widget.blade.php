@php($d = $this->getData())
<x-filament::card class="p-4">
    <div class="grid grid-cols-4 gap-4">
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Total Logs</div>
        <div class="text-2xl font-semibold">{{ $d['total'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Today</div>
        <div class="text-2xl font-semibold">{{ $d['today'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Unique Users</div>
        <div class="text-2xl font-semibold">{{ $d['uniqueUsers'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Errors</div>
        <div class="text-2xl font-semibold">{{ $d['errors'] }}</div>
    </div>
    </div>
</x-filament::card>
