          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>MAIN MENU</h3>
                  <ul class="nav side-menu">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                    <li><a><i class="fa fa-database"></i>Data Master<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li class="{{ Request::is('user') ? 'active':null}}"><a href="{{ url('user') }}">User</a></li>
                        <li class="{{ Request::is('pelanggan') ? 'active':null}}"><a href="{{ url('pelanggan') }}">Pelanggan</a></li>
                        <li class="{{ Request::is('akun') ? 'active':null}}"><a href="{{ url('akun') }}">Akun</a></li>
                        <li class="{{ Request::is('jenis-transaksi') ? 'active':null}}"><a href="{{ url('jenis-transaksi') }}">Jenis Transaksi</a></li>
                      </ul>
                    </li>
                    <li><a><i class="fa fa-credit-card"></i>Transaksi<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li class="{{ Request::is('transaksi-retribusi-sampah') ? 'active':null}} {{ request()->is('transaksi-retribusi-sampah*') ? 'active':null}}"><a href="{{ url('transaksi-retribusi-sampah') }}">Retribusi Sampah</a></li>
                        <li class="{{ Request::is('transaksi-pembayaran-online') ? 'active':null}}"><a href="{{ url('transaksi-pembayaran-online') }}">Pembayaran Online</a></li>
                        <li class="{{ Request::is('transaksi-samsat-kendaraan') ? 'active':null}}"><a href="{{ url('transaksi-samsat-kendaraan') }}">Samsat Kendaraan</a></li>
                      </ul>
                    </li>
                    <li class="{{ Request::is('pengeluaran') ? 'active':null}}"><a href="{{ url('pengeluaran') }}"><i class="fa fa-money"></i>Pengeluaran</a></li>
                  </ul>
              </div>

            <div class="menu_section">
              <h3>SETTING</h3>
              <ul class="nav side-menu">
                <li class="{{ Request::is('setting-parameter') ? 'active':null}}"><a href="{{ url('setting-parameter') }}"><i class="glyphicon glyphicon-cog"></i> <span>Biaya Sampah</span></a></li>
              </ul>
            </div>

          </div>
          <!-- /sidebar menu -->