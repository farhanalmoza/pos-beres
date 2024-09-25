@extends('components.layout')
@section('title', 'Admin | Detail Toko')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">

    <div class="col-md-12">
      <div class="nav-align-top mb-4">
        <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-home" aria-controls="navs-pills-justified-home" aria-selected="true">
              <i class="tf-icons bx bx-home me-1"></i><span class="d-none d-sm-block"> Stok</span>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-profile" aria-controls="navs-pills-justified-profile" aria-selected="false" tabindex="-1">
              <i class="tf-icons bx bx-user me-1"></i><span class="d-none d-sm-block"> Penjualan</span>
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-justified-messages" aria-controls="navs-pills-justified-messages" aria-selected="false" tabindex="-1">
              <i class="tf-icons bx bx-message-square me-1"></i><span class="d-none d-sm-block"> Pemasukan</span>
            </button>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade active show" id="navs-pills-justified-home" role="tabpanel">
            <p>
              Icing pastry pudding oat cake. Lemon drops cotton candy caramels cake caramels sesame snaps
              powder. Bear claw candy topping.
            </p>
            <p class="mb-0">
              Tootsie roll fruitcake cookie. Dessert topping pie. Jujubes wafer carrot cake jelly. Bonbon
              jelly-o jelly-o ice cream jelly beans candy canes cake bonbon. Cookie jelly beans marshmallow
              jujubes sweet.
            </p>
          </div>
          <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
            <p>
              Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice
              cream. Gummies halvah tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream
              cheesecake fruitcake.
            </p>
            <p class="mb-0">
              Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah
              cotton candy liquorice caramels.
            </p>
          </div>
          <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
            <p>
              Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies
              cupcake gummi bears cake chocolate.
            </p>
            <p class="mb-0">
              Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet
              roll icing sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly
              jelly-o tart brownie jelly.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')

@endsection