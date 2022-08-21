<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ url('themes/AdminLTE-2.4.3/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Helpers::getNama() }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN MENU</li>
          <li class="{{ Request::is('dashboard') ? 'active':null}}"><a href="{{ url('dashboard') }}"><i class="glyphicon glyphicon-home"></i> <span>Dashboard</span></a></li>
          <li class="{{ Request::is('jurnal-umum') ? 'active':null}}"><a href="{{ url('jurnal-umum') }}"><i class="fa fa-balance-scale" aria-hidden="true"></i> <span>Jurnal Umum</span></a></li>
          <li class="treeview {{ Request::is('laporan/retribusi-sampah') ? 'active':null}} {{ Request::is('laporan/pembayaran-online') ? 'active':null}} 
            {{ Request::is('laporan/samsat-kendaraan') ? 'active':null}} {{ Request::is('laporan/tunggakan-spp') ? 'active':null}} 
            {{ Request::is('laporan/pembayaran-gedung') ? 'active':null}} {{ Request::is('laporan/tunggakan-gedung') ? 'active':null}}">
            <a href="#">
              <i class="fa fa-files-o" aria-hidden="true"></i>
              <span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{ Request::is('laporan/retribusi-sampah') ? 'active':null}}"><a href="{{ url('laporan/retribusi-sampah') }}"><i class="fa fa-file-text-o"></i> Retribusi Sampah</a></li>
              <li class="{{ Request::is('laporan/pembayaran-online') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-online') }}"><i class="fa fa-file-text-o"></i> Pembayaran Online</a></li>
              <li class="{{ Request::is('laporan/samsat-kendaraan') ? 'active':null}}"><a href="{{ url('laporan/samsat-kendaraan') }}"><i class="fa fa-file-text-o"></i> Samsat Kendaraan</a></li>
              <li class="{{ Request::is('laporan/pemasukan') ? 'active':null}}"><a href="{{ url('laporan/pemasukan') }}"><i class="fa fa-file-text-o"></i> Jurnal Umum</a></li>
              <li class="{{ Request::is('laporan/pengeluaran') ? 'active':null}}"><a href="{{ url('laporan/pengeluaran') }}"><i class="fa fa-file-text-o"></i> Buku Besar</a></li>
              <li class="{{ Request::is('laporan/pembayaran-siswa') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-siswa') }}"><i class="fa fa-file-text-o"></i> Neraca</a></li>
              <li class="{{ Request::is('laporan/pembayaran-spp') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-spp') }}"><i class="fa fa-file-text-o"></i> Laba Rugi</a></li>
              <li class="{{ Request::is('laporan/tunggakan-spp') ? 'active':null}}"><a href="{{ url('laporan/tunggakan-spp') }}"><i class="fa fa-file-text-o"></i> Arus Kas</a></li>
              <li class="{{ Request::is('laporan/pembayaran-gedung') ? 'active':null}}"><a href="{{ url('laporan/pembayaran-gedung') }}"><i class="fa fa-file-text-o"></i> Perubahan Modal</a></li>
            </ul>
          </li>
        </ul>

    </section>
    <!-- /.sidebar -->
  </aside>