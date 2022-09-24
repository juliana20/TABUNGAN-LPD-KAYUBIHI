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
                    <input type="text" class="form-control" data-inputmask="&quot;mask&quot;: &quot;9999&quot;" data-mask="" name="no_rekening" placeholder="Masukkan No Rekening Nasabah..." required>
                    <div class="input-group-btn">
                      <button id="submit_form" type="submit" class="btn btn-info btn-flat"><i class="fa fa-search"></i> Cari</button> 
                    </div>
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>
  </div>
</div>
<!-- DataTable -->
@endsection
 
