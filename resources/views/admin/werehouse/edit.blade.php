@extends('components.layout')
@section('title', 'Admin | Edit Akun Gudang')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Akun Gudang</h5>
        </div>
        <div class="card-body">
          <form method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" value="Jhon Doe">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nomor Telp</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon11">+62</span>
                  <input class="form-control" type="tel" value="81234567890" id="html5-tel-input" placeholder="Masukan Nomor Telepon">
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Email</label>
              <div class="col-sm-10">
                <input type="email" class="form-control" id="basic-default-name" value="jhondoe@mail.com">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-message">Alamat</label>
              <div class="col-sm-10">
                <textarea id="basic-default-message" class="form-control" placeholder="Masukan Alamat">Jl. Jamblang Kec. Jamblang Cirebon</textarea>
              </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Reset Password</h5>
        </div>
        <div class="card-body">
          <form method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Password Baru</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" placeholder="Masukkan password baru">
              </div>
            </div>
            <button type="submit" class="btn btn-danger">Reset Password</button>
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