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
                <li><a href="" id="modalCreate"><i class="fa fa-plus" aria-hidden="true"></i> Buka Tabungan Berjangka</a></li>
              </ul>
            </div>
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-header">
        <!-- /.box-header -->
          <!-- Date and time range -->
            <div class="form-group">
              <div class="col-lg-12">
                <input type="radio" id="Berakhir" name="status_proses" value="0">
                <label for="Berakhir">Berakhir</label>
                <input type="radio" id="Berjalan" name="status_proses" value="1" checked>
                <label for="Berjalan">Berjalan</label>
              </div>
          </div>
        </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-striped table-bordered table-hover" id="dt_deposito" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">No</th>
                <th>No Tabungan Berjangka</th>
                <th>Nama Nasabah</th>
                <th>Nominal Setoran (bulan)</th>
                <th>Jangka Waktu (th)</th>
                <th>Jumlah Diterima</th>
                <th>Saldo Berjalan</th>
                <th>Awal Berlaku</th>
                <th>Akhir Berlaku</th>
                <th>Status</th>
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
              size : 'modal-lg',
              title : "Tambah Tabungan Berjangka",
            }
            ajax_modal.show(_prop);											
          });  
        },
    };
    let _datatables_show = {
      dt__datatables_show:function(){
        var _this = $("#dt_deposito");
            _datatable = _this.DataTable({									
              ajax: {
								url: "{{ url("$nameroutes") }}/datatables",
								type: "POST",
                data: function(params){
                        params.proses = $('input[name="status_proses"]:checked').val();
										}
								},
              order:[ 1, 'asc'],
              columns: [
                          {
                              data: "id_tabungan_berjangka",
                              className: "text-center",
                              render: function (data, type, row, meta) {
                                  return meta.row + meta.settings._iDisplayStart + 1;
                              }
                          },
                          { 
                                data: "id_tabungan_berjangka", 
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
                                data: "nominal_tabungan_berjangka", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "jangka_waktu", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "total_tabungan_berjangka", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "saldo_berjalan", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "tanggal_awal", 
                                render: function ( val, type, row ){
                                    return moment(val).format('DD MMM YYYY')
                                  }
                          },
                          { 
                                data: "jatuh_tempo", 
                                render: function ( val, type, row ){
                                    return moment(val).format('DD MMM YYYY')
                                  }
                          },
                          { 
                              data: "status_tabungan_berjangka", 
                                render: function ( val, type, row ){
                                    var button_success = `<label class="label label-success">Berjalan</label>`;
                                        button_danger  = `<label class="label label-danger">Berakhir</label>`;

                                        return (val == 1) ? button_success : button_danger
                                  }
                          },
                          { 
                                data: "id_tabungan_berjangka",
                                className: "text-center",
                                width: '200px',
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                      if(row.status_tabungan_berjangka == 0 || row.status_tabungan_berjangka == "")
                                      {
                                        buttons += '<a href=\"{{ url('tabungan-berjangka/detail') }}/'+ val +'\" title=\"Lihat\" class=\"btn btn-info btn-xs\"><i class=\"fa fa-eye\"></i> Detail</a>';
                                      }
                                      else{
                                        buttons += '<a class=\"btn btn-warning btn-xs modalSetoran\"><i class=\"fa fa-plus\"></i> Setoran</a>';
                                        buttons += '<a class=\"btn btn-danger btn-xs modalPenarikan\"><i class=\"fa fa-minus\"></i> Penarikan</a>';
                                        buttons += '<a href=\"{{ url('tabungan-berjangka/detail') }}/'+ val +'\" title=\"Lihat\" class=\"btn btn-info btn-xs\"><i class=\"fa fa-eye\"></i> Detail</a>';
                                      }
                                     
                                    buttons += "</div>";
                                    return buttons
                                  }
                              },
                      ],
                      createdRow: function ( row, data, index ){		
                        $( row ).on( "click", ".modalSetoran",  function(e){
                            e.preventDefault();
                            var id = data.id_tabungan_berjangka;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/setoran/" + id,
                                size : 'modal-md',
                                title : "Setoran Tabungan Berjangka",
                            }
                            ajax_modal.show(_prop);											
                        }),
                        $( row ).on( "click", ".modalPenarikan",  function(e){
                            e.preventDefault();
                            var id = data.id_tabungan_berjangka;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/penarikan/" + id,
                                size : 'modal-md',
                                title : "Penarikan Tabungan Berjangka",
                            }
                            ajax_modal.show(_prop);											
                        })

                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    $('input[name="status_proses"]').on('change', function(e){
        e.preventDefault();
        _datatable.ajax.reload();
    });
    _datatables_show.dt__datatables_show();
    lookup.lookup_modal_create();
});
</script>
@endsection
 
