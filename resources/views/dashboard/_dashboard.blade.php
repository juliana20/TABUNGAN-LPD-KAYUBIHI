@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Selamat Datang, <strong>{{ Helpers::getNama() }}</strong></h2>
        <ul class="nav navbar-right panel_toolbox">
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-6 col-sm-6 ">
          <div class="tile_count">
            <div class="col-md-12 col-sm-12  tile_stats_count">
              <span class="count_top"><i class="fa fa-book"></i> Total Pemasukan</span>
              <div id="totalPemasukan" class="count green">Rp. 0</div>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_title">
              <h2>Grafik Pemasukan</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="dropdown">
                  <select name="year_pemasukan" id="select_year_pemasukan" class="form-control">
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022" selected>2022</option>
                  </select>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">  
              <div id="chartPemasukan" class="chartPemasukan" style="width:100%; height:280px;"></div>      
            </div>
          </div>
        </div>
        <div class="col-md-6 col-sm-6 ">
          <div class="tile_count">
            <div class="col-md-12 col-sm-12  tile_stats_count">
              <span class="count_top"><i class="fa fa-money"></i> Total Pengeluaran</span>
              <div id="totalPengeluaran" class="count red">Rp. 0</div>
            </div>
          </div>
          <div class="x_panel">
            <div class="x_title">
              <h2>Grafik Pengeluaran</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li class="dropdown">
                  <select name="year_pengeluaran" id="select_year_pengeluaran" class="form-control">
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022" selected>2022</option>
                  </select>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content1">  
                <div id="chartPengeluaran" class="chartPengeluaran" style="width:100%; height:280px;"></div>
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
        functionGraphPengeluaran: { 
          init:function(){
                var post_data = {};
                    post_data.header = {
                      'year_pengeluaran':$('#select_year_pengeluaran').val()
                    }
                    $.post( "{{ url('dashboard/chart-pengeluaran') }}", post_data, function( response, status, xhr ){
                        if ( response.status == 'error')
                        {
                          return false;
                        }
                        $( "#totalPengeluaran" ).html(response.total_pengeluaran);
                        $.fn.functionGraphPengeluaran.chart(response.data);    
                    });												
              $('#select_year_pengeluaran').on( "change",  function(e){
                $('#chartPengeluaran').remove();
                var post_data = {};
                    post_data.header = {
                      'year_pengeluaran':$('#select_year_pengeluaran').val()
                    }
                $.post( "{{ url('dashboard/chart-pengeluaran') }}", post_data, function( response, status, xhr ){
                    if ( response.status == 'error')
                    {
                      return false;
                    }
                    $( ".x_content1" ).append( "<div class=\"chartPengeluaran\" id=\"chartPengeluaran\" style=\"width:100%; height:280px;\"></div>" );
                    $( "#totalPengeluaran" ).html(response.total_pengeluaran);
                    $.fn.functionGraphPengeluaran.chart(response.data);    
                  });												
              });
          },
        chart: function(data)
            {
              var bar = new Morris.Bar({
                  barSizeRatio:0.8,
                  element: 'chartPengeluaran',
                  resize: true,
                  data: data,
                  barColors: ['#d50606'],
                  xkey: 'Bulan',
                  ykeys: ['Pengeluaran'],
                  labels: ['Total Pengeluaran'],
                  hideHover: 'auto',
                  xLabelAngle: 50,
              });

            },
          },

          
      });

      $.fn.extend({
        functionGraphPemasukan: { 
          init:function(){
                var post_data = {};
                    post_data.header = {
                      'year_pemasukan':$('#select_year_pemasukan').val()
                    }
                    $.post( "{{ url('dashboard/chart-pemasukan') }}", post_data, function( response, status, xhr ){
                        if ( response.status == 'error')
                        {
                          return false;
                        }
                        $( "#totalPemasukan" ).html(response.total_pemasukan);
                        $.fn.functionGraphPemasukan.chart(response.data);    
                    });												
              $('#select_year_pemasukan').on( "change",  function(e){
                $('#chartPemasukan').remove();
                var post_data = {};
                    post_data.header = {
                      'year_pemasukan':$('#select_year_pemasukan').val()
                    }
                $.post( "{{ url('dashboard/chart-pemasukan') }}", post_data, function( response, status, xhr ){
                    if ( response.status == 'error')
                    {
                      return false;
                    }
                    $( ".x_content" ).append( "<div class=\"chartPemasukan\" id=\"chartPemasukan\" style=\"width:100%; height:280px;\"></div>" );
                    $( "#totalPemasukan" ).html(response.total_pemasukan);
                    $.fn.functionGraphPemasukan.chart(response.data);    
                  });												
              });
          },
        chart: function(data)
            {
              var bar = new Morris.Bar({
                  barSizeRatio:1.4,
                  element: 'chartPemasukan',
                  // resize: true,
                  data: data,
                  barColors: ['#26B99A', '#34495E', '#3498DB'],
                  xkey: 'Bulan',
                  ykeys: ['Online','Samsat','Sampah'],
                  labels: ['Total Pembayaran Online', 'Total Pembayaran Samsat Kendaraan', 'Total Pembayaran Retribusi Sampah'],
                  hideHover: 'auto',
                  xLabelAngle: 50,
              });

            },
          },

          
      });

      $(document).ready(function(){
          if ($('#chartPengeluaran').length )
          { 
            $.fn.functionGraphPengeluaran.init();
          }
          if ($('#chartPemasukan').length )
          { 
            $.fn.functionGraphPemasukan.init();
          }
      });
    }); 

</script>
@endsection