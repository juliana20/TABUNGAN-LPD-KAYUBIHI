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
        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel">
              <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  <h4 class="panel-title"><i class="fa fa-filter"></i> Filter Pencarian</h4>
              </a>
              <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" style="background:#ffffff">
                  <div class="panel-body">
                      <div class="row">
                        <div class="form-group">
                          <div class="col-md-3">
                            <label class="control-label">Jenis Kendaraan</label>
                            <select name="jenis_kendaraan" class="form-control" required="" id="jenis_kendaraan">
                                <option value="" selected="selected">-- Semua --</option>
                                <?php foreach(@$option_jenis_kendaraan as $dt): ?>
                                  <option value="<?php echo @$dt['id'] ?>"><?php echo @$dt['desc'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
      </div>
        <table class="table table-hover" id="{{ $idDatatables }}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">Aksi</th>
                <th>Kode Transaksi</th>
                <th>Plat Nomor</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal</th>
                <th>Jenis Kendaraan</th>
                <th>Total Bayar</th>
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
    let _datatables_show = {
      dt__datatables_show:function(){
        var _this = $("#{{ $idDatatables }}");
            _datatable = _this.DataTable({									
              ajax: {
								url: "{{ url("{$urlDatatables}") }}",
								type: "POST",
								data: function(params){
                      params.jenis_kendaraan = $('#jenis_kendaraan').val();
										}
								},
              order:[ 1, 'asc'],
              columns: [
                        { 
                                data: "id",
                                orderable: false,
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                      buttons += '<a href=\"{{ url('transaksi-samsat-kendaraan/show') }}/'+ val +'\" title=\"Lihat Data\" class=\"btn btn-warning btn-xs\"><i class=\"fa fa-eye\"></i> Lihat</a>';
                                      buttons += '<a href=\"{{ url('transaksi-samsat-kendaraan/edit') }}/'+ val +'\" title=\"Ubah Data\" class=\"btn btn-info btn-xs\"><i class=\"glyphicon glyphicon-pencil\"></i> Ubah</a>';
                                      buttons += "</div>";
                                    return buttons
                                  }
                              },
                          { 
                                data: "kode_transaksi_samsat", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "plat_nomor", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama_pelanggan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "tanggal_samsat", 
                                render: function ( val, type, row ){
                                    return moment(val).format('DD/MM/Y')
                                  }
                          },
                          { 
                                data: "jenis_kendaraan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "total_bayar", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                      ],
                      createdRow: function ( row, data, index ){		

                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_show.dt__datatables_show();
    $('select[name="jenis_kendaraan"]').on('change', function(e){
        e.preventDefault();
        _datatable.ajax.reload();
    });
});
</script>
@endsection
 
