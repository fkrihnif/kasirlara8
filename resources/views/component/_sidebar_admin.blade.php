
    <div class="sidebar" data-color="orange">
        <!--
        Tip 1: You can change the color of the fdebar using: data-color="blue | green | orange | red | yellow"
        -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          
        </a>
        <a href="{{ route('home') }}" class="simple-text logo-normal">
          {{ App\Models\Company::take(1)->first()->name }}
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="nav-item {{ request()->is('admin/dashboard') ?'active' : '' }}">
            <a href="{{ route('admin.dashboard.index') }}">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/admin') ?'active' : '' }}">
            <a href="{{ route('admin.admin.index') }}">
              <i class="now-ui-icons sport_user-run"></i>
              <p>Akun Admin</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/cashier') ?'active' : '' }}">
            <a href="{{ route('admin.cashier.index') }}">
              <i class="now-ui-icons users_single-02"></i>
              <p>Akun Kasir</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/category') ?'active' : '' }}">
            <a href="{{ route('admin.category.index') }}">
              <i class="now-ui-icons design_app"></i>
              <p>Kategori Produk</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/product') ?'active' : '' }}">
            <a href="{{ route('admin.product.index') }}">
              <i class="now-ui-icons design_palette"></i>
              <p>Produk</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/supply') ?'active' : '' }}">
            <a href="{{ route('admin.supply.index') }}">
              <i class="now-ui-icons health_ambulance"></i>
              <p>Kelola Pasok</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/transaction') ?'active' : '' }}">
            <a href="{{ route('admin.transaction.index') }}">
              <i class="now-ui-icons shopping_cart-simple"></i>
              <p>Transaksi</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/report') ?'active' : '' }}">
            <a href="{{ route('admin.report.index') }}">
              <i class="now-ui-icons education_paper"></i>
              <p>Laporan</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/setting') ?'active' : '' }}">
            <a href="{{ route('admin.setting.index') }}">
              <i class="now-ui-icons ui-1_settings-gear-63"></i>
              <p>Pengaturan</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('admin/profile') ?'active' : '' }}">
            <a href="{{ route('admin.profile.index') }}">
              <i class="now-ui-icons business_badge"></i>
              <p>Akun Saya</p>
            </a>
          </li>
        </ul>
      </div>
    </div>