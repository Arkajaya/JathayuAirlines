@php($d = $this->getData())
<x-filament::card class="p-4">
  <div class="flex items-center justify-between">
    <h3 class="text-sm font-semibold">Visit By Device</h3>
  </div>
  <div class="mt-4 flex items-center gap-6">
    <div class="w-1/2">
      @php($chartId = 'visit-device-chart-'.substr(md5(json_encode($d)),0,8))
      <div id="{{ $chartId }}" wire:ignore data-fw-chart data-fw-type="pie" data-fw-labels='@json(array_keys($d))' data-fw-values='@json(array_values($d))' style="height:220px;"></div>
    </div>
    <div class="w-1/2">
      <ul class="space-y-2">
        <li class="flex items-center justify-between"><span>Mobile</span><span class="text-sm text-gray-600">{{ $d['mobile'] }}%</span></li>
        <li class="flex items-center justify-between"><span>Website</span><span class="text-sm text-gray-600">{{ $d['website'] }}%</span></li>
        <li class="flex items-center justify-between"><span>Others</span><span class="text-sm text-gray-600">{{ $d['others'] }}%</span></li>
      </ul>
    </div>
  </div>
</x-filament::card>
