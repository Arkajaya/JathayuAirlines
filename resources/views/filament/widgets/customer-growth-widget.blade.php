@php($countries = $this->getCountries())
<x-filament::card class="p-4">
  <div class="flex items-center justify-between">
    <h3 class="text-sm font-semibold">Customer Growth</h3>
    <div class="text-xs text-gray-500">of the week based on the country</div>
  </div>
  <div class="mt-4 grid grid-cols-1 gap-4">
    <div class="bg-white p-4 border rounded">
      @php($chartId = 'customer-growth-chart-'.substr(md5(json_encode($countries)),0,8))
      <div id="{{ $chartId }}" wire:ignore data-fw-chart data-fw-type="column" data-fw-labels='@json(array_column($countries, "country"))' data-fw-values='@json(array_column($countries, "percent"))' style="height:260px;"></div>
    </div>
    <div class="space-y-3">
      @foreach($countries as $c)
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">🌐</div>
            <div class="text-sm">{{ $c['country'] }}</div>
          </div>
          <div class="w-3/12 bg-gray-100 rounded-full h-3 relative">
            <div class="absolute left-0 top-0 h-3 rounded-full bg-primary-600" style="width: {{ $c['percent'] }}%"></div>
          </div>
          <div class="text-sm text-gray-600">{{ $c['percent'] }}%</div>
        </div>
      @endforeach
    </div>
  </div>
</x-filament::card>
