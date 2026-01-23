<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    {{-- Profile --}}
    <li class="nav-item">
      <div class="d-flex sidebar-profile">
        <div class="sidebar-profile-image">
          <img src="{{ $loggedInUser && $loggedInUser->profile_picture ? asset('storage/profile-picture/' . $loggedInUser->profile_picture) : asset('assets/images/user-icon.png') }}" alt="image">
          <span class="sidebar-status-indicator"></span>
        </div>
        <div class="sidebar-profile-name">
          <p class="sidebar-name">{{ $loggedInUser->first_name }}</p>
          <p class="sidebar-designation">Admin</p>
        </div>
      </div>
    </li>

    {{-- Dashboard --}}
    <li class="nav-item {{ request()->route()->named('admin.dashboard') ? 'active-nav' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fa fa-desktop menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    {{-- Point of Sale --}}
    <li class="nav-item {{ request()->route()->named('admin.pos.index') ? 'active-nav' : '' }}">
      <a class="nav-link" href="{{ route('admin.pos.index') }}">
        <i class="fa fa-shopping-cart menu-icon"></i>
        <span class="menu-title">Point of Sale</span>
      </a>
    </li>

    {{-- Orders --}}
    <li class="nav-item {{ Request::is('admin/order*') || request()->route()->named('admin.orders.index') ? 'active-nav' : '' }}">
      <a class="nav-link" href="{{ route('admin.orders.index') }}">
        <i class="fa fa-file menu-icon"></i>
        <span class="menu-title">Orders</span>
      </a>
    </li>

    @if ($loggedInUser->role == "global_admin")

    {{-- Catalog --}}
    <li class="nav-item {{ request()->route()->named('admin.products.list') || request()->route()->named('admin.categories.index') ? 'active-nav' : '' }}">
      <a class="nav-link collapsed" data-toggle="collapse" href="#catalog-menu">
        <i class="fa fa-tags menu-icon"></i>
        <span class="menu-title">Catalog</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->route()->named('admin.products.list') || request()->route()->named('admin.categories.index') ? 'show' : '' }}" id="catalog-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.products.list') }}">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.categories.index') }}">Categories</a>
          </li>
        </ul>
      </div>
    </li>

    {{-- Content --}}
    <li class="nav-item {{ request()->route()->named('admin.terms.edit') || request()->route()->named('admin.privacy-policy.edit') ? 'active-nav' : '' }}">
      <a class="nav-link collapsed" data-toggle="collapse" href="#content-menu">
        <i class="fa fa-file-alt menu-icon"></i>
        <span class="menu-title">Content</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="content-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.terms.edit') }}">Terms &amp; Conditions</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.privacy-policy.edit') }}">Privacy Policy</a>
          </li>
        </ul>
      </div>
    </li>

    {{-- Administration --}}
    <li class="nav-item {{ request()->route()->named('admin.users.index') ? 'active-nav' : '' }}">
      <a class="nav-link" href="{{ route('admin.users.index') }}">
        <i class="fa fa-users menu-icon"></i>
        <span class="menu-title">Admin Users</span>
      </a>
    </li>

    {{-- Settings --}}
    <li class="nav-item {{ request()->route()->named('admin.contact-settings') || request()->route()->named('admin.order-settings') || request()->route()->named('admin.business-settings') ? 'active-nav' : '' }}">
      <a class="nav-link collapsed" data-toggle="collapse" href="#settings-menu">
        <i class="fa fa-cog menu-icon"></i>
        <span class="menu-title">Settings</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ request()->route()->named('admin.contact-settings') || request()->route()->named('admin.order-settings') || request()->route()->named('admin.business-settings') ? 'show' : '' }}" id="settings-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link {{ request()->route()->named('admin.contact-settings') ? 'active-nav' : '' }}" href="{{ route('admin.contact-settings') }}">
              Contact Settings
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->route()->named('admin.order-settings') ? 'active-nav' : '' }}" href="{{ route('admin.order-settings') }}">
              Order Settings
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->route()->named('admin.business-settings') ? 'active-nav' : '' }}" href="{{ route('admin.business-settings') }}">
              Business Settings
            </a>
          </li>
        </ul>
      </div>
    </li>

    @endif

    {{-- Account --}}
    <li class="nav-item {{ request()->route()->named('admin.view.myprofile') || request()->route()->named('change.password.form') ? 'active-nav' : '' }}">
      <a class="nav-link collapsed" data-toggle="collapse" href="#account-menu">
        <i class="fa fa-user-circle menu-icon"></i>
        <span class="menu-title">Account</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="account-menu">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.view.myprofile') }}">My Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('change.password.form') }}">Change Password</a>
          </li>
        </ul>
      </div>
    </li>

    {{-- Main Website --}}
    <li class="nav-item">
      <a target="_blank" class="nav-link" href="{{ route('home') }}">
        <i class="fa fa-globe menu-icon"></i>
        <span class="menu-title">Main Website</span>
      </a>
    </li>

    {{-- Logout --}}
    <li class="nav-item">
      <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
        <i class="fa fa-power-off menu-icon"></i>
        <span class="menu-title">Logout</span>
      </a>
    </li>
  </ul>
</nav>
