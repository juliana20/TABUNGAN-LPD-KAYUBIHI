@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li class="dropdown">
            <button onclick="window.location='{{ url($nameroutes.'/create') }}'"  class="btn btn-success btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('global.label_create') }}</button>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table table-hover" id="{{$idDatatables}}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">Aksi</th>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Akun</th>
                <th>Total</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
            
          </tbody>
          </table>
      </div>
    </div>
  </div>
</div>
<!-- DataTable -->
<script type="text/javascript">
    var id_datatables = "{{ $idDatatables }}";

      _datatables_show = {
        dt_datatables:function(){
        var _this = $("#"+id_datatables);
            _datatable = _this.DataTable({									
							ajax: "{{ url("{$urlDatatables}") }}",
              order:[1, 'desc'],
              columns: [
                          {
                                data: "id",
                                orderable: false,
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                        buttons += '<a href=\"{{ url('pengeluaran/show') }}/'+ val +'\" title=\"Lihat Data\" class="btn btn-warning btn-xs"><i class=\"fa fa-eye\"></i> Lihat</a>';      
                                        buttons += '<a href=\"{{ url('pengeluaran/edit') }}/'+ val +'\" title=\"Ubah Data\" class=\"btn btn-info btn-xs\"><i class=\"glyphicon glyphicon-pencil\"></i> Ubah</a>';
                                        buttons += "</div>";

                                      return buttons
                                  }
                          },
                          { 
                                data: "tanggal", 
                                render: function ( val, type, row ){
                                    return moment(val).format('DD MMMM YYYY')
                                  }
                          },
                          { 
                                data: "kode_pengeluaran", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama_akun", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "total", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "keterangan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                      ],
                                                  
                  });
							
                  return _this;
				}

			}
  
$(document).ready(function() {
  _datatables_show.dt_datatables();
});
  </script>
@endsection
 
