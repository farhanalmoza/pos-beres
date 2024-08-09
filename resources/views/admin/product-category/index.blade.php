@extends('components.layout')
@section('title', 'Admin | Daftar Kategori Barang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-md-7">
      <div class="card">
        <h5 class="card-header">Daftar Kategori Barang</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead>
              <tr class="text-nowrap">
                <th>No.</th>
                <th>Kategori Barang</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <tr>
                <th scope="row">1</th>
                <td>Kategori 1</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">Ubah</button>
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                </td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Kategori 2</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">Ubah</button>
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                </td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Kategori 3</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">Ubah</button>
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                </td>
              </tr>
              <tr>
                <th scope="row">4</th>
                <td>Kategori 4</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">Ubah</button>
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                </td>
              </tr>
              <tr>
                <th scope="row">5</th>
                <td>Kategori 5</td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal">Ubah</button>
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="demo-inline-spacing px-4">
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

    <div class="col-md-5">
      <div class="card">
        <h5 class="card-header">Tambah Kategori Barang</h5>
        <div class="card-body">
          <form method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">Kategori Barang</label>
              <input type="text" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
          </form>
        </div>
      </div>
    </div>

  </div>


  {{-- Edit Modal --}}
  <div class="modal fade" id="editModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Kategori Modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kategori Barang</label>
              <input type="text" id="nameBasic" class="form-control">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="button" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>

  {{-- Delete Modal --}}
  <div class="modal fade" id="deleteModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Hapus Kategori Barang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Apakah Anda yaking ingin menghapus kategori barang ini?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="button" class="btn btn-danger">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection