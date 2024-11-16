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

      <li class="menu-header small text-uppercase"><span class="menu-header-text">Manajemen</span></li>
      <li class="menu-item {{ Request::routeIs('admin.supplier.index') ? 'active' : '' }}">
        <a href="{{ route('admin.supplier.index') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-store-alt"></i>
          <div>Supplier</div>
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
    
  </aside>