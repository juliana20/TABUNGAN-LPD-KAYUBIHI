@extends('themes.AdminLTE.layouts.template')
@section('content')  
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">{{ @$title }}</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table table-striped table-bordered table-hover" id="dt_tabungan_nasabah" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Saldo</th>
              </tr>
            </thead>
            <tbody>
            
          </tbody>
          </table>
      </div>
    </div>

<!-- DataTable -->
<script type="text/javascript">
    let _datatables_show = {
      dt__datatables_show:function(){
        var _this = $("#dt_tabungan_nasabah");
            _datatable = _this.DataTable({									
              ajax: {
								url: "{{ url('nasabah/tabungan-berjangka/datatables') }}",
								type: "POST",
								data: function(params){
                    params.id_nasabah = "{{ Helpers::isNasabah() }}"
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
                                data: "tanggal", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "debet", 
                                render: function ( val, type, row ){
                                    return (val > 0) ? 'Penarikan' : 'Setoran'
                                  }
                          },
                          { 
                                data: "debet", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "kredit", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "nominal_tabungan_berjangka", 
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
});
</script>
@endsection
 
