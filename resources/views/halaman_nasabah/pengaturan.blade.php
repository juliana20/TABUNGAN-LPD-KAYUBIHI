@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_panel">
        <div class="x_content">
          <form class="form-horizontal form-label-left" method="POST" action="{{ @$submit_url }}" name="form_reset_password">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Password Lama</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="password" name="f[password_lama]" id="password_lama" class="form-control" placeholder="Masukkan Password Lama" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Password Baru</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="password" name="f[password_baru]" id="password_baru" class="form-control" placeholder="Masukkan Password Baru" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Konfirmasi Password Baru</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="password" name="f[konfirmasi_password_baru]" id="konfirmasi_password_baru" class="form-control" placeholder="Masukkan Konfirmasi Password Baru" required="">
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
  $('form[name="form_reset_password"]').on('submit',function(e) {
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
          setTimeout(function(){
              location.reload();
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

