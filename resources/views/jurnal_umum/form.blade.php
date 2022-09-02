@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
         
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal form-label-left" id="form_crud">
  {{ csrf_field() }}
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
          <label class="col-lg-3 control-label">No Bukti *</label>
          <div class="col-lg-9">
            <input type="text"  class="form-control" name="f[kode_jurnal]" id="kode_jurnal" value="{{ @$item->kode_jurnal }}"  required="" readonly>
          </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Tanggal *</label>
        <div class="col-lg-9">
          <input type="date" name="f[tanggal]" id="tanggal" class="form-control" placeholder="Tanggal" value="{{ date('Y-m-d', strtotime(@$item->tanggal)) }}" required="">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label class="col-lg-3 control-label">Keterangan *</label>
        <div class="col-lg-9">
          <textarea name="f[keterangan]" id="keterangan" cols="30" rows="3" class="form-control" required>{{ @$item->keterangan }}</textarea>
        </div>
      </div>
    </div>
        {{-- tabel --}}
        <table class="table table-striped table-hover" id="dt_detail" width="100%">   
          <thead>
            <tr>
              <th></th>
              <th>No Akun</th>
              <th>Nama Akun</th>
              <th>Debet</th>
              <th>Kredit</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
        </table>
        <div>
            <a  title="Tambah" id="lookup_akun" class="btn btn-info btn-block btn-github"><i class="fa fa-plus" aria-hidden="true"></i> <b>Pilih Akun</b> </a>
        </div>
  </div>
  <br>
  <div class="box-footer">
    @if(@$item->status_batal == 1)
      <div class="pull-center">
        <h4 style="color: red;text-align:center">Data ini sudah dibatalkan!</h4>
      </div>
    @endif
    <div class="pull-right">
        @if(@$is_edit)
          <button title="Batalkan data" @if(@$item->status_batal == 1) disabled @else id="cancel" @endif  class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Batalkan</button>
        @else
          <button id="submit_form" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Simpan </button> 
        @endif
    </div>
  </div>
</form>
</div>
</div>
</div>
</div>

