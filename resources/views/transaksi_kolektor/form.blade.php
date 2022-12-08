@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_content">
          <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">No Rekening Nasabah</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <form class="form-horizontal form-label-left" method="POST" action="{{ url('transaksi-kolektor/transaksi') }}" name="form_crud">
                {{ csrf_field() }}
                  <div class="input-group">
                    <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;9999&quot;" data-mask="" name="no_rekening" value="{{ @$params }}" placeholder="Masukkan No Rekening Nasabah..." required>
                    <div class="input-group-btn">
                      <button id="submit_form" type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Cari</button> 
                    </div>
                  </div>
                </form>
              </div>
          </div>
      </div>
    </div>
    <div class="x_panel">
      <div class="x_content">
          <div class="form-group">
            <label class="control-label col-md-12 col-sm-12 col-xs-12">No Rekening : {{ @$item->no_rekening }}</label>
          </div>
          <div class="form-group">
              <label class="control-label col-md-12 col-sm-12 col-xs-12">Nama Nasabah : {{ @$item->nama_nasabah }}</label>
          </div>
      </div>
    </div>
      <div class="x_panel">
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="POST" action="{{ url("transaksi-kolektor/proses-transaksi/$item->no_rekening") }}" name="form_proses_transaksi">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="date" name="f[tanggal]" id="tanggal" class="form-control" placeholder="Tanggal" value="{{ @$item->tanggal }}" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nominal Setoran</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group">
                <div class="input-group-btn">
                  <span class="btn btn-default btn-flat">Rp</span>
                </div>
                <input type="text" name="f[nominal_setoran]" id="nominal_setoran" class="form-control mask-number" placeholder="Nominal Setoran" value="{{ @$item->nominal_setoran }}" required="">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Nominal Penarikan</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group">
                <div class="input-group-btn">
                  <span class="btn btn-default btn-flat">Rp</span>
                </div>
                <input type="text" name="f[nominal_penarikan]" id="nominal_penarikan" class="form-control mask-number" placeholder="Nominal Penarikan" value="{{ @$item->nominal_penarikan }}" required="">
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-offset-3 col-lg-9 pull-right">
                <button id="submit_form" type="submit" class="btn btn-success btn-save">Simpan <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
              </div>
          </div>
          </form>
        </div>
      </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $( "#nominal_setoran" ).keyup(function() {
    if($(this).val() != 0){
      $('#nominal_penarikan').prop('disabled', true);
    }else{
      $('#nominal_penarikan').prop('disabled', false);
    }
  });
  $( "#nominal_penarikan" ).keyup(function() {
    if($(this).val() != 0){
      $('#nominal_setoran').prop('disabled', true);
    }else{
      $('#nominal_setoran').prop('disabled', false);
    }
  });
})
  $('form[name="form_proses_transaksi"]').on('submit',function(e) {
    e.preventDefault();

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");
    var data = {
          'nominal_setoran' : mask_number.currency_remove($("#nominal_setoran").val()),
          'nominal_penarikan' : mask_number.currency_remove($("#nominal_penarikan").val()),
          'tanggal' : $("#tanggal").val(),
        }
     data_post = {
          "f" : data,
        }

    $.ajax({
        url: $(this).prop('action'),
        type: 'POST',              
        data: data_post,
        // contentType : false,
        // processData : false,
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
              document.location.href = "{{ url('transaksi-kolektor') }}";  
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
<!-- DataTable -->
@endsection

