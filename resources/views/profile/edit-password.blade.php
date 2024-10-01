@extends('components.layout')
@section('title', 'Ubah Password')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  @if (session('status'))
    <div class="alert alert-success" role="alert">
      {{ session('status') }}
    </div>
  @endif

  <div class="row">
    <div class="col-md-12">
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Form Ubah Password</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.update-password') }}">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="old_password">Password Lama</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="old_password" name="old_password">
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="password">Password Baru</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="password" name="password">
                @error('password')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="password_confirmation">Konfirmasi Password Baru</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
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