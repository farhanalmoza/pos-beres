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
                              Request::routeIs('admin.product.edit') ||
                              Request::routeIs('admin.product-in.index') ||
                              Request::routeIs('admin.product-in.create') ||
                              Request::routeIs('admin.product-in.edit') ? 'active open' : '' }}">
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
          <li class="menu-item {{ Request::routeIs('admin.product-in.index') ||
                                  Request::routeIs('admin.product-in.create') ||
                                  Request::routeIs('admin.product-in.edit') ? 'active' : '' }}">
            <a href="{{ route('admin.product-in.index') }}" class="menu-link">
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
                              Request::routeIs('admin.werehouse.index') ||
                              Request::routeIs('admin.werehouse.create') ||
                              Request::routeIs('admin.werehouse.edit') ? 'active open' : '' }}">
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
          <li class="menu-item {{ Request::routeIs('admin.werehouse.index') ||
                                  Request::routeIs('admin.werehouse.create') ||
                                  Request::routeIs('admin.werehouse.edit')  ? 'active' : '' }}">
            <a href="{{ route('admin.werehouse.index') }}" class="menu-link">
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
      
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Profile</span></li>
      <li class="menu-item {{ Request::routeIs('profile.edit-password') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div>Pengaturan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="auth-login-basic.html" class="menu-link">
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
  </aside>