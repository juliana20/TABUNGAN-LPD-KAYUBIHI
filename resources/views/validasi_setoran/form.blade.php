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
        <div class="col-sm-9 col-sm-offset-1">
        <form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal form-label-left" name="form_crud">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="date" class="form-control" name="f[tanggal]" id="tanggal" value="{{ date('Y-m-d', strtotime($item->tanggal)) }}" placeholder="Tanggal Validasi" required="" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Setoran</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="date" class="form-control" name="f[tanggal_setoran]" id="tanggal_setoran" value="{{ date('Y-m-d', strtotime($item->tanggal_setoran)) }}" placeholder="Tanggal Setoran" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kolektor</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group data_collect_wrapper">
                <input type="hidden" value="{{ @$item->kolektor_id }}" id="kolektor_id" name="f[kolektor_id]" required>
                <input type="text" name="f[nama_kolektor]" id="nama_kolektor" class="form-control" placeholder="Kolektor" value="{{ @$item->nama_kolektor }}" required readonly>
                <div class="input-group-btn">
                  <a href="javascript:;" id="lookup_kolektor" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">&nbsp;</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <h4 style="text-align:center"><strong>Daftar Transaksi</strong></h4><br>
              <table class="table table-striped table-hover table-bordered" id="dt_detail_setoran" width="100%">   
                <thead>
                  <tr>
                    <th></th>
                    <th>No Rekening</th>
                    <th>Nama Nasabah</th>
                    <th>Tanggal</th>
                    <th>Nominal Setoran</th>
                    <th>Nominal Penarikan</th>
                  </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Total</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group">
                <div class="input-group-btn">
                  <span class="btn btn-default btn-flat">Rp</span>
                </div>
                <input type="text" name="f[total]" id="total" class="form-control mask-number" placeholder="Total" value="{{ @$item->total }}" required="" disabled>
              </div>
              </div>
            </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <textarea name="f[keterangan]" id="keterangan" cols="3" rows="3" class="form-control">{{ @$item->keterangan }}</textarea>
            </div>
          </div>

          <div class="form-group">
              <div class="col-lg-offset-3 col-lg-9">
                <button type="submit" class="btn btn-success btn-save">Validasi <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
              <br><br>
              </div>
              
          </div>
         
        </form>
      </div>
    </div>
    </div>
  </div>
</div>
     

<script type="text/javascript">
  var _datatable_actions = {
            calculate_sum: function(params, fn, scope){
                var setoran = 0;
                var penarikan = 0;
                var grandtotal = 0;
                
                var collection = $( "#dt_detail_setoran" ).DataTable().rows().data();
                
                collection.each(function(value, index){
                  
                  setoran += Number(mask_number.currency_remove(value.nominal_setoran));
                  penarikan += Number(mask_number.currency_remove(value.nominal_penarikan));
                  grandtotal = setoran - penarikan;
                    
                });
                $("#total").val(mask_number.currency_add(grandtotal));	
              },
          remove: function( params, fn, scope ){
						_datatable.row( scope ).remove().draw(false);
          }
			};
  var _datatables_dt_detail = {
    dt_detail:function(collection){
          _datatable = $('#dt_detail_setoran').DataTable({
            processing: true,
            serverSide: false,								
            paginate: false,
            ordering: false,
            searching: false,
            info: false,
            destroy: true,
            responsive: false,								
            data: collection,
            columns: [
                        {
                            data: "id",
                            className: 'text-center',
                            render: function (val, type, row) {
                              return '<a title=\"Hapus\" class=\"btn btn-danger btn-remove\"><i class=\"fa fa-trash\"></i></a>';
                            }
                        },
                        { 
                              data: "no_rekening", 
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
                              data: "tanggal", 
                              render: function ( val, type, row ){
                                  return moment(val).format('DD MMMM YYYY')
                                }
                        },
                        { 
                              data: "nominal_setoran", 
                              render: function ( val, type, row ){
                                  return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                }
                        },
                        { 
                              data: "nominal_penarikan", 
                              render: function ( val, type, row ){
                                  return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                }
                        }
                    ],
                    createdRow: function ( row, data, index ){		
                      _datatable_actions.calculate_sum();
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


  $(document).on("change",'#tanggal_setoran,#kolektor_id', calculate);

  function calculate() {
    var tanggal_setoran = $('#tanggal_setoran').val();
        kolektor_id = $('#kolektor_id').val();

        var data_post = {
              'tanggal_setoran' : tanggal_setoran,
              'kolektor_id' : kolektor_id,
        }

        if(!kolektor_id)
        {
          alert('Silahkan pilih kolektor terlebih dahulu');
          return false
        }
        if(!tanggal_setoran)
        {
          alert('Silahkan pilih tanggal setoran terlebih dahulu');
          return false
        }

        $.ajax({
          url: "{{ url('validasi-setoran/get-detail') }}",
          type: 'POST',              
          data: data_post,
          success: function(response, status, xhr)
          {
            if( response.success == false){
                $.alert_warning(response.success);
                $('.btn-save').removeClass('disabled', true);
                $(".spinner").css("display", "none");
                return false
            }
              
            _datatables_dt_detail.dt_detail(response.data); 
            },
          error: function(error)
          {
            $.alert_error(error);
            $('.btn-save').removeClass('disabled', true);
            $(".spinner").css("display", "none");
            return false
          }
      });
  }

  $(document).ready(function(){
    mask_number.init();
    _datatables_dt_detail.dt_detail();
    
    $('#lookup_kolektor').dataCollect({
        ajaxUrl: "{{ url('pegawai/datatables') }}",
        ajaxMethod: 'GET',
        ajaxData: function(params){
          return params.jabatan = 'Kolektor'
        },
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN KOLEKTOR',
        modalTxtSelect : 'Pilih Kolektor',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['ID Kolektor','Nama Kolektor','alamat'],
        dtColumns: [
            {data: "id_pegawai"}, 
            {data: "nama_pegawai"}, 
            {data: "alamat"}, 
        ],
        onSelected: function(data, _this){	
          $('#kolektor_id').val(data.id);
          $('#nama_kolektor').val(data.nama_pegawai); 
          calculate();
            
          return true;
        }
    });
  })

  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();
    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data = {
          'tanggal' : $("#tanggal").val(),
          'tanggal_setoran' : $("#tanggal_setoran").val(),
          'kolektor_id' : $("#kolektor_id").val(),
          'total' : mask_number.currency_remove($("#total").val()),
          'keterangan' : $("#keterangan").val()
        }
     data_post = {
          "details" : {},
          "f" : data,
        }

    _datatable.rows().data().each(function (value, index){
          var details_form = {
              'id' : value.id,
              'setoran' : value.setoran,
              'penarikan' : value.penarikan
          }
          data_post.details[index] = details_form;
    });
        
    $.ajax({
        url: $(this).prop('action'),
        type: 'POST',              
        data: data_post,
        success: function(response, status, xhr)
        {
          if( response.status == "error"){
              $.alert_warning(response.message);
              $('.btn-save').removeClass('disabled', true);
              $(".spinner").css("display", "none");
              return false
          }
            
          $.alert_success(response.message);
              setTimeout(function(){
                document.location.href = "{{ url("$nameroutes") }}";        
              }, 500);  
          },
        error: function(error)
        {
          $.alert_error(error);
          $('.btn-save').removeClass('disabled', true);
          $(".spinner").css("display", "none");
          return false
        }
    });
});
</script>

@endsection