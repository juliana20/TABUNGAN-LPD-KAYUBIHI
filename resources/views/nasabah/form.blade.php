<form class="form-horizontal form-label-left" method="POST" action="{{ url($submit_url) }}" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">ID Nasabah *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="form-control" name="f[id_nasabah]" id="id_nasabah" value="{{ @$item->id_nasabah }}" placeholder="ID Nasabah" required="" readonly>
    </div>
  </div>
  <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama Nasabah *</label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="f[nama_nasabah]" id="nama_nasabah" value="{{ @$item->nama_nasabah }}" placeholder="Nama Nasabah" required="">
      </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kelamin *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <select name="f[jenis_kelamin]" class="form-control" required="" id="jenis_kelamin">
        <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
        <?php foreach(@$option_jenis_kelamin as $dt): ?>
          <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->jenis_kelamin ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Alamat *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <textarea name="f[alamat]" id="alamat" cols="30" rows="2" class="form-control" required>{{ @$item->alamat }}</textarea>
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Telepon *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" name="f[telepon]" id="telepon" class="form-control" placeholder="Telepon" value="{{ @$item->telepon }}" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Pekerjaan *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" name="f[pekerjaan]" id="pekerjaan" class="form-control" placeholder="Pekerjaan" value="{{ @$item->pekerjaan }}" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Lahir *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="date" name="f[tanggal_lahir]" id="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" value="{{ @$item->tanggal_lahir }}" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">No KTP *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" name="f[no_ktp]" id="no_ktp" class="form-control" placeholder="No KTP" data-inputmask="&quot;mask&quot;: &quot;9999999999999999&quot;" data-mask="" value="{{ @$item->no_ktp }}" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Daftar *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="date" name="f[tanggal_daftar]" id="tanggal_daftar" class="form-control" placeholder="Tanggal Daftar" value="{{ @$item->tanggal_daftar }}" required="">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Foto KTP *</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="hidden" id="image_name" class="form-control" value="{{ @$item->foto_ktp }}" name="f[foto_ktp]">
      <input type="file" id="input-file" class="form-control image uploader" name="foto_ktp" value="{{ @$item->foto_ktp }}">
      <img id="newavatar" src="@if($is_edit) {{url('ktp/'.@$item->foto_ktp)}}  @else @endif" class="profile-img-tag" style="width: 100px;margin-bottom: 6px"/>
    </div>
  </div>
  @if(!@$is_edit)
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Username *</label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" name="u[username]" class="form-control" placeholder="Username" value="{{ @$item->username }}" required="">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Password *</label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="password" name="u[password]" class="form-control" placeholder="Password" value="{{ @$item->password }}" required="">
      </div>
    </div>
  @endif
  <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button id="submit_form" type="submit" class="btn btn-success btn-save">@if($is_edit) Perbarui @else Simpan @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
      </div>
  </div>
</form>
      

<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('.profile-img-tag').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    }
    $(".image").change(function(){
        readURL(this);
    });
    
  $(document).ready(function() {
      $('[data-mask]').inputmask();
  });
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data_post = new FormData($(this)[0]);

    $.ajax({
        url: $(this).prop('action'),
        type: 'POST',              
        data: data_post,
        contentType : false,
        processData : false,
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