<div class="dashboard-grid">
  <div class="dashboard-card-wide filament-card p-6">
    <form method="get" class="mb-4">
      <div class="flex items-center gap-2">
        <input type="date" name="dashboard_start" value="{{ request('dashboard_start') }}" class="border rounded p-2 text-sm">
        <input type="date" name="dashboard_end" value="{{ request('dashboard_end') }}" class="border rounded p-2 text-sm">
        <button class="filament-button ml-2">Apply</button>
        <a href="{{ url()->current() }}" class="ml-2 text-sm text-gray-500">Reset</a>
      </div>
    </form>

    <div class="grid grid-cols-3 gap-4">
      <div class="bg-white p-4 filament-card">
          <div class="card-header">
          <div>
            <div class="text-sm text-gray-500">Net Revenue</div>
            <div class="text-2xl font-semibold text-accent">Rp {{ $this->getData()['netRevenue'] }}</div>
            <div class="text-xs text-green-500 mt-2">+6.5% Since last week</div>
          </div>
          <div class="icon-accent" aria-hidden>
            <svg width="28" height="28" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>
          </div>
        </div>
      </div>
      <div class="bg-white p-4 filament-card">
        <div class="card-header">
          <div>
            <div class="text-sm text-gray-500">Total Products</div>
            <div class="text-2xl font-semibold text-accent">{{ $this->getData()['totalProducts'] }}</div>
            <div class="text-xs text-green-500 mt-2">+6.5% Since last week</div>
          </div>
          <div class="text-2xl">📦</div>
        </div>
      </div>
      <div class="bg-white p-4 filament-card">
        <div class="card-header">
          <div>
            <div class="text-sm text-gray-500">Total Transactions</div>
            <div class="text-2xl font-semibold text-accent">{{ $this->getData()['totalTransactions'] }}</div>
            <div class="text-xs text-red-500 mt-2">-6.5% Since last week</div>
          </div>
          <div class="text-2xl">🧾</div>
        </div>
      </div>
    </div>
  </div>

  <div class="dashboard-card-narrow filament-card p-4">
    <div class="text-sm text-gray-500">Top Traffic By Source</div>
    <ul class="mt-3 space-y-3">
      <li class="flex items-center justify-between"><span>Google</span><span class="text-sm text-gray-600">9.6k</span></li>
      <li class="flex items-center justify-between"><span>Facebook</span><span class="text-sm text-gray-600">9.6k</span></li>
      <li class="flex items-center justify-between"><span>Instagram</span><span class="text-sm text-gray-600">9.6k</span></li>
      <li class="flex items-center justify-between"><span>Twitter</span><span class="text-sm text-gray-600">9.6k</span></li>
    </ul>
  </div>
</div>
