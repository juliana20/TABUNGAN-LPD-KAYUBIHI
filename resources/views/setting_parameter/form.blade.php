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
<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal form-label-left" name="form_crud">
  {{ csrf_field() }}
  <div class="box-body">
    <div class="form-group">
        <label class="control-label col-md-3 col-sm-3 col-xs-12">Biaya Jasa Bumdes</label>
        <div class="col-md-9 col-sm-9 col-xs-12">
          <input type="text" class="form-control mask-number" name="f[biaya_jasa]" id="biaya_jasa" value="{{ Helpers::config_item('biaya_jasa') }}" placeholder="Biaya Jasa" required="">
        </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Upah Pungut</label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control mask-number" name="f[upah_pungut]" id="upah_pungut" value="{{ Helpers::config_item('upah_pungut') }}" placeholder="Upah Pungut" required="">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-md-3 col-sm-3 col-xs-12">Vendor</label>
      <div class="col-md-9 col-sm-9 col-xs-12">
        <input type="text" class="form-control mask-number" name="f[biaya_vendor]" id="biaya_vendor" value="{{ Helpers::config_item('biaya_vendor') }}" placeholder="Biaya Vendor" required="">
      </div>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-3 col-lg-9">
          <button type="submit" class="btn btn-success btn-save">Simpan<i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
        </div>
    </div>
  </div>
</form>
</div>
</div>
</div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
      mask_number.init();
  });
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();
    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data = {
          'biaya_jasa' : mask_number.currency_remove($("#biaya_jasa").val()),
          'upah_pungut' : mask_number.currency_remove($("#upah_pungut").val()),
          'biaya_vendor' : mask_number.currency_remove($("#biaya_vendor").val())
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
                document.location.href = "{{ url('setting-parameter') }}";        
              }, 500);  
      }).catch(error => {
            $.alert_error(error);
            $('.btn-save').removeClass('disabled', true);
            $(".spinner").css("display", "none");
            return false
      });
});
</script>

@endsection