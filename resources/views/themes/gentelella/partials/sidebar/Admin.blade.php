          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>MENU</h3>
                  <ul class="nav side-menu">
                    <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                    <li class="{{ Request::is('nasabah') ? 'active':null}}"><a href="{{ url('nasabah') }}"><i class="fa fa-users"></i>Nasabah</a></li>
                    <li class="{{ Request::is('pegawai') ? 'active':null}}"><a href="{{ url('pegawai') }}"><i class="fa fa-user"></i>Pegawai</a></li>
                    <li class="{{ Request::is('simpan-tabungan') ? 'active':null}}"><a href="{{ url('simpan-tabungan') }}"><i class="fa fa-book"></i>Simpan Tabungan</a></li>
                    <li class="{{ Request::is('tarik-tabungan') ? 'active':null}}"><a href="{{ url('tarik-tabungan') }}"><i class="fa fa-credit-card"></i>Tarik Tabungan</a></li>
                    <li class="{{ Request::is('validasi-setoran') ? 'active':null}}"><a href="{{ url('validasi-setoran') }}"><i class="fa fa-american-sign-language-interpreting"></i>Validasi Setoran</a></li>
                    <li class="{{ Request::is('tutup-buku') ? 'active':null}}"><a href="{{ url('tutup-buku') }}"><i class="fa fa-exchange"></i>Tutup Buku</a></li>
                    <li><a><i class="fa fa-file-text"></i>Laporan<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li class="{{ Request::is('laporan/transaksi-tabungan-harian') ? 'active':null}} {{ request()->is('laporan/transaksi-tabungan-harian') ? 'active':null}}"><a href="{{ url('laporan/transaksi-tabungan-harian') }}">Transaksi Harian</a></li>
                        <li class="{{ Request::is('laporan/transaksi-tabungan-bulanan') ? 'active':null}} {{ request()->is('laporan/transaksi-tabungan-bulanan') ? 'active':null}}"><a href="{{ url('laporan/transaksi-tabungan-bulanan') }}">Transaksi Bulanan</a></li>
                        <li class="{{ Request::is('laporan/simpanan-tabungan') ? 'active':null}} {{ request()->is('laporan/simpanan-tabungan') ? 'active':null}}"><a href="{{ url('laporan/simpanan-tabungan') }}">Simpanan Tabungan</a></li>
                        <li class="{{ Request::is('laporan/penarikan-tabungan') ? 'active':null}} {{ request()->is('laporan/penarikan-tabungan') ? 'active':null}}"><a href="{{ url('laporan/penarikan-tabungan') }}">Penarikan Tabungan</a></li>
                         <li class="{{ Request::is('laporan/cetak-buku-tabungan') ? 'active':null}} {{ request()->is('laporan/cetak-buku-tabungan') ? 'active':null}}"><a href="{{ url('laporan/cetak-buku-tabungan') }}">Cetak Buku Tabungan</a></li>
                      </ul>
                    </li>
                  </ul>
              </div>


          </div>
          <!-- /sidebar menu -->