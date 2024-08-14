@extends('components.layout')
@section('title', 'Admin | Edit Kasir')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Kasir</h5>
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
              <label class="col-sm-2 col-form-label" for="basic-default-name">Pilih Toko</label>
              <div class="col-sm-10">
                <select id="defaultSelect" class="form-select">
                  <option value="1">Toko 1</option>
                  <option value="2">Toko 2</option>
                  <option value="3" selected>Toko 3</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nomer Telp</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon11">+62</span>
                  <input class="form-control" type="tel" value="81234567890" id="html5-tel-input" placeholder="Masukan Nomor Telepon">
                </div>
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
  </div>
</div>
@endsection

@section('js')
<script>

</script>
@endsection