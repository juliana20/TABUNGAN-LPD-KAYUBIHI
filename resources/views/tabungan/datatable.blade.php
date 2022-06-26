@extends('themes.AdminLTE.layouts.template')
@section('breadcrumb')  
  <h1>
    {{ @$title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
    <li class="active">{{ @$title }}</li>
  </ol>
@endsection
@section('content')  
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">{{ @$title }}</h3>
        <div class="box-tools pull-right">
            <div class="btn-group">
              <button type="button" class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown">
              Tindakan <i class="fa fa-wrench"></i></button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="" id="modalCreate"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Baru</a></li>
              </ul>
            </div>
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-striped table-bordered table-hover" id="{{ $idDatatables }}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">No</th>
                <th>No Rekening</th>
                <th>Nama Nasabah</th>
                <th>Saldo Akhir</th>
                <th>Tgl Buka</th>
                <th class="no-sort">Aksi</th>
              </tr>
            </thead>
            <tbody>
            
          </tbody>
          </table>
      </div>
    </div>

<!-- DataTable -->
<script type="text/javascript">
    let lookup = {
      lookup_modal_create: function() {
          $('#modalCreate').on( "click", function(e){
            e.preventDefault();
            var _prop= {
              _this : $( this ),
              remote : "{{ url("$nameroutes") }}/create",
              size : 'modal-md',
              title : "Tambah Tabungan",
            }
            ajax_modal.show(_prop);											
          });  
        },
    };
    let _datatables_show = {
      dt__datatables_show:function(){
        var _this = $("#{{ $idDatatables }}");
            _datatable = _this.DataTable({									
              ajax: {
								url: "{{ url("{$urlDatatables}") }}",
								type: "POST",
								data: function(params){

										}
								},
              order:[ 1, 'asc'],
              columns: [
                          {
                              data: "id_nasabah",
                              className: "text-center",
                              render: function (data, type, row, meta) {
                                  return meta.row + meta.settings._iDisplayStart + 1;
                              }
                          },
                          { 
                                data: "no_rek_tabungan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama_nasabah", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "saldo", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "tanggal_daftar", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "id_nasabah",
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                      buttons += '<a class=\"btn btn-warning btn-xs modalSetoran\"><i class=\"fa fa-plus\"></i> Setoran</a>';
                                      buttons += '<a class=\"btn btn-danger btn-xs modalPenarikan\"><i class=\"fa fa-minus\"></i> Penarikan</a>';
                                      buttons += '<a href=\"{{ url('tabungan/proses-setoran') }}/'+ val +'\" title=\"Lihat\" class=\"btn btn-info btn-xs\"><i class=\"fa fa-eye\"></i> Lihat</a>';
                                      buttons += "</div>";
                                    return buttons
                                  }
                              },
                      ],
                      createdRow: function ( row, data, index ){		
                        $( row ).on( "click", ".modalSetoran",  function(e){
                            e.preventDefault();
                            var id = data.id_nasabah;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/setoran/" + id,
                                size : 'modal-md',
                                title : "Setoran Tabungan",
                            }
                            ajax_modal.show(_prop);											
                        }),
                        $( row ).on( "click", ".modalPenarikan",  function(e){
                            e.preventDefault();
                            var id = data.id_nasabah;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/penarikan/" + id,
                                size : 'modal-md',
                                title : "Penarikan Tabungan",
                            }
                            ajax_modal.show(_prop);											
                        })

                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_show.dt__datatables_show();
    lookup.lookup_modal_create();
});
</script>
@endsection
 
