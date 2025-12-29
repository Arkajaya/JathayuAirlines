document.addEventListener('DOMContentLoaded', function () {
  try {
    // Customer growth bar chart
    const countryCanvas = document.getElementById('customer-growth-chart');
    if (countryCanvas && typeof Chart !== 'undefined') {
      const labels = JSON.parse(countryCanvas.dataset.labels || '[]');
      const data = JSON.parse(countryCanvas.dataset.data || '[]');
      const ctx = countryCanvas.getContext('2d');
      const grad = ctx.createLinearGradient(0, 0, 0, countryCanvas.height);
      grad.addColorStop(0, 'rgba(124,58,237,0.95)');
      grad.addColorStop(1, 'rgba(124,58,237,0.6)');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Customers',
            data: data,
            backgroundColor: grad,
            borderRadius: 8,
            maxBarThickness: 40,
          }],
        },
        options: {
          animation: { duration: 900, easing: 'easeOutQuart' },
          plugins: { legend: { display: false } },
          scales: {
            x: { grid: { display: false }, ticks: { color: '#6b7280' } },
            y: { beginAtZero: true, ticks: { color: '#6b7280' } }
          }
        }
      });
    }

    // Visit by device donut chart
    const deviceCanvas = document.getElementById('visit-device-chart');
    if (deviceCanvas && typeof Chart !== 'undefined') {
      const labels = JSON.parse(deviceCanvas.dataset.labels || '[]');
      const data = JSON.parse(deviceCanvas.dataset.data || '[]');
      const ctx2 = deviceCanvas.getContext('2d');
      new Chart(ctx2, {
        type: 'doughnut',
        data: {
          labels: labels,
          datasets: [{
            data: data,
            backgroundColor: ['#7c3aed', '#60a5fa', '#f97316'],
            hoverOffset: 8,
          }]
        },
        options: {
          cutout: '65%',
          animation: { duration: 900, easing: 'easeOutQuart' },
          plugins: { legend: { position: 'right', labels: { color: '#374151' } } }
        }
      });
    }
  } catch (e) {
    // silently ignore to avoid breaking Filament UI
    console.error('filament-widgets.js error', e);
  }
});
