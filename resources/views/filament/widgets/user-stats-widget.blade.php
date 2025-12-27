@php($d = $this->getData())
<x-filament::card class="p-4">
    <div class="grid grid-cols-2 gap-4">
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Total Users</div>
        <div class="text-2xl font-semibold">{{ $d['total'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Admins</div>
        <div class="text-2xl font-semibold">{{ $d['admins'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">Staff</div>
        <div class="text-2xl font-semibold">{{ $d['staff'] }}</div>
    </div>
    <div class="bg-white shadow-sm rounded p-4 border">
        <div class="text-xs text-gray-500">New (7d)</div>
        <div class="text-2xl font-semibold">{{ $d['recent'] }}</div>
    </div>
    </div>
</x-filament::card>
