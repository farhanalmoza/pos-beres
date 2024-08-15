@extends('components.layout')
@section('title', 'Admin | Buat Akun Gudang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Buat Akun Gudang</h5>
        </div>
        <div class="card-body">
          <form method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" placeholder="Masukan Nama">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nomor Telp</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon11">+62</span>
                  <input class="form-control" type="tel" value="" id="html5-tel-input" placeholder="Masukan Nomor Telepon">
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="basic-default-name" placeholder="Masukan Email">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-message">Alamat</label>
              <div class="col-sm-10">
                <textarea id="basic-default-message" class="form-control" placeholder="Masukan Alamat"></textarea>
              </div>
            </div>
            <div class="row">
              <div class="row mb-3 col-md-6">
                <label class="col-md-4 col-form-label" for="basic-default-name">Password</label>
                <div class="col-md-8">
                  <input type="password" class="form-control" id="basic-default-name">
                </div>
              </div>
              <div class="row mb-3 col-md-6">
                <label class="col-md-4 col-form-label" for="basic-default-name">Konfirmasi Password</label>
                <div class="col-md-8">
                  <input type="password" class="form-control" id="basic-default-name">
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>

</script>
@endsection