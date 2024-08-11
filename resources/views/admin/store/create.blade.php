@extends('components.layout')
@section('title', 'Admin | Buat Toko Baru')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Buat Toko Baru</h5>
        </div>
        <div class="card-body">
          <form method="POST">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Toko</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-2 col-form-label" for="basic-default-message">Alamat Toko</label>
              <div class="col-sm-10">
                <textarea id="basic-default-message" class="form-control"></textarea>
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