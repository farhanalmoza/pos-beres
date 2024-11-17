@extends('components.layout')
@section('title', 'Admin | Dashboard')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-3 mb-4">
      <div class="card card-border-shadow-primary">
        <div class="card-body text-end">
          <h5 class="card-title">Rp. 0</h5>
          <div class="card-subtitle text-muted mb-3">Jumlah Pengeluaran</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 mb-4">
      <div class="card">
        <div class="card-body text-end">
          <h5 class="card-title">Rp. 0</h5>
          <div class="card-subtitle text-muted mb-3">Jumlah Keuntungan</div>
        </div>
      </div>
    </div>

    <div class="col-12 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Grafik Penjualan</h5>
        </div>
        <div class="card-body">
          <canvas id="salesChart" width="400" height="200"></canvas>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Barang Terlaris</h5>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Harga</th>
                <th scope="col">Terjual</th>
              </tr>
            </thead>
            <tbody>
              @if (count($topProducts) == 0)
                <tr>
                  <td colspan="4" class="text-center">Belum ada penjualan di bulan ini</td>
                </tr>
              @else
                @foreach ($topProducts as $product)
                  <tr>
                    <th>{{ $product->code }}</th>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->total_sold }}</td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header">
          <h5>Barang Tidak Laku</h5>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">Kode Barang</th>
                <th scope="col">Nama Barang</th>
              </tr>
            </thead>
            <tbody>
              @if (count($inactiveProducts) == 0)
                <tr>
                  <td colspan="4" class="text-center">Data tidak ditemukan</td>
                </tr>
              @else
                @foreach ($inactiveProducts as $product)
                  <tr>
                    <th>{{ $product['code'] }}</th>
                    <td>{{ $product['name'] }}</td>
                  </tr>
                @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Data penjualan, sesuaikan dengan data Anda
  const labels = ['01-09', '02-09', '03-09', '04-09', '05-09']; // Tanggal per hari (sumbu x)
  const pendapatanData = [5000, 7000, 8000, 6000, 9000]; // Pendapatan (dalam ribuan rupiah)
  const modalData = [3000, 4000, 4500, 3500, 5000]; // Modal (dalam ribuan rupiah)
  const keuntunganData = pendapatanData.map((pendapatan, index) => pendapatan - modalData[index]); // Keuntungan

  // Inisialisasi Chart.js
  const ctx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(ctx, {
    type: 'bar', // Tipe grafik utama bar
    data: {
      labels: labels,
      datasets: [
        {
          label: 'Pendapatan',
          data: pendapatanData,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
          type: 'bar', // Menampilkan dalam bentuk bar
          yAxisID: 'y-axis-1', // Menggunakan sumbu Y yang pertama
        },
        {
          label: 'Modal',
          data: modalData,
          borderColor: 'rgba(255, 99, 132, 1)',
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          fill: false, // Jangan isi area di bawah line chart
          type: 'line', // Menampilkan dalam bentuk line
          yAxisID: 'y-axis-1', // Menggunakan sumbu Y yang pertama
        },
        {
          label: 'Keuntungan',
          data: keuntunganData,
          borderColor: 'rgba(54, 162, 235, 1)',
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          fill: false,
          type: 'line',
          yAxisID: 'y-axis-1',
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        yAxes: [
          {
            id: 'y-axis-1',
            type: 'linear',
            position: 'left',
            ticks: {
              callback: function(value) {
                return 'Rp. ' + value.toString() + 'K'; // Format sumbu Y dalam ribuan rupiah
              }
            },
            scaleLabel: {
              display: true,
              labelString: 'Nilai (Ribuan Rupiah)'
            }
          }
        ],
        xAxes: [
          {
            scaleLabel: {
              display: true,
              labelString: 'Tanggal'
            }
          }
        ]
      },
      tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            return data.datasets[tooltipItem.datasetIndex].label + ': Rp. ' + tooltipItem.yLabel + 'K';
          }
        }
      }
    }
  });
</script>
@endsection