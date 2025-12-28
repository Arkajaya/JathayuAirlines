<x-filament::card>
    <div class="flex items-center justify-between">
        <div>
            <h3 class="text-sm font-medium text-gray-600">Cancellation Status</h3>
            <p class="text-2xl font-semibold">{{ number_format($total) }}</p>
        </div>
    </div>

    <div class="mt-4 space-y-3">
        @php
            $items = [
                ['label' => 'Pending', 'value' => $pending, 'color' => $palette[0]],
                ['label' => 'Approved', 'value' => $approved, 'color' => $palette[1]],
                ['label' => 'Rejected', 'value' => $rejected, 'color' => $palette[2]],
            ];
            $max = max(array_column($items, 'value')) ?: 1;
        @endphp

        @foreach ($items as $it)
            <div>
                <div class="flex justify-between text-sm text-gray-600 mb-1">
                    <div>{{ $it['label'] }}</div>
                    <div>{{ $it['value'] }}</div>
                </div>
                <div class="w-full bg-gray-100 rounded h-3 overflow-hidden">
                    <div style="width: {{ ($it['value'] / $max) * 100 }}%; background: {{ $it['color'] }}; height:100%;" class="rounded"></div>
                </div>
            </div>
        @endforeach
    </div>
</x-filament::card>
