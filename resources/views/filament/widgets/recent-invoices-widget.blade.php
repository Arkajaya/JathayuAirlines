<div class="filament-card p-4">
  <div class="card-header">
    <div>
      <h3 class="card-title">Recent Invoices</h3>
      <div class="card-subtitle">Latest orders placed by customers</div>
    </div>
    <div class="text-xs text-gray-500">Filter</div>
  </div>
  <form method="get" class="mt-3 mb-2">
    <div class="flex items-center gap-2">
      <input type="date" name="dashboard_start" value="{{ request('dashboard_start') }}" class="border rounded p-2 text-sm">
      <input type="date" name="dashboard_end" value="{{ request('dashboard_end') }}" class="border rounded p-2 text-sm">
      <button class="filament-button ml-2">Apply</button>
      <a href="{{ url()->current() }}" class="ml-2 text-sm text-gray-500">Reset</a>
    </div>
  </form>
  <table class="min-w-full mt-4 text-sm">
    <thead>
      <tr class="text-left text-gray-500">
        <th>No</th>
        <th>ID Customer</th>
        <th>Customer Name</th>
        <th>Items name</th>
        <th>Order date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach($this->getInvoices() as $i => $invoice)
        <tr class="border-t">
          <td class="py-2">{{ $i + 1 }}</td>
          <td class="py-2">#{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</td>
          <td class="py-2 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center">{{ strtoupper(substr($invoice->user_name,0,1)) }}</div>
            <div>{{ $invoice->user_name }}</div>
          </td>
          <td class="py-2">{{ $invoice->booking_code ?? '-' }}</td>
          <td class="py-2">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</td>
          <td class="py-2"><span class="filament-badge">{{ ucfirst($invoice->payment_status ?? 'pending') }}</span></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
