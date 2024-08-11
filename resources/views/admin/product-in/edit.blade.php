@extends('components.layout')
@section('title', 'Admin | Edit Barang Masuk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Edit Barang Masuk</h5>
        </div>
        <div class="card-body">
          <form method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label" for="basic-default-fullname">Pilih Barang</label>
              <select id="defaultSelect" class="form-select">
                <option value="1">Kode barang - Nama barang 1</option>
                <option value="2" selected>Kode barang - Nama barang 2</option>
                <option value="3">Kode barang - Nama barang 3</option>
              </select>
            </div>
            <div class="row mb-3">
              <div class="col-md-4">
                <label class="form-label" for="basic-default-fullname">Jumlah Barang</label>
                <input type="text" class="form-control" id="basic-default-fullname" value="50">
              </div>
              <div class="col-md-4">
                <label class="form-label" for="basic-default-fullname">Harga Beli</label>
                <input type="text" class="form-control" id="basic-default-fullname" value="10.000">
              </div>
              <div class="col-md-4">
                <label class="form-label" for="basic-default-fullname">Total</label>
                <input type="text" class="form-control" id="basic-default-fullname" readonly value="500.000">
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