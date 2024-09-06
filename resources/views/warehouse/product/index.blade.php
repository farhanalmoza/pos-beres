@extends('components.layout')
@section('title', 'Gudang | Daftar Stok Barang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-md-12">
      <div class="card">
        <h5 class="card-header">Daftar Barang</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr class="text-nowrap">
                <th>No.</th>
                <th>Kode Barang</th>
                <th>Kategori</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Harga Jual</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr>
                <th scope="row">1</th>
                <td>P01</td>
                <td>Makanan & Minuman</td>
                <td>Roti Tawar</td>
                <td>500</td>
                <td>15.000</td>
                <td>
                  <button class="btn btn-primary btn-sm">Print Barcode</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="demo-inline-spacing px-4 overflow-auto">
          <!-- Basic Pagination -->
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <li class="page-item first">
                <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-left"></i></a>
              </li>
              <li class="page-item prev">
                <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-left"></i></a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0);">1</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0);">2</a>
              </li>
              <li class="page-item active">
                <a class="page-link" href="javascript:void(0);">3</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0);">4</a>
              </li>
              <li class="page-item">
                <a class="page-link" href="javascript:void(0);">5</a>
              </li>
              <li class="page-item next">
                <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-right"></i></a>
              </li>
              <li class="page-item last">
                <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevrons-right"></i></a>
              </li>
            </ul>
          </nav>
          <!--/ Basic Pagination -->
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Request Stock Modal --}}
<div class="modal fade" id="requestStockModal" tabindex="-1" aria-labelledby="requestStockModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="requestStockModalLabel">Buat Permintaan Barang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          @csrf
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Barang</label>
            <select name="product_id" id="exampleFormControlInput1" class="form-select">
              <option value="1">Roti Tawar</option>
              <option value="2">Roti Tawar</option>
              <option value="3">Roti Tawar</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Masukan Jumlah">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Ajukan</button>
      </div>
    </div>
  </div>
</div>
@endsection