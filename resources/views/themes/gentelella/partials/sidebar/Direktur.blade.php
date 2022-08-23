          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>MAIN MENU</h3>
                  <ul class="nav side-menu">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                    <li class="{{ Request::is('jurnal-umum') ? 'active':null}}"><a href="{{ url('jurnal-umum') }}"><i class="fa fa-balance-scale" aria-hidden="true"></i>Jurnal Umum</a></li>
                    <li><a><i class="fa fa-file-text-o"></i>Laporan<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li class="{{ Request::is('laporan/retribusi-sampah') ? 'active':null}}"><a href="{{ url('laporan/retribusi-sampah') }}">Retribusi Sampah</a></li>
                        <li class="{{ Request::is('laporan/pembayaran-online') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-online') }}">Pembayaran Online</a></li>
                        <li class="{{ Request::is('laporan/samsat-kendaraan') ? 'active':null}}"><a href="{{ url('laporan/samsat-kendaraan') }}">Samsat Kendaraan</a></li>
                        <li class="{{ Request::is('laporan/pemasukan') ? 'active':null}}"><a href="{{ url('laporan/pemasukan') }}">Jurnal Umum</a></li>
                        <li class="{{ Request::is('laporan/pengeluaran') ? 'active':null}}"><a href="{{ url('laporan/pengeluaran') }}">Buku Besar</a></li>
                        <li class="{{ Request::is('laporan/pembayaran-siswa') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-siswa') }}">Neraca</a></li>
                        <li class="{{ Request::is('laporan/pembayaran-spp') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-spp') }}">Laba Rugi</a></li>
                        <li class="{{ Request::is('laporan/tunggakan-spp') ? 'active':null}}"><a href="{{ url('laporan/tunggakan-spp') }}">Arus Kas</a></li>
                        <li class="{{ Request::is('laporan/pembayaran-gedung') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-gedung') }}">Perubahan Modal</a></li>
                      </ul>
                    </li>
              
                  </ul>
              </div>

          </div>
          <!-- /sidebar menu -->