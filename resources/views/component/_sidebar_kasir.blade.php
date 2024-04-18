
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
          <li class="nav-item {{ request()->is('kasir/dashboard') ?'active' : '' }}">
            <a href="{{ route('kasir.dashboard.index') }}">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('kasir/product') ?'active' : '' }}">
            <a href="{{ route('kasir.product.index') }}">
              <i class="now-ui-icons shopping_box"></i>
              <p>Produk</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('kasir/transaction') ?'active' : '' }}">
            <a href="{{ route('kasir.transaction.index') }}">
              <i class="now-ui-icons shopping_cart-simple"></i>
              <p>Transaksi</p>
            </a>
          </li>
          <li class="nav-item {{ request()->is('kasir/report') ?'active' : '' }}">
            <a href="{{ route('kasir.report.index') }}">
              <i class="now-ui-icons education_paper"></i>
              <p>Laporan Penjualan</p>
            </a>
          </li>
        </ul>
      </div>
    </div>