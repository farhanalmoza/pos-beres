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
      <li class="menu-item {{ Request::routeIs('member.product.index') ? 'active' : '' }}">
        <a href="{{ route('member.product.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-cabinet"></i>
          <div>Produk</div>
        </a>
      </li>
      
      <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>
      <li class="menu-item {{ Request::routeIs('member.setting.change-password') ? 'active open' : '' }}">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-cog"></i>
          <div>Pengaturan</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item {{ Request::routeIs('member.setting.change-password') ? 'active' : '' }}">
            <a href="{{ route('member.setting.change-password') }}" class="menu-link">
              <div data-i18n="Basic">Ganti Password</div>
            </a>
          </li>
        </ul>
      </li>
    </ul>
    
  </aside>