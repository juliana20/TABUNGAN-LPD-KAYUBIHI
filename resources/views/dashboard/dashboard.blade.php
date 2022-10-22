@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>VISI MISI LPD DESA ADAT KAYUBIHI</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <ul class="list-unstyled timeline">
          <li>
            <div class="">
              {{-- <div class="tags">
                <a href="" class="tag">
                  <span>VISI</span>
                </a>
              </div> --}}
              {{-- <strong>VISI</strong> --}}
              <div class="block_content">
                <p class="excerpt">
                  Visi LPD Desa Adat Kayubihi adalah meningkatkan kesejahteraan dan perekonomian krama desa adat dan kemandirian desa adat dengan LPD yang sehat, kuat dan produktif.
                </p>
              </div>
            </div>
          </li><br>
          <li>
            <div class="">
              {{-- <div class="tags">
                <a href="" class="tag">
                  <span>MISI</span>
                </a>
              </div> --}}
              <strong>MISI</strong>
              <div class="block_content">
                <p class="excerpt">
                  1. Meningkatkan keimanan dalam mengurus dan mengelola LPD melalui pemahaman ajaran Agama dan etika kerja, sehingga terwujud pengurus, pengelola, dan pengawas LPD yang profesional berdasarkan pengabdian tulus iklas untuk tetap lestarinya Desa Adat.
                </p>
                <p class="excerpt">
                  2. Meningkatkan perekonomian masyarakat pedesaan dengan mendorong pertumbuhan usaha mikro, kecil dan menengah agar dapat menunjang pembangunan Desa Adat.
                </p>
                <p class="excerpt">
                  3. Meningkatkan dan mendorong pertumbuhan perekonomian dan pembangunan Desa Adat Kayubihi serta sebagai sumber pendapatan Desa Adat.
                </p>
                <p class="excerpt">
                  4. Meningkatkan kinerja LPD melalui sistem pengelolaan dan pelayanan prima.
                </p>
                <p class="excerpt">
                  5. Meningkatkan daya saing melalui inovasi produk dan peningkatan efisiensi untuk dapat menyediakan jasa pelayanan yang berkualitas dan harga yang kompetitive.
                </p>
                <p class="excerpt">
                  6. Meningkatkan kepedulian LPD terhadap lingkungan desa terutama kepentingan sosial, budaya dan agama.
                </p>
                <p class="excerpt">
                  7. Mewujudkan pemerataan kesempatan berusaha dan peluang kerja bagi krama Desa Adat.
                </p>
              </div>
            </div>
          </li>
        </ul>

      </div>

      <div class="x_content">
        <div class="col-md-6 col-sm-6 ">
          <div class="tile_count">
            <div class="col-md-12 col-sm-12  tile_stats_count">
              <span class="count_top"><i class="fa fa-book"></i> Total Simpanan</span>
              <div id="totalSimpanan" class="count green">Rp. 0</div>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_title">
              <h2>Grafik Simpanan Tabungan</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="dropdown">
                  <select name="year_simpanan" id="select_year_simpanan" class="form-control">
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022" selected>2022</option>
                  </select>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" id="x_content_simpanan">  
              <div id="chartSimpanan" class="chartSimpanan" style="width:100%; height:280px;"></div>      
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 ">
          <div class="tile_count">
            <div class="col-md-12 col-sm-12  tile_stats_count">
              <span class="count_top"><i class="fa fa-money"></i> Total Penarikan</span>
              <div id="totalPenarikan" class="count red">Rp. 0</div>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_title">
              <h2>Grafik Penarikan Tabungan</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="dropdown">
                  <select name="year_penarikan" id="select_year_penarikan" class="form-control">
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022" selected>2022</option>
                  </select>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" id="x_content_penarikan">  
                <div id="chartPenarikan" class="chartPenarikan" style="width:100%; height:280px;"></div>
            </div>
          </div>
        </div>
        
        <div class="col-md-12 col-sm-12 ">
          <div class="tile_count">
            <div class="col-md-12 col-sm-12  tile_stats_count">
              <span class="count_top"><i class="fa fa-money"></i> Grafik Transaksi Harian</span>
                <div id="totalTransaksiHarianSimpanan" class="count green" style="font-size: 20px!important;line-height: 25px!important;">Rp. 0</div>
                <div id="totalTransaksiHarianPenarikan" class="count red" style="font-size: 20px!important;line-height: 25px!important;">Rp. 0</div>
            </div>
            
          </div>
          <div class="x_panel">
            <div class="x_title">
              <h2>Grafik Transaksi Harian {{ now()->year }}</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="dropdown">
                  <select name="month_transaksi" id="select_month_transaksi" class="form-control">
                    <?php foreach(@$bulan as $dt): ?>
                      <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == now()->month ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" id="x_content_transaksi_harian">  
                <div id="chartTransaksiHarian" class="chartTransaksiHarian" style="width:100%; height:280px;"></div>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-sm-12 ">
          <div class="tile_count">
            <div class="col-md-12 col-sm-12  tile_stats_count">
              <span class="count_top"><i class="fa fa-users"></i> Grafik Nasabah</span>
                <div id="totalNasabah" class="count green" style="font-size: 20px!important;line-height: 25px!important;">0</div>
            </div>
            
          </div>
          <div class="x_panel">
            <div class="x_title">
              <h2>Grafik Pendaftaran Nasabah</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="dropdown">
                  <select name="year_nasabah" id="select_year_nasabah" class="form-control">
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022" selected>2022</option>
                  </select>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" id="x_content_nasabah">  
                <div id="chartNasabah" class="chartNasabah" style="width:100%; height:280px;"></div>
            </div>
          </div>
        </div>


      </div>
    </div>
  </div>
