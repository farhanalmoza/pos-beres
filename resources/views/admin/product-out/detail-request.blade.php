@extends('components.layout')
@section('title', 'Admin | Detail Permintaan Barang')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/datatable-bs4.css') }}">
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  {{-- if session success --}}
  @if (session()->has('success'))
  <div class="alert alert-success alert-dismissible" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif
  {{-- if session error --}}
  @if (session()->has('error'))
  <div class="alert alert-danger alert-dismissible" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  @endif

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <div class="">
            <h5 class="mb-0">Permrintaan dari {{ $productRequest->store->name }}</h5>
            <div class="d-flex">
              <span class="badge bg-primary" style="margin-right: 5px">{{ $productRequest->request_number }}</span>
              @if ($productRequest->status == 'requested')
                <span class="badge bg-success">Diajukan</span>
              @elseif ($productRequest->status == 'done')
                <span class="badge bg-primary">Selesai</span>
              @elseif ($productRequest->status == 'customized')
                <span class="badge bg-warning">Disesuaikan</span>
              @endif
            </div>
          </div>
          <div class="">
            <a href="{{ route('admin.product-out.request') }}" class="btn btn-secondary">
              Kembali
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive text-nowrap">
            <table class="table">
              <thead>
                <tr class="text-nowrap">
                  <th style="width: 5%;">No</th>
                  <th>Kode Barang</th>
                  <th>Nama Barang</th>
                  <th>Jumlah</th>
                </tr>
              </thead>
              <tbody class="table-border-bottom-0">
                @foreach ($items as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->product->code }}</td>
                    <td>{{ $item->product->name }}</td>
                    <td style="direction: rtl">{{ $item->quantity }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          
          @if ($productRequest->status == 'requested')
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateStatusRequestModal">
            Ubah Status
          </button>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- Update Status Request Modal --}}
  <div class="modal fade" id="updateStatusRequestModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form autocomplete="off" method="POST" action="{{ route('admin.product-out.update-status') }}">
          @csrf
          <input type="hidden" name="request_number" id="request_number" value="{{ $productRequest->request_number }}">
          <div class="modal-body">
            <div class="form-group">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="done">Selesai</option>
                <option value="customized">Disesuaikan</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Batal
            </button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  const URL_Role = "{{ url('/admin') }}"
</script>
{{-- Data Table --}}
<script src="{{ asset('js/jquery-datatables.js') }}"></script>
<script src="{{ asset('js/datatable-bs4.js') }}"></script>

<script src="{{ asset('/js/warehouse/product-out/request.js') }}"></script>
@endsection