@extends('member.components.layout')
@section('title', 'Member | Edit Profile')

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
          <h5 class="mb-0">Form Ubah No Telepon</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('profile.update-no-telepon') }}" autocomplete="off">
            @csrf
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">NIK</label>
                <input type="text" class="form-control" value="{{ $member->nik }}" disabled>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">WhatsApp</label>
                <div class="input-group">
                  <span class="input-group-text">+62</span>
                  <input type="text" class="form-control" value="{{ $member->phone }}" disabled>
                </div>
              </div>
            </div>

            {{-- <button type="submit" class="btn btn-primary">Simpan</button> --}}
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection