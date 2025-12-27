<div class="filament-card p-4">
  <div class="flex items-center justify-between">
    <h3 class="text-sm font-semibold">Customer Growth</h3>
    <div class="text-xs text-gray-500">of the week based on the country</div>
  </div>
  <div class="mt-4 grid grid-cols-1 gap-4">
    <div class="bg-white p-4 filament-card">
      <canvas id="customer-growth-chart"
        data-labels='@json(array_column($this->getCountries(), "country"))'
        data-data='@json(array_column($this->getCountries(), "percent"))'
        height="160"
      ></canvas>
    </div>
    <div class="space-y-3">
      @foreach($this->getCountries() as $c)
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">🌐</div>
            <div class="text-sm">{{ $c['country'] }}</div>
          </div>
          <div class="w-3/12 bg-gray-100 rounded-full h-3 relative">
            <div class="absolute left-0 top-0 h-3 rounded-full bg-accent" style="width: {{ $c['percent'] }}%"></div>
          </div>
          <div class="text-sm text-gray-600">{{ $c['percent'] }}%</div>
        </div>
      @endforeach
    </div>
  </div>
</div>
