@extends('themes.AdminLTE.layouts.template')
@section('breadcrumb')  
  <h1>
    {{ @$title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Transaksi</a></li>
    <li><a href="{{ url(@$nameroutes) }}">{{ @$breadcrumb }}</a></li>
    <li class="active">{{ @$title }}</li>
  </ol>
@endsection
@section('content')  
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">{{ @$header }}</h3>
      <div class="box-tools pull-right">
          <div class="btn-group">
            <a href="{{ url($nameroutes.'/create') }}" class="btn btn-success btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('global.label_create') }}</a>
          </div>
        </button>
      </div>
    </div>
      <!-- /.box-header -->
<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" id="form_crud">
  {{ csrf_field() }}
  <div class="box-body">
    <div class="col-md-6">
      <div class="form-group">
          <label class="col-lg-3 control-label">No Bukti *</label>
          <div class="col-lg-9">
            <input type="text"  class="form-control" name="f[kode_pengeluaran]" id="kode_pengeluaran" value="{{ @$item->kode_pengeluaran }}"  required="" readonly>
          </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Tanggal *</label>
        <div class="col-lg-9">
          <input type="date" name="f[tanggal]" id="tanggal" class="form-control" placeholder="Tanggal" value="{{ date('Y-m-d', strtotime(@$item->tanggal)) }}" required="">
        </div>
      </div>
      <div class="form-group">
        <label class="col-lg-3 control-label">Total *</label>
        <div class="col-lg-9">
          <input type="text" name="f[total]" id="total" class="form-control mask-number" placeholder="Total" value="{{ @$item->total }}" required="" readonly>
        </div>
      </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
          <label class="col-lg-3 control-label">Akun Kas</label>
          <div class="col-lg-9">
            <div class="input-group data_collect_wrapper">
              <input type="hidden" id="akun_id" name="f[akun_id]" required value="{{ @$item->akun_id }}">
              <input type="text" name="nama_akun" id="nama_akun" value="{{ @$item->nama_akun }}" class="form-control" placeholder="Akun Kas" required="" readonly>
              <div class="input-group-btn">
                <a href="javascript:;" id="lookup_akun" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
              </div>
            </div>
          </div>
        </div>
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
              <th>Keterangan</th>
              <th>Nominal</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
        </table>
        <div>
            <a  title="Tambah" id="lookup_detail" class="btn btn-block btn-github"><i class="fa fa-plus" aria-hidden="true"></i> <b>Tambah Detail Pengeluaran</b> </a>
        </div>
  </div>
  <div class="box-footer">
    @if(@$item->status_batal == 1)
      <div class="pull-center">
        <h4 style="color: red;text-align:center">Data ini sudah dibatalkan!</h4>
      </div>
    @endif
    <div class="pull-right">
          {{-- @if(@$is_edit)
            <button title="Batalkan data" @if(@$item->status_batal == 1) disabled @else id="cancel" @endif  class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i> Batalkan</button>
          @else --}}
            <button id="submit_form" type="submit" class="btn btn-success"><i class="fa fa-save" aria-hidden="true"></i> Simpan </button> 
          {{-- @endif --}}
    </div>
  </div>
</form>

<script type="text/javascript">
      let lookup = {
        lookup_modal_detail: function() {
            $('#lookup_detail').on( "click", function(e){
              e.preventDefault();
              var _prop= {
                _this : $( this ),
                remote : "{{ url("$nameroutes") }}/lookup_detail",
                size : 'modal-lg',
                title : "Form Detail Pengeluaran",
              }
              ajax_modal.show(_prop);											
            });  
          },
      };
      var _datatable_actions = {
          edit: function( row, data, index ){
												
                        switch( this.index() ){				
                          case 3:
                          
                            var _input = $( "<input type=\"text\" value=\"" + (data.keterangan) + "\" style=\"width:100%\"  class=\"form-control\">" );
                            this.empty().append( _input );
                            
                            _input.trigger( "focus" );
                            
                            _input.on("blur", function(e){
                                e.preventDefault();
                                try{
                                  data.keterangan = this.value != '' ? this.value : data.keterangan;
										              _datatable.row( row ).data( data );
                                  
                                } catch(ex){}
                              });
                          break;			

                          case 4:
                          
                            var _input = $( "<input type=\"text\" value=\"" + Number((data.nominal > 0) ? data.nominal : data.kredit || 1) + "\" style=\"width:100%\"  class=\"form-control mask-number\" min=\"1\">" );
                            var total;
                            this.empty().append( _input );
                            
                            
                            _input.trigger( "focus" );
                            
                            _input.on("blur", function(e){
                                e.preventDefault();
                                try{
                                  (data.nominal > 0) ? data.nominal : data.kredit = this.value;
                                    _datatable.row( row ).data( data );
                                    _datatable_actions.calculate_sum()
                                  
                                } catch(ex){}
                              });
                          break;
            
                          
            
                        }
                        
                      },
            calculate_sum: function(params, fn, scope){
                var grandtotal = 0;
                
                var collection = $( "#dt_detail" ).DataTable().rows().data();
                
                collection.each(function(value, index){
                  
                  grandtotal += Number(mask_number.currency_remove( (value.nominal > 0) ? value.nominal : value.kredit));
                    
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
                            data: "id",
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
                              data: "keterangan", 
                              render: function ( val, type, row ){
                                  return val
                                }
                        },
                        { 
                              data: "nominal", 
                              render: function ( val, type, row ){
                                  return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                }
                        },
                        { 
                              data: "akun_id", 
                              visible: false,
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
    $('#lookup_akun').dataCollect({
        ajaxUrl: "{{ url('akun/lookup_collection') }}",
        ajaxMethod: 'GET',
			  ajaxData: function(params){
            params.kelompok = 'Aktiva Lancar';
			  },
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN AKUN',
        modalTxtSelect : 'Pilih Akun',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['No Akun','Nama Akun','Golongan','Kelompok'],
        dtColumns: [
            {data: "kode_akun"}, 
            {data: "nama_akun"}, 
            {data: "golongan"}, 
            {data: "kelompok"}, 
        ],
        onSelected: function(data, _this){	
          $('#akun_id').val(data.id);
          $('#nama_akun').val(data.nama_akun); 
            
          return true;
        }
    });


    _datatables_dt_detail.dt_detail();
    lookup.lookup_modal_detail();

  });
  $("form#form_crud").on('submit',function(e) {
    total = mask_number.currency_remove($('#total').val());
    if(total == '' || total == 0)
    {
      $.alert_warning('Nominal belum di masukkan!');
      return false
    }
      e.preventDefault();
          var header_data = {
                    'tanggal' : $("#tanggal").val(),
                    'akun_id' :  $("#akun_id").val(),
                    'keterangan': $("#keterangan").val(),
                    'total': mask_number.currency_remove($("#total").val()),
                }

            var data_post = {
                    "details" : {},
                    "f" : header_data
                }
            
              _datatable.rows().data().each(function (value, index){
                    var details_form = {
                        'nominal' : mask_number.currency_remove(value.nominal),
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
              document.location.href = "{{ url("$nameroutes") }}";  
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
                'jenis_mutasi' : $("#jenis_mutasi").val(),
                'akun_id' :  $("#akun_id").val(),
                'keterangan': $("#keterangan").val(),
                'total': mask_number.currency_remove($("#total").val()),
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
              document.location.href = "{{ url("$nameroutes") }}";  
            }, 500);  
    });
    return false;
});


</script>
@endsection