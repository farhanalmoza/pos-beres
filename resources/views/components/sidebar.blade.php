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

    <ul class="menu-inner py-1">
      <li class="menu-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <a href="{{ route('admin.dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home"></i>
          <div>Dashboard</div>
        </a>
      </li>

      <li class="menu-item {{ Request::routeIs('admin.product-category.index') ||
                              Request::routeIs('admin.product.index') ||
                              Request::routeIs('admin.product.create') ||
                              Request::routeIs('admin.product.edit') ? 'active open' : '' }}">
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
          <li class="menu-item">
            <a href="auth-forgot-password-basic.html" class="menu-link">
              <div data-i18n="Basic">Barang Masuk</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="auth-forgot-password-basic.html" class="menu-link">
              <div data-i18n="Basic">Barang Keluar</div>
            </a>
          </li>
        </ul>
      </li>

      <li class="menu-item">
        <a href="" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Toko</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-group"></i>
          <div>Pengguna</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="auth-login-basic.html" class="menu-link">
              <div data-i18n="Basic">Admin</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="auth-register-basic.html" class="menu-link">
              <div data-i18n="Basic">Gudang</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="auth-forgot-password-basic.html" class="menu-link">
              <div data-i18n="Basic">Kasir</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="auth-forgot-password-basic.html" class="menu-link">
              <div data-i18n="Basic">Member</div>
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </aside>