@extends('components.layout')
@section('title', 'Gudang | Barang Keluar')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-3">
        <h5 class="card-header">Kirim Barang ke Toko</h5>
        <div class="card-body">
          <form method="POST">
            @csrf
            <div class="row mb-3">
              <div class="col-md-5">
                <label for="exampleFormControlInput1" class="form-label">Toko</label>
                <input class="form-control" list="stores" id="exampleDataList" placeholder="Pilih toko...">
                <datalist id="stores">
                  <option value="Toko 01"></option>
                  <option value="Toko 02"></option>
                  <option value="Toko 03"></option>
                  <option value="Toko 04"></option>
                </datalist>
              </div>
              <div class="col-md-7">
                <label for="exampleFormControlInput1" class="form-label">Barang</label>
                <input class="form-control" list="products" id="exampleDataList" placeholder="Pilih barang...">
                <datalist id="products">
                  <option value="Kode 01 - Barang 01"></option>
                  <option value="Kode 02 - Barang 02"></option>
                  <option value="Kode 03 - Barang 03"></option>
                  <option value="Kode 04 - Barang 04"></option>
                  <option value="Kode 05 - Barang 05"></option>
                  <option value="Kode 06 - Barang 06"></option>
                </datalist>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-5">
                <label for="exampleFormControlInput1" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Masukan jumlah">
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Kirim</button>
          </form>
        </div>
      </div>

      <div class="card">
        <h5 class="card-header">Daftar Barang Keluar</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr class="text-nowrap">
                <th>Tanggal</th>
                <th>Toko</th>
                <th>Barang</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr>
                <th>2022-01-01</th>
                <td>Toko 235</td>
                <td>Kode 01 - Roti Tawar</td>
                <td>500</td>
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
<div class="modal fade" id="addProductInModal" tabindex="-1" aria-labelledby="addProductInModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductInModalLabel">Tambah Barang Masuk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          @csrf
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Barang</label>
            <select id="defaultSelect" class="form-select">
              <option>Pilih barang</option>
              <option value="1">Kode 01 - Barang 01</option>
              <option value="2">Kode 02 - Barang 02</option>
              <option value="3">Kode 03 - Barang 03</option>
              <option value="4">Kode 04 - Barang 04</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Harga Barang</label>
            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Masukan harga">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="exampleFormControlInput1" placeholder="Masukan jumlah">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>
@endsection