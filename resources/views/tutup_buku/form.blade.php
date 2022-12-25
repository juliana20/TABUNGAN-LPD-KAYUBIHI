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
              <input type="date" class="form-control" name="f[tanggal]" id="tanggal" value="{{ date('Y-m-d', strtotime($item->tanggal)) }}" placeholder="Tanggal Validasi" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Setoran</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group">
                <div class="input-group-btn">
                  <span class="btn btn-default btn-flat">Rp</span>
                </div>
                <input type="text" name="f[total_setoran]" id="total_setoran" class="form-control mask-number" placeholder="Total Setoran" value="{{ @$item->total_setoran }}" required="" disabled>
              </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Penarikan</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="input-group">
                  <div class="input-group-btn">
                    <span class="btn btn-default btn-flat">Rp</span>
                  </div>
                  <input type="text" name="f[total_penarikan]" id="total_penarikan" class="form-control mask-number" placeholder="Total Penarikan" value="{{ @$item->total_penarikan }}" required="" disabled>
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
                <button type="submit" class="btn btn-success btn-save">Tutup Buku <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
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
  $(document).on("change",'#tanggal', calculate);

  function calculate() {
    var tanggal = $('#tanggal').val();

        var data_post = {
              'tanggal' : tanggal
        }

        if(!tanggal)
        {
          alert('Silahkan pilih tanggal tutup buku terlebih dahulu');
          return false
        }

        $.ajax({
          url: "{{ url('tutup-buku/get-detail') }}",
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
              
            $('#total_setoran').val(mask_number.currency_add(response.total_setoran));
            $('#total_penarikan').val(mask_number.currency_add(response.total_penarikan));
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
    calculate();
    
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
          'total_setoran' : mask_number.currency_remove($("#total_setoran").val()),
          'total_penarikan' : mask_number.currency_remove($("#total_penarikan").val()),
          'keterangan' : $("#keterangan").val()
        }
     data_post = {
          "f" : data,
        }
        
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