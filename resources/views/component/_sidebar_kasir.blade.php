
    <div class="sidebar" data-color="orange">
        <!--
        Tip 1: You can change the color of the fdebar using: data-color="blue | green | orange | red | yellow"
        -->
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          AK
        </a>
        <a href="{{ route('home') }}" class="simple-text logo-normal">
          Aplikasi Kasir
        </a>
      </div>
      <div class="sidebar-wrapper" id="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="{{ route('kasir.dashboard.index') }}">
              <i class="now-ui-icons design_app"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="{{ route('kasir.transaction.index') }}">
              <i class="now-ui-icons shopping_cart-simple"></i>
              <p>Transaksi</p>
            </a>
          </li>
          <li>
            <a href="{{ route('kasir.report.index') }}">
              <i class="now-ui-icons education_paper"></i>
              <p>Laporan</p>
            </a>
          </li>
          <li>
            <a href="{{ route('kasir.profile.index') }}">
              <i class="now-ui-icons business_badge"></i>
              <p>Akun Saya</p>
            </a>
          </li>
        </ul>
      </div>
    </div>