<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-text demo menu-text fw-bold ms-2">Logo</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    @if (Auth()->user()->role == 'admin')
    <ul class="menu-inner py-1">
      <li class="menu-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div>Dashboard</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Manajemen</span></li>
      <li class="menu-item {{ Request::routeIs('admin.supplier.index') ? 'active' : '' }}">
        <a href="{{ route('admin.supplier.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Supplier</div>
        </a>
      </li>

      <li class="menu-item {{ Request::routeIs('admin.product-category.index') ||
                              Request::routeIs('admin.product.index') ||
                              Request::routeIs('admin.product.create') ||
                              Request::routeIs('admin.product.edit') ||
                              Request::routeIs('admin.product-in.index') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cabinet"></i>
          <div>Barang</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('admin.product-category.index') ? 'active' : '' }}">
            <a href="{{ route('admin.product-category.index') }}" class="menu-link">
              <div data-i18n="Basic">Kategori Barang</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.product.index') ||
                                  Request::routeIs('admin.product.create') ||
                                  Request::routeIs('admin.product.edit') ? 'active' : '' }}">
            <a href="{{ route('admin.product.index') }}" class="menu-link">
              <div data-i18n="Basic">Daftar Barang</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.product-in.index') ? 'active' : '' }}">
            <a href="{{ route('admin.product-in.index') }}" class="menu-link">
              <div data-i18n="Basic">Barang Masuk</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item {{ Request::routeIs('admin.product-out.list') ||
                              Request::routeIs('admin.product-out.request') ||
                              Request::routeIs('admin.product-out.send-form') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class='menu-icon bx bx-package'></i>
          <div>Barang Keluar</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('admin.product-out.list') ? 'active' : '' }}">
            <a href="{{ route('admin.product-out.list') }}" class="menu-link">
              <div data-i18n="Basic">Daftar Barang Keluar</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.product-out.request') ? 'active' : '' }}">
            <a href="{{ route('admin.product-out.request') }}" class="menu-link">
              <div data-i18n="Basic">Permintaan Barang</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.product-out.send-form') ? 'active' : '' }}">
            <a href="{{ route('admin.product-out.send-form') }}" class="menu-link">
              <div data-i18n="Basic">Kirim Barang</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item {{ Request::routeIs('admin.store.index') ||
                              Request::routeIs('admin.store.create') ||
                              Request::routeIs('admin.store.edit') ? 'active' : '' }}">
        <a href="{{ route('admin.store.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Toko</div>
        </a>
      </li>

      <li class="menu-item {{ Request::routeIs('admin.member.index')||
                              Request::routeIs('admin.member.create') ||
                              Request::routeIs('admin.member.edit') ||
                              Request::routeIs('admin.cashier.index')||
                              Request::routeIs('admin.cashier.create') ||
                              Request::routeIs('admin.cashier.edit') ||
                              Request::routeIs('admin.warehouse.index') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div>Pengguna</div>
        </a>
        <ul class="menu-sub">
          {{-- <li class="menu-item">
            <a href="auth-login-basic.html" class="menu-link">
              <div data-i18n="Basic">Admin</div>
            </a>
          </li> --}}
          <li class="menu-item {{ Request::routeIs('admin.warehouse.index')  ? 'active' : '' }}">
            <a href="{{ route('admin.warehouse.index') }}" class="menu-link">
              <div data-i18n="Basic">Gudang</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.cashier.index') ||
                                  Request::routeIs('admin.cashier.create') ||
                                  Request::routeIs('admin.cashier.edit')  ? 'active' : '' }}">
            <a href="{{ route('admin.cashier.index') }}" class="menu-link">
              <div data-i18n="Basic">Kasir</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('admin.member.index') ||
                                  Request::routeIs('admin.member.create') ||
                                  Request::routeIs('admin.member.edit') ? 'active' : '' }}">
            <a href="{{ route('admin.member.index') }}" class="menu-link">
              <div data-i18n="Basic">Member</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item {{ Request::routeIs('admin.tax.index') ? 'active' : '' }}">
        <a href="{{ route('admin.tax.index') }}" class="menu-link">
          <i class='menu-icon bx bx-pie-chart-alt'></i>
          <div>Pajak</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan</span></li>
      <li class="menu-item {{ Request::routeIs('admin.warehouse.report.purchase.index') ? 'active' : '' }}">
        <a href="{{ route('admin.warehouse.report.purchase.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Pembelian</div>
        </a>
      </li>
      <li class="menu-item {{ Request::routeIs('admin.warehouse.report.delivery.index') ? 'active' : '' }}">
        <a href="{{ route('admin.warehouse.report.delivery.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Pengiriman</div>
        </a>
      </li>
      
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>
      <li class="menu-item {{ Request::routeIs('profile.edit-password') ||
                              Request::routeIs('profile.edit-profile') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div>Pengaturan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('profile.edit-profile') ? 'active' : '' }}">
            <a href="{{ route('profile.edit-profile') }}" class="menu-link">
              <div data-i18n="Basic">Edit Profile</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('profile.edit-password') ? 'active' : '' }}">
            <a href="{{ route('profile.edit-password') }}" class="menu-link">
              <div data-i18n="Basic">Ganti Password</div>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    @endif

    @if (Auth()->user()->role == 'warehouse')
    <ul class="menu-inner py-1">
      <li class="menu-item {{ Request::routeIs('warehouse.dashboard') ? 'active' : '' }}">
        <a href="{{ route('warehouse.dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div>Dashboard</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Manajemen</span></li>
      <li class="menu-item {{ Request::routeIs('warehouse.supplier.index') ? 'active' : '' }}">
        <a href="{{ route('warehouse.supplier.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Supplier</div>
        </a>
      </li>

      <li class="menu-item {{ Request::routeIs('warehouse.product-category.index') ||
                              Request::routeIs('warehouse.product.index') ||
                              Request::routeIs('warehouse.product-in.index') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cabinet"></i>
          <div>Barang</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('warehouse.product-category.index') ? 'active' : '' }}">
            <a href="{{ route('warehouse.product-category.index') }}" class="menu-link">
              <div data-i18n="Basic">Kategori Barang</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('warehouse.product.index') ||
                                  Request::routeIs('warehouse.product.create') ||
                                  Request::routeIs('warehouse.product.edit') ? 'active' : '' }}">
            <a href="{{ route('warehouse.product.index') }}" class="menu-link">
              <div data-i18n="Basic">Daftar Barang</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('warehouse.product-in.index') ? 'active' : '' }}">
            <a href="{{ route('warehouse.product-in.index') }}" class="menu-link">
              <div data-i18n="Basic">Barang Masuk</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item {{ Request::routeIs('warehouse.product-out.list') ||
                              Request::routeIs('warehouse.product-out.request') ||
                              Request::routeIs('warehouse.product-out.send-form') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class='menu-icon bx bx-package'></i>
          <div>Barang Keluar</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('warehouse.product-out.list') ? 'active' : '' }}">
            <a href="{{ route('warehouse.product-out.list') }}" class="menu-link">
              <div data-i18n="Basic">Daftar Barang Keluar</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('warehouse.product-out.request') ? 'active' : '' }}">
            <a href="{{ route('warehouse.product-out.request') }}" class="menu-link">
              <div data-i18n="Basic">Permintaan Barang</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('warehouse.product-out.send-form') ? 'active' : '' }}">
            <a href="{{ route('warehouse.product-out.send-form') }}" class="menu-link">
              <div data-i18n="Basic">Kirim Barang</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item {{ Request::routeIs('warehouse.store.index') ? 'active' : '' }}">
        <a href="{{ route('warehouse.store.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Toko</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan</span></li>
      <li class="menu-item {{ Request::routeIs('warehouse.report.purchase.index') ? 'active' : '' }}">
        <a href="{{ route('warehouse.report.purchase.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Pembelian</div>
        </a>
      </li>
      <li class="menu-item {{ Request::routeIs('warehouse.report.delivery.index') ? 'active' : '' }}">
        <a href="{{ route('warehouse.report.delivery.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Pengiriman</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>
      <li class="menu-item {{ Request::routeIs('profile.edit-password') ||
                              Request::routeIs('profile.edit-profile') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div>Pengaturan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('profile.edit-profile') ? 'active' : '' }}">
            <a href="{{ route('profile.edit-profile') }}" class="menu-link">
              <div data-i18n="Basic">Edit Profile</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('profile.edit-password') ? 'active' : '' }}">
            <a href="{{ route('profile.edit-password') }}" class="menu-link">
              <div data-i18n="Basic">Ganti Password</div>
            </a>
          </li>
        </ul>
      </li>
    </ul>
        
    @endif

    @if (Auth()->user()->role == 'cashier')
    <ul class="menu-inner py-1">
      <li class="menu-item {{ Request::routeIs('cashier.dashboard') ? 'active' : '' }}">
        <a href="{{ route('cashier.dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div>Dashboard</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Transaksi</span></li>
      <li class="menu-item {{ Request::routeIs('cashier.transaction.add') ? 'active' : '' }}">
        <a href="{{ route('cashier.transaction.add') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cart-add"></i>
          <div>Tambah Transaksi</div>
        </a>
      </li>
      <li class="menu-item {{ Request::routeIs('cashier.transaction.list') ? 'active' : '' }}">
        <a href="{{ route('cashier.transaction.list') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-spreadsheet"></i>
          <div>Daftar Transaksi</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Manajemen</span></li>
      <li class="menu-item {{ Request::routeIs('cashier.product.index') ? 'active' : '' }}">
        <a href="{{ route('cashier.product.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cabinet"></i>
          <div>Stok Barang</div>
        </a>
      </li>
      <li class="menu-item {{ Request::routeIs('cashier.product.warehouse-product') ? 'active' : '' }}">
        <a href="{{ route('cashier.product.warehouse-product') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cabinet"></i>
          <div>Barang di Gudang</div>
        </a>
      </li>
      <li class="menu-item {{ Request::routeIs('cashier.product-request.index') ||
                              Request::routeIs('cashier.product-request.history') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-box"></i>
          <div>Permintaan Barang</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('cashier.product-request.history') ? 'active' : '' }}"> 
            <a href="{{ route('cashier.product-request.history') }}" class="menu-link">
              <div data-i18n="Basic">Riwayat Permintaan</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('cashier.product-request.index') ? 'active' : '' }}">
            <a href="{{ route('cashier.product-request.index') }}" class="menu-link">
              <div data-i18n="Basic">Buat Permintaan</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Laporan</span></li>
      <li class="menu-item {{ Request::routeIs('cashier.report.sale.index') ? 'active' : '' }}">
        <a href="{{ route('cashier.report.sale.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-bar-chart-alt-2"></i>
          <div>Penjualan</div>
        </a>
      </li>
      <li class="menu-item {{ Request::routeIs('cashier.report.purchase.index') ? 'active' : '' }}">
        <a href="{{ route('cashier.report.purchase.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bxs-bar-chart-alt-2"></i>
          <div>Pembelian</div>
        </a>
      </li>

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>
      <li class="menu-item {{ Request::routeIs('profile.edit-password') ||
                              Request::routeIs('profile.edit-profile') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div>Pengaturan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('profile.edit-profile') ? 'active' : '' }}">
            <a href="{{ route('profile.edit-profile') }}" class="menu-link">
              <div data-i18n="Basic">Edit Profile</div>
            </a>
          </li>
          <li class="menu-item {{ Request::routeIs('profile.edit-password') ? 'active' : '' }}">
            <a href="{{ route('profile.edit-password') }}" class="menu-link">
              <div data-i18n="Basic">Ganti Password</div>
            </a>
          </li>
        </ul>
      </li>
    </ul>  
    @endif
    
  </aside>