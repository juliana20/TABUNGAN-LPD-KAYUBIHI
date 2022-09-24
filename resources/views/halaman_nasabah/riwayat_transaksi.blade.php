@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <strong><span class="label label-default" style="font-size: 11.5px">Total Saldo Saat Ini : Rp. {{ number_format(@$get_saldo, 2) }}</span></strong>
      </div>

      <div class="x_content">
        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel">
              <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <h4 class="panel-title"><i class="fa fa-filter"></i> Filter Pencarian</h4>
              </a>
              <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" style="background: rgb(255, 255, 255);" aria-expanded="true">
                  <div class="panel-body">
                      <div class="row">
                        <div class="form-group">
                          <div class="col-md-3">
                            <label class="control-label">Cari Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
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
                <th class="no-sort">No</th>
                <th>Tanggal</th>
                <th>Simpanan</th>
                <th>Penarikan</th>
                <th>Saldo</th>
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
              searching: false,						
              ajax: {
								url: "{{ url("{$urlDatatables}") }}",
								type: "POST",
								data: function(params){
                  params.tanggal = $('#tanggal').val();
								}
								},
              columns: [
                          { 
                                data: "id", 
                                orderable: false,
                                render: function ( val, type, row, meta ){
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
                                data: "nominal_setoran", 
                                render: function ( val, type, row ){
                                    return mask_number.currency_add(val || 0)
                                  }
                          },
                          { 
                                data: "nominal_penarikan", 
                                render: function ( val, type, row ){
                                    return mask_number.currency_add(val || 0)
                                  }
                          },
                          { 
                                data: "saldo_akhir", 
                                render: function ( val, type, row ){
                                    return mask_number.currency_add(val || 0)
                                  }
                          },
                      ],
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_show.dt__datatables_show();
    $('#tanggal').on('change', function(e){
        e.preventDefault();
        _datatable.ajax.reload();
    });
});
</script>
@endsection
 
