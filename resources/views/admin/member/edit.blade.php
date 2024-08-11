@extends('components.layout')
@section('title', 'Admin | Edit Toko')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Member</h5>
        </div>
        <div class="card-body">
          <form method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" value="Stephany Edward">
              </div>
            </div>
            <div class="row">
              <div class="row mb-3 col-md-7">
                <label class="col-md-3 me-5 col-form-label" for="basic-default-name">Tempat Lahir</label>
                <div class="col-md-8 px-0">
                  <input type="text" class="form-control" id="basic-default-name" value="Banjarmasin">
                </div>
              </div>
              <div class="mb-3 row col-md-5">
                <label for="html5-date-input" class="col-md-4 col-form-label">Tanggal Lahir</label>
                <div class="col-md-8">
                  <input class="form-control" type="date" value="2000-06-18" id="html5-date-input">
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="row col-7">
                <label for="html5-date-input" class="col-sm-3 col-form-label me-5">Jenis Kelamin</label>
                <div class="col-sm-8 px-0">
                  <select id="defaultSelect" class="form-select" value="2">
                    <option>Pilih Jenis Kelamin</option>
                    <option value="1">Laki-Laki</option>
                    <option value="2">Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="row col-5">
                <label for="defaultSelect" class="col-form-label col-md-4">Golongan Darah</label>
                <div class="col-sm-8">
                  <select id="defaultSelect" class="form-select" value="2">
                    <option>Pilih Golongan Darah</option>
                    <option value="1">A</option>
                    <option value="2">B</option>
                    <option value="3">AB</option>
                    <option value="4">O</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nomer Telp</label>
              <div class="col-sm-10">
                <div class="input-group">
                  <span class="input-group-text" id="basic-addon11">+62</span>
                  <input class="form-control" type="tel" value="865438867644" id="html5-tel-input">
                </div>
              </div>
            </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-message">Alamat</label>
                <div class="col-sm-10">
                  <textarea id="basic-default-message" class="form-control">Jln. Bubrasaman No.25 RT.21</textarea>
                </div>
              </div>
              <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Agama</label>
              <div class="col-sm-10">
                <select id="defaultSelect" class="form-select" value="islam">
                  <option>Pilih Agama</option>
                  <option value="islam">Islam</option>
                  <option value="kristen">Kristen</option>
                  <option value="katolik">Katolik</option>
                  <option value="hindu">Hindu</option>
                  <option value="buddha">Buddha</option>
                  <option value="konghucu">Konghucu</option>
                  <option value="lainya">Lainya</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Pekerjaan</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" value="Penulis">
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
  $(document).ready(function() {
    $('#harga-jual').on('input', function() {
      let inputVal = $(this).val();
      
      // Hapus karakter non-digit
      inputVal = inputVal.replace(/[^,\d]/g, '');
      
      // Format nilai sebagai mata uang
      let formattedInput = formatCurrency(inputVal);
      
      // Tampilkan nilai yang telah diformat
      $(this).val(formattedInput);
    });

    function formatCurrency(value) {
      // Konversi ke angka dan tambahkan titik ribuan
      return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
  });
</script>
@endsection