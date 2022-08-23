
<form class="form-horizontal form-label-left" method="POST" action="{{ url($submit_url) }}" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kode User *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="form-control" name="f[kode_user]" id="kode_user" value="{{ @$item->kode_user }}" placeholder="Kode User" required="" readonly>
    </div>
  </div>
  <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama *</label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="f[nama]" id="nama" value="{{ @$item->nama }}" placeholder="Nama User" required="">
      </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Username *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" name="f[username]" id="username" class="form-control" placeholder="Username" value="{{ @$item->username }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Password *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="password" name="f[password]" id="password" class="form-control" placeholder="Password" value="{{ @$item->password }}">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Telepon *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" name="f[no_telepon]" id="no_telepon" class="form-control" placeholder="Telepon" value="{{ @$item->no_telepon }}" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jabatan *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <select name="f[jabatan]" class="form-control" required="" id="jabatan">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$option_jabatan as $dt): ?>
          <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->jabatan ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
        <?php endforeach; ?>
      </select>
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
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();
    var formData = new FormData($(this)[0]);
    $.ajax({
            url: $(this).prop('action'),
            type: 'POST',              
            data: formData,
            contentType : false,
            processData : false,
            success: function(response, status, xhr)
            {
                if( response.success == false){
                    $.alert_error(response.message);
                    return false
                }
                $.alert_success(response.message);
                ajax_modal.hide();
                _datatable.ajax.reload(); 
            }
    });
  });
</script>