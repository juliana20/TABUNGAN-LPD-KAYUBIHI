@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
            <li class="dropdown">
              <button class="btn btn-success btn-sm" onclick="window.location='{{ url($nameroutes.'/create') }}'" ><i class="fa fa-plus-circle" aria-hidden="true"></i> Proses Tutup Buku</button>
            </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table table-hover" id="{{ $idDatatables }}" width="100%">   
            <thead>
              <tr>
                {{-- <th class="no-sort">Aksi</th> --}}
                <th>Tanggal</th>
                <th>Total Setoran</th>
                <th>Total Penarikan</th> 
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
              columns: [
                        // { 
                        //         data: "id",
                        //         orderable: false,
                        //         className: "text-center",
                        //         render: function ( val, type, row ){
                        //             var buttons = '<div class="btn-group" role="group">';
                        //               buttons += '<a class=\"btn btn-danger btn-xs modalCancel\"><i class=\"fa fa-trash\"></i> Batalkan</a>';
                        //               buttons += "</div>";
                        //             return buttons
                        //           }
                        //       },
                          { 
                                data: "tanggal", 
                                render: function ( val, type, row ){
                                    return moment(val).format('DD MMMM YYYY')
                                  }
                          },
                          { 
                                data: "total_setoran", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "total_penarikan", 
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
                      createdRow: function ( row, data, index ){	
                        $( row ).on( "click", ".modalCancel",  function(e){
                            e.preventDefault();
                            if( confirm( "Apakah anda yakin membatalkan tutup buku?" ) ){
                              $.get("{{ url("$nameroutes") }}/delete/" + data.id, function(response, status, xhr) {
                              if( response.status == "error"){
                                  $.alert_warning(response.message);
                                      return false
                                  }
                                  $.alert_success(response.message);
                                      setTimeout(function(){
                                        location.reload();   
                                      }, 500);  
                              }).catch(error => {
                                    $.alert_error(error);
                                    return false
                              });
                            }										
                        })	

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
 