<script type="text/javascript">
      let lookup = {
        lookup_modal_detail: function() {
            $('#lookup_akun').on( "click", function(e){
              e.preventDefault();
              var _prop= {
                _this : $( this ),
                remote : "{{ url("$nameroutes") }}/lookup_akun",
                size : 'modal-md',
                title : "Daftar Pilihan Akun",
              }
              ajax_modal.show(_prop);											
            });  
          },
      };
      var _datatable_actions = {
          edit: function( row, data, index ){
												
                        switch( this.index() ){				
                          case 3:
                          
                            var _input = $( "<input type=\"text\" value=\"" + Number(data.debet || 0) + "\" style=\"width:100%\"  class=\"form-control\">" );
                            this.empty().append( _input );
                            
                            _input.trigger( "focus" );
                            
                            _input.on("blur", function(e){
                                e.preventDefault();
                                try{
                                  data.debet = this.value;
										              _datatable.row( row ).data( data );
                                  _datatable_actions.calculate_sum()
                                  
                                } catch(ex){}
                              });
                          break;			

                          case 4:
                          
                            var _input = $( "<input type=\"text\" value=\"" + Number(data.kredit || 0) + "\" style=\"width:100%\"  class=\"form-control mask-number\" min=\"1\">" );
                            var total;
                            this.empty().append( _input );
                            
                            
                            _input.trigger( "focus" );
                            
                            _input.on("blur", function(e){
                                e.preventDefault();
                                try{
                                  data.kredit = this.value;
                                    _datatable.row( row ).data( data );
                                    _datatable_actions.calculate_sum()
                                  
                                } catch(ex){}
                              });
                          break;
                          case 5:
                          
                          var _input = $( "<input type=\"text\" value=\"" + (data.keterangan) + "\" style=\"width:100%\"  class=\"form-control\">" );
                          this.empty().append( _input );
                          
                          _input.trigger( "focus" );
                          
                          _input.on("blur", function(e){
                              e.preventDefault();
                              try{
                                data.keterangan = this.value;
                                _datatable.row( row ).data( data );
                                
                              } catch(ex){}
                            });
                        break;	
            
                          
            
                        }
                        
                      },
            calculate_sum: function(params, fn, scope){
                var grandtotal = 0;
                
                var collection = $( "#dt_detail" ).DataTable().rows().data();
                
                collection.each(function(value, index){
                  
                  grandtotal += Number(mask_number.currency_remove( value.nominal ));
                    
                });
                $("#total").val(mask_number.currency_add(grandtotal));	
              },
          remove: function( params, fn, scope ){
						_datatable.row( scope ).remove().draw(false);
          }
			};

  var _datatables_dt_detail = {
    dt_detail:function(){
          _datatable = $('#dt_detail').DataTable({
            processing: true,
            serverSide: false,								
            paginate: false,
            ordering: false,
            searching: false,
            info: false,
            destroy: true,
            responsive: false,								
            <?php if (!empty(@$collection)):?>
              data: <?php print_r(json_encode(@$collection, JSON_NUMERIC_CHECK));?>,
            <?php endif; ?>
            columns: [
                        {
                            data: "akun_id",
                            className: 'text-center',
                            render: function (val, type, row) {
                              return '<a title=\"Hapus\" class=\"btn btn-danger btn-remove\"><i class=\"fa fa-trash\"></i></a>';
                            }
                        },
                        { 
                              data: "kode_akun", 
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
                              data: "debet", 
                              render: function ( val, type, row ){
                                  return mask_number.currency_add(val)
                                }
                        },
                        { 
                              data: "kredit", 
                              render: function ( val, type, row ){
                                  return mask_number.currency_add(val)
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
                      _datatable_actions.calculate_sum();
                      $( row ).on( "dblclick", "td", function(e){
                          e.preventDefault();												
                          var elem = $( e.target );
                          _datatable_actions.edit.call( elem, row, data, index );
                        });
                      $( row ).on( "click", "a.btn-remove", function(e){
                          e.preventDefault();												
                          var elem = $( e.target );
                          
                          if( confirm( "Apakah anda yakin menghapus data ini?" ) ){
                            _datatable_actions.remove( data, null, row )
                            _datatable_actions.calculate_sum();
                          }
                      });
                  }
                                                
                });
            
      }

    }

	$( document ).ready(function(e) {
    _datatables_dt_detail.dt_detail();
    lookup.lookup_modal_detail();

  });
  $("form#form_crud").on('submit',function(e) {
      e.preventDefault();
          var header_data = {
                    'tanggal' : $("#tanggal").val(),
                    'kode_jurnal' : $("#kode_jurnal").val(),
                    'keterangan': $("#keterangan").val(),
                }

            var data_post = {
                    "details" : {},
                    "header" : header_data
                }
            
              _datatable.rows().data().each(function (value, index){
                    var details_form = {
                        'debet' : mask_number.currency_remove(value.debet),
                        'kredit' : mask_number.currency_remove(value.kredit),
                        'keterangan' : value.keterangan,
                        'akun_id' : value.akun_id,
                    }
                    data_post.details[index] = details_form;
                });
        
    $.post($(this).attr("action"), data_post, function(response, status, xhr) {
        if( response.status == "error"){
              $.alert_error( response.message );
							return false
						}
						
            $.alert_success( response.message );
            setTimeout(function(){
              document.location.href = "{{ url("$nameroutes") }}/transaksi";  
            }, 500);  
    });
    return false;
});

$("#cancel").on('click',function(e) {
      e.preventDefault();
      if(!confirm('Apakah anda yakin membatalkan data ini?'))
      {
        return false
      }
      var header_data = {
              'tanggal' : $("#tanggal").val(),
              'kode_jurnal' : $("#kode_jurnal").val(),
              'keterangan': $("#keterangan").val(),
            }

      var data_post = {
              "header" : header_data
          }
            
    $.post($(this).attr("action"), data_post, function(response, status, xhr) {
        if( response.status == "error"){
              $.alert_error( response.message );
							return false
						}
						
            $.alert_success( response.message );
            setTimeout(function(){
              document.location.href = "{{ url("$nameroutes") }}/transaksi";  
            }, 500);  
    });
    return false;
});


</script>
@endsection