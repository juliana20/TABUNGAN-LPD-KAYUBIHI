
<form class="form-horizontal form-label-left" method="POST" action="{{ url($submit_url) }}" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Nama *</label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control" name="f[nama]" id="nama" value="{{ @$item->nama }}" placeholder="Nama Jenis Transaksi" required="">
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
  $(document).ready(function() {
      mask_number.init();
  });
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();
    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data = {
          'nama' : $("#nama").val()
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
          _datatable.ajax.reload();  
      }).catch(error => {
            $.alert_error(error);
            $('.btn-save').removeClass('disabled', true);
            $(".spinner").css("display", "none");
            return false
      });
});
</script>