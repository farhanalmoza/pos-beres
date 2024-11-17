@extends('member.components.layout')
@section('title', 'Ganti Password')

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
          <h5 class="mb-0">Form Ganti Password</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('member.setting.update-password') }}">
            @csrf
            <div class="row mb-3">
              <label class="col-sm-3 col-form-label" for="old_password">Password Lama</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" id="old_password" name="old_password">
                @error('old_password')
                  <div class="form-text text-danger">
                    {{ $message }}
                  </div>
                @enderror
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