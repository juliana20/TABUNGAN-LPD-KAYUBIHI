          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>MAIN MENU</h3>
                  <ul class="nav side-menu">
                    <li><a href="{{ url('/dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                    <li><a><i class="fa fa-file-text-o"></i>Laporan<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li><a href="{{ url('laporan/retribusi-sampah') }}">Retribusi Sampah</a></li>
                        <li><a href="{{ url('laporan/pembayaran-online') }}">Pembayaran Online</a></li>
                        <li><a href="{{ url('laporan/samsat-kendaraan') }}">Samsat Kendaraan</a></li>
                        <li><a href="{{ url('laporan/jurnal-umum') }}">Jurnal Umum</a></li>
                        <li><a href="{{ url('laporan/buku-besar') }}">Buku Besar</a></li>
                        <li><a href="{{ url('laporan/neraca') }}">Neraca</a></li>
                        <li><a href="{{ url('laporan/laba-rugi') }}">Laba Rugi</a></li>
                        <li><a href="{{ url('laporan/arus-kas') }}">Arus Kas</a></li>
                        <li><a href="{{ url('laporan/perubahan-modal') }}">Perubahan Modal</a></li>
                      </ul>
                    </li>
              
                  </ul>
              </div>

          </div>
          <!-- /sidebar menu -->