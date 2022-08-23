@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li class="dropdown">
            <button class="btn btn-success btn-sm" id="modalCreate"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('global.label_create') }}</button>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table table-hover" id="{{ $idDatatables }}" width="100%">   
            <thead>
              <tr>
                <th class="no-sort">Aksi</th>
                <th>Kode Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Telepon</th>
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

										}
								},
              columns: [
                        { 
                                data: "id",
                                orderable: false,
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                      buttons += '<a class=\"btn btn-info btn-xs modalEdit\"><i class=\"glyphicon glyphicon-pencil\"></i> Ubah</a>';
                                      buttons += "</div>";
                                    return buttons
                                  }
                              },
                          { 
                                data: "kode", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama", 
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
                                data: "alamat", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "no_telepon", 
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
 
