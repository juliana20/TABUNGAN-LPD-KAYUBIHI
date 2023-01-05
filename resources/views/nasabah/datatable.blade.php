@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li class="dropdown">
            <button class="btn btn-info btn-sm" id="modalGenerateBunga"><i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i> Generate Bunga</button>
          </li>
          @if(!@$is_kepala)
            <li class="dropdown">
              <button class="btn btn-success btn-sm" id="modalCreate"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('global.label_create') }}</button>
            </li>
          @endif
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" style="background:#ffffff">
          <div class="panel-body">
              <div class="row">
                  <div class="col-md-2 ">
                    <div class="form-group">
                      <label class="control-label">Periode Daftar</label>
                      <input type="date" name="periode_awal" class="form-control" id="periode_awal">
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label class="control-label">&nbsp;</label>
                      <input type="date" name="periode_akhir" class="form-control" id="periode_akhir">
                    </div>
                  </div>
              </div>
          </div>
      </div>
        <table class="table table-hover" id="{{ $idDatatables }}" width="100%">   
            <thead>
              <tr>
                @if(!@$is_kepala)
                  <th class="no-sort">Aksi</th>
                @endif
                <th>ID Nasabah</th>
                <th>Nama Nasabah</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Pekerjaan</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>No KTP</th>
                <th>Tanggal Daftar</th>
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
    let lookup = {
      lookup_modal_create: function() {
          $('#modalCreate').on( "click", function(e){
            e.preventDefault();
            var _prop= {
              _this : $( this ),
              remote : "{{ url("$nameroutes") }}/create",
              size : 'modal-lg',
              title : "<?= @$headerModalTambah ?>",
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
                      params.periode_awal = $('#periode_awal').val();
                      params.periode_akhir = $('#periode_akhir').val();
									}
								},
              columns: [
                        @if(!@$is_kepala)
                        { 
                                data: "id",
                                orderable: false,
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                      buttons += '<a class=\"btn btn-warning btn-xs modalResetPassword\"><i class=\"fa fa-cog\"></i> Reset Password</a>';
                                      buttons += '<a class=\"btn btn-info btn-xs modalEdit\"><i class=\"glyphicon glyphicon-pencil\"></i> Ubah</a>';
                                      buttons += "</div>";
                                    return buttons
                                  }
                              },
                          @endif
                          { 
                                data: "id_nasabah", 
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
                                data: "jenis_kelamin", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "tanggal_lahir", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "pekerjaan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "alamat", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "telepon", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "no_ktp", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "tanggal_daftar", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                      ],
                      createdRow: function ( row, data, index ){		
                        $( row ).on( "click", ".modalEdit",  function(e){
                            e.preventDefault();
                            var id = data.id;
                            var _prop= {
                                _this : $( this ),
                                remote : "{{ url("$nameroutes") }}/edit/" + id,
                                size : 'modal-lg',
                                title : "<?= @$headerModalEdit ?>",
                            }
                            ajax_modal.show(_prop);											
                        })
                        $( row ).on( "click", ".modalResetPassword",  function(e){
                            e.preventDefault();
                            if( confirm( "Apakah anda yakin mereset password nasabah ini?" ) ){
                              $.get("{{ url("$nameroutes") }}/reset-password/" + data.id, function(response, status, xhr) {
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
    lookup.lookup_modal_create();
    $('#periode_awal,#periode_akhir').on('change', function(e){
        e.preventDefault();
        _datatable.ajax.reload();
    });


    $('#modalGenerateBunga').on( "click", function(e){
        e.preventDefault();
        if( confirm( "Apakah anda yakin generate bunga tabungan?" ) ){
          $.ajax({
              url: "{{ url("$nameroutes") }}/generate-bunga",
              type: 'GET',              
              success: function(response, status, xhr)
              {
                if( response.status == "error"){
                  $.alert_warning(response.message);
                  return false
              }
                  
              $.alert_success(response.message);
                setTimeout(function(){
                  location.reload();   
                }, 500);
              },
              error: function(error)
              {
                $.alert_error(error);
                return false
              }
          });
        }										
    })
});
</script>
@endsection
 
