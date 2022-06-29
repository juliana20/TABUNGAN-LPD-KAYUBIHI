<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">Golongan Akun *</label>
    <div class="col-lg-9">
      <select name="f[golongan]" class="form-control" required="" id="golongan">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$option_golongan as $dt): ?>
          <option data-level="{{ @$dt['level'] }}" value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->golongan ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Kelompok Akun *</label>
    <div class="col-lg-9">
      <select name="f[kelompok]" class="form-control" required="" id="kelompok">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$option_kelompok as $dt): ?>
          <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->kelompok ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Kode Akun *</label>
    <div class="col-lg-1">
      <input type="text" class="form-control" id="golongan_akun" value="{{ substr(@$item->kode_akun, 0, 1) }}" placeholder="" required="" readonly>
    </div>
    <div class="col-lg-8">
      <input type="text" class="form-control" name="f[kode_akun]" id="kode_akun" value="{{ substr(@$item->kode_akun,1) }}" placeholder="Kode Akun" required="">
    </div>
  </div>
  <div class="form-group">
      <label class="col-lg-3 control-label">Nama Akun *</label>
      <div class="col-lg-9">
        <input type="text" class="form-control" name="f[nama_akun]" id="nama_akun" value="{{ @$item->nama_akun }}" placeholder="Nama Akun" required="">
      </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Normal Pos *</label>
    <div class="col-lg-9">
      <select name="f[normal_pos]" class="form-control" required="" id="normal_pos">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$option_normal_pos as $dt): ?>
          <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->normal_pos ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Saldo Awal *</label>
    <div class="col-lg-9">
      <input type="text" class="form-control mask-number" name="f[saldo_awal]" id="saldo_awal" value="{{ @$item->saldo_awal }}" placeholder="Saldo Awal" required="">
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
  $('#golongan').change(function(){
    $( "#golongan_akun" ).val($(this).find(':selected').attr('data-level'));
  });
  $(document).ready(function() {
      mask_number.init();
  });
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();
    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data = {
          'golongan' : $("#golongan").val(),
          'kelompok' : $("#kelompok").val(),
          'kode_akun' : $("#golongan_akun").val() + $("#kode_akun").val(),
          'nama_akun' : $("#nama_akun").val(),
          'normal_pos' : $("#normal_pos").val(),
          'saldo_awal' : mask_number.currency_remove($("#saldo_awal").val())
        }
     data_post = {
          "f" : data,
        }

  $.post($(this).attr("action"), data_post, function(response, status, xhr) {
      if( response.status == "error"){
          $.alert_warning(response.message);
              $('.btn-save').removeClass('disabled', true);
              $(".spinner").css("display", "none");
              return false
          }
          $.alert_success(response.message);
              ajax_modal.hide();
              setTimeout(function(){
                document.location.href = "{{ url("$nameroutes") }}";        
              }, 500);  
      }).catch(error => {
            $.alert_error(error);
            $('.btn-save').removeClass('disabled', true);
            $(".spinner").css("display", "none");
            return false
      });
});
</script>