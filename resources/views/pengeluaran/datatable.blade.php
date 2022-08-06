@extends('themes.AdminLTE.layouts.template')
@section('breadcrumb')  
  <h1>
    {{ @$title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Transaksi</a></li>
    <li class="active">{{ @$title }}</li>
  </ol>
@endsection
@section('content')  
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ @$header }}</h3>
        <div class="box-tools pull-right">
            <div class="btn-group">
              <a href="{{ url($nameroutes.'/create') }}" class="btn btn-success btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('global.label_create') }}</a>
            </div>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-hover" id="{{$idDatatables}}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">No</th>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Akun</th>
                <th>Total</th>
                <th>Keterangan</th>
                <th class="no-sort"><i class="fa fa-cog" aria-hidden="true"></i></th>
              </tr>
            </thead>
            <tbody>
            
          </tbody>
          </table>
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
                              render: function (data, type, row, meta) {
                                  return meta.row + meta.settings._iDisplayStart + 1;
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
                          { 
                                data: "id",
                                width: '15%',
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group">' +
                                                        '<a href=\"{{ url('pengeluaran/detail') }}/'+ val +'\" title=\"Lihat Data\" class="btn btn-info btn-xs"><i class=\"fa fa-eye\"></i> Lihat</a>' +            
                                                  '</div>';
                                    return buttons
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
 
