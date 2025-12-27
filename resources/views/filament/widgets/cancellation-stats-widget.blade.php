@php($d = $this->getData())
<x-filament::card class="p-4">
    <div class="grid grid-cols-4 gap-4">
    <div class="bg-white shadow-sm rounded-lg p-4 border">
        <div class="text-sm text-gray-500">Total Cancellations</div>
        <div class="mt-2 text-2xl font-semibold">{{ $d['total'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded-lg p-4 border">
        <div class="text-sm text-gray-500">Pending</div>
        <div class="mt-2 text-2xl font-semibold text-yellow-600">{{ $d['pending'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded-lg p-4 border">
        <div class="text-sm text-gray-500">Approved</div>
        <div class="mt-2 text-2xl font-semibold text-green-600">{{ $d['approved'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded-lg p-4 border">
        <div class="text-sm text-gray-500">Rejected</div>
        <div class="mt-2 text-2xl font-semibold text-red-600">{{ $d['rejected'] }}</div>
    </div>
    </div>
</x-filament::card>