<form class="form-horizontal form-label-left" method="POST" action="{{ url($submit_url) }}" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Nasabah</label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" value="{{ @$item->nama_nasabah }}" readonly>
      </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">No Rekening</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="form-control" value="{{ @$item->no_rekening }}" required="" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Saldo</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="form-control mask-number" name="f[saldo_awal]" id="saldo_awal" value="{{ @$item->saldo_awal }}" required="" readonly>
    </div>
  </div>
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
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Saldo Akhir</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <div class="input-group">
        <div class="input-group-btn">
          <span class="btn btn-default btn-flat">Rp</span>
        </div>
        <input type="text" name="f[saldo_akhir]" id="saldo_akhir" class="form-control mask-number" placeholder="Saldo Akhir" value="{{ @$item->saldo_akhir }}" required="" readonly>
      </div>
    </div>
  </div>
  <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button id="submit_form" type="submit" class="btn btn-success btn-save">@if($is_edit) Perbarui @else Simpan @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
      </div>
  </div>
</form>
      

<script type="text/javascript">
  $(document).on("keyup",'#nominal_setoran', calculate);

  function calculate() {
      var saldo_awal = mask_number.currency_remove($('#saldo_awal').val());
          nominal_setoran = mask_number.currency_remove($('#nominal_setoran').val());
          saldo_akhir = saldo_awal + nominal_setoran;
          $("#saldo_akhir").val(mask_number.currency_add(saldo_akhir));
  }
  $(document).ready(function(){
    calculate();
    mask_number.init()
  });
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data = {
          'saldo_awal' : mask_number.currency_remove($("#saldo_awal").val()),
          'nominal_setoran' : mask_number.currency_remove($("#nominal_setoran").val()),
          'saldo_akhir' : mask_number.currency_remove($("#saldo_akhir").val()),
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
          ajax_modal.hide();
          _datatable.ajax.reload(); 
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