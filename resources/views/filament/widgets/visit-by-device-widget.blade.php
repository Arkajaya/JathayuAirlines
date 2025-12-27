<div class="filament-card p-4">
  <div class="flex items-center justify-between">
    <h3 class="text-sm font-semibold">Visit By Device</h3>
    <div class="text-xs text-gray-500"> </div>
  </div>
  <div class="mt-4 flex items-center gap-6">
    <div class="w-1/2">
      <canvas id="visit-device-chart"
        data-labels='@json(array_keys($this->getData()))'
        data-data='@json(array_values($this->getData()))'
        height="140"
      ></canvas>
    </div>
    <div class="w-1/2">
      <ul class="space-y-2">
        <li class="flex items-center justify-between"><span>Mobile</span><span class="text-sm text-gray-600">50%</span></li>
        <li class="flex items-center justify-between"><span>Website</span><span class="text-sm text-gray-600">40%</span></li>
        <li class="flex items-center justify-between"><span>others</span><span class="text-sm text-gray-600">10%</span></li>
      </ul>
    </div>
  </div>
</div>