</div>

<script>
  $(function () {
    $.fn.extend({
      functionGraphSimpanan: { 
        init:function(){
              var post_data = {};
                  post_data.header = {
                    'year_simpanan':$('#select_year_simpanan').val()
                  }
                  $.post( "{{ url('dashboard/chart-simpanan') }}", post_data, function( response, status, xhr ){
                      if ( response.status == 'error')
                      {
                        return false;
                      }
                      $( "#totalSimpanan" ).html(response.total_simpanan);
                      $.fn.functionGraphSimpanan.chart(response.data);    
                  });												
            $('#select_year_simpanan').on( "change",  function(e){
              $('#chartSimpanan').remove();
              var post_data = {};
                  post_data.header = {
                    'year_simpanan':$('#select_year_simpanan').val()
                  }
              $.post( "{{ url('dashboard/chart-simpanan') }}", post_data, function( response, status, xhr ){
                  if ( response.status == 'error')
                  {
                    return false;
                  }
                  $( "#x_content_simpanan" ).append( "<div class=\"chartSimpanan\" id=\"chartSimpanan\" style=\"width:100%; height:280px;\"></div>" );
                  $( "#totalSimpanan" ).html(response.total_simpanan);
                  $.fn.functionGraphSimpanan.chart(response.data);    
                });												
            });
        },
      chart: function(data)
          {
            var bar = new Morris.Bar({
                barSizeRatio:0.8,
                element: 'chartSimpanan',
                resize: true,
                data: data,
                barColors: ['#26B99A'],
                xkey: 'Bulan',
                ykeys: ['Simpanan'],
                labels: ['Total Simpanan'],
                hideHover: 'auto',
                xLabelAngle: 50,
            });

          },
        },

        
    });

    $.fn.extend({
      functionGraphPenarikan: { 
        init:function(){
              var post_data = {};
                  post_data.header = {
                    'year_penarikan':$('#select_year_penarikan').val()
                  }
                  $.post( "{{ url('dashboard/chart-penarikan') }}", post_data, function( response, status, xhr ){
                      if ( response.status == 'error')
                      {
                        return false;
                      }
                      $( "#totalPenarikan" ).html(response.total_penarikan);
                      $.fn.functionGraphPenarikan.chart(response.data);    
                  });												
            $('#select_year_penarikan').on( "change",  function(e){
              $('#chartPenarikan').remove();
              var post_data = {};
                  post_data.header = {
                    'year_penarikan':$('#select_year_penarikan').val()
                  }
              $.post( "{{ url('dashboard/chart-penarikan') }}", post_data, function( response, status, xhr ){
                  if ( response.status == 'error')
                  {
                    return false;
                  }
                  $( "#x_content_penarikan" ).append( "<div class=\"chartPenarikan\" id=\"chartPenarikan\" style=\"width:100%; height:280px;\"></div>" );
                  $( "#totalPenarikan" ).html(response.total_penarikan);
                  $.fn.functionGraphPenarikan.chart(response.data);    
                });												
            });
        },
      chart: function(data)
          {
            var bar = new Morris.Bar({
                barSizeRatio:0.8,
                element: 'chartPenarikan',
                // resize: true,
                data: data,
                barColors: ['#d50606'],
                xkey: 'Bulan',
                ykeys: ['Penarikan'],
                labels: ['Total Penarikan'],
                hideHover: 'auto',
                xLabelAngle: 50,
            });

          },
        },

        
    });

    $.fn.extend({
      functionGraphTransaksiHarian: { 
        init:function(){
              var post_data = {};
                  post_data.header = {
                    'month_transaksi':$('#select_month_transaksi').val()
                  }
                  $.post( "{{ url('dashboard/chart-transaksi-harian') }}", post_data, function( response, status, xhr ){
                      if ( response.status == 'error')
                      {
                        return false;
                      }
                      $( "#totalTransaksiHarianSimpanan" ).html('Simpanan : ' +response.total_transaksi_harian_simpanan);
                      $( "#totalTransaksiHarianPenarikan" ).html('Penarikan : ' +response.total_transaksi_harian_penarikan);
                      $.fn.functionGraphTransaksiHarian.chart(response.data);    
                  });												
            $('#select_month_transaksi').on( "change",  function(e){
              $('#chartTransaksiHarian').remove();
              var post_data = {};
                  post_data.header = {
                    'month_transaksi':$('#select_month_transaksi').val()
                  }
              $.post( "{{ url('dashboard/chart-transaksi-harian') }}", post_data, function( response, status, xhr ){
                  if ( response.status == 'error')
                  {
                    return false;
                  }
                  $( "#x_content_transaksi_harian" ).append( "<div class=\"chartTransaksiHarian\" id=\"chartTransaksiHarian\" style=\"width:100%; height:280px;\"></div>" );
                  $( "#totalTransaksiHarianSimpanan" ).html('Simpanan : ' +response.total_transaksi_harian_simpanan);
                  $( "#totalTransaksiHarianPenarikan" ).html('Penarikan : ' +response.total_transaksi_harian_penarikan);
                  $.fn.functionGraphTransaksiHarian.chart(response.data);    
                });												
            });
        },
      chart: function(data)
          {
            var bar = new Morris.Bar({
                barSizeRatio:0.8,
                element: 'chartTransaksiHarian',
                // resize: true,
                data: data,
                barColors: ['#26B99A','#d50606'],
                xkey: 'Day',
                ykeys: ['Simpanan','Penarikan'],
                labels: ['Total Simpanan','Total Penarikan'],
                hideHover: 'auto',
                xLabelAngle: 50,
            });

          },
        },

        
    });

    $.fn.extend({
      functionGraphNasabah: { 
        init:function(){
              var post_data = {};
                  post_data.header = {
                    'year_nasabah':$('#select_year_nasabah').val()
                  }
                  $.post( "{{ url('dashboard/chart-nasabah') }}", post_data, function( response, status, xhr ){
                      if ( response.status == 'error')
                      {
                        return false;
                      }
                      $( "#totalNasabah" ).html('Total : ' +response.total_nasabah + ' Nasabah');
                      $.fn.functionGraphNasabah.chart(response.data);    
                  });												
            $('#select_year_nasabah').on( "change",  function(e){
              $('#chartNasabah').remove();
              var post_data = {};
                  post_data.header = {
                    'year_nasabah':$('#select_year_nasabah').val()
                  }
              $.post( "{{ url('dashboard/chart-nasabah') }}", post_data, function( response, status, xhr ){
                  if ( response.status == 'error')
                  {
                    return false;
                  }
                  $( "#x_content_nasabah" ).append( "<div class=\"chartNasabah\" id=\"chartNasabah\" style=\"width:100%; height:280px;\"></div>" );
                  $( "#totalNasabah" ).html('Total : ' +response.total_nasabah + ' Nasabah');
                  $.fn.functionGraphNasabah.chart(response.data);    
                });												
            });
        },
      chart: function(data)
          {
            var bar = new Morris.Bar({
                barSizeRatio:0.8,
                element: 'chartNasabah',
                resize: true,
                data: data,
                barColors: ['#26B99A'],
                xkey: 'Bulan',
                ykeys: ['Nasabah'],
                labels: ['Total Nasabah'],
                hideHover: 'auto',
                xLabelAngle: 50,
            });

          },
        },

        
    });
    


    $(document).ready(function(){
        if ($('#chartSimpanan').length )
        { 
          $.fn.functionGraphSimpanan.init();
        }
        if ($('#chartPenarikan').length )
        { 
          $.fn.functionGraphPenarikan.init();
        }
        if ($('#chartTransaksiHarian').length )
        { 
          $.fn.functionGraphTransaksiHarian.init();
        }
        if ($('#chartNasabah').length )
        { 
          $.fn.functionGraphNasabah.init();
        }
    });
  }); 

</script>
@endsection