@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li class="dropdown">
            <button onclick="window.location='{{ url($nameroutes.'/create') }}'"  class="btn btn-success btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('global.label_create') }}</button>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-sm-9 col-sm-offset-1">
        <form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal form-label-left" name="form_crud">
          {{ csrf_field() }}
        <div class="col-sm-9 col-sm-offset-1">
        <form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Transaksi</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" name="f[kode_transaksi_samsat]" id="kode_transaksi_samsat" value="{{ @$item->kode_transaksi_samsat }}" placeholder="Kode Transaksi" required="" readonly>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Transaksi</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="date" class="form-control" name="f[tanggal_samsat]" id="tanggal_samsat" value="{{ date('Y-m-d', strtotime($item->tanggal_samsat)) }}" placeholder="Tanggal Transaksi" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Pelanggan</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group data_collect_wrapper">
                <input type="hidden" value="{{ @$item->pelanggan_id }}" id="pelanggan_id" name="f[pelanggan_id]" required>
                <input type="text" name="f[nama_pelanggan]" id="nama_pelanggan" class="form-control" placeholder="Pelanggan" value="{{ @$item->nama_pelanggan }}" required readonly>
                <div class="input-group-btn">
                  <a href="javascript:;" id="lookup_pelanggan" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Plat Nomor</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="text" class="form-control" name="f[plat_nomor]" id="plat_nomor" value="{{ @$item->plat_nomor }}" placeholder="Plat Motor" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Kendaraan</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select name="f[jenis_kendaraan]" class="form-control" required="" id="jenis_kendaraan">
                <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
                <?php foreach(@$option_jenis_kendaraan as $dt): ?>
                  <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->jenis_kendaraan ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah Tagihan</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group">
                <div class="input-group-btn">
                  <span class="btn btn-default btn-flat">Rp</span>
                </div>
                <input type="text" name="f[jumlah_tagihan]" id="jumlah_tagihan" class="form-control mask-number" placeholder="Jumlah Tagihan" value="{{ @$item->jumlah_tagihan }}" required="">
              </div>
              </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Biaya Jasa</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group">
                <div class="input-group-btn">
                  <span class="btn btn-default btn-flat">Rp</span>
                </div>
                <input type="text" class="form-control mask-number" name="f[biaya_jasa]" id="biaya_jasa" value="{{ @$item->biaya_jasa }}" placeholder="Biaya jasa" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Pembayaran</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select name="f[jenis_pembayaran]" class="form-control" required="" id="jenis_pembayaran">
                <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
                <?php foreach(@$option_jenis_pembayaran as $dt): ?>
                  <option value="<?php echo @$dt['id'] ?>" <?= @$dt['id'] == @$item->jenis_pembayaran ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Lunas</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <input type="date" class="form-control" name="f[tanggal_lunas]" id="tanggal_lunas" value="{{ date('Y-m-d', strtotime($item->tanggal_lunas)) }}" placeholder="Tanggal Lunas" required="">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Total Bayar</label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="input-group">
                <div class="input-group-btn">
                  <span class="btn btn-default btn-flat">Rp</span>
                </div>
                <input type="text" class="form-control mask-number" name="f[total_bayar]" id="total_bayar" value="{{ @$item->total_bayar }}" placeholder="Total Bayar" autocomplete="off" readonly>
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
                <button type="submit" class="btn btn-success btn-save">@if($is_edit) Perbarui @else Simpan @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
              </div>
          </div>
        </form>
      </div>
    </div>
    </div>
  </div>
</div>
</div>
      

<script type="text/javascript">
  $(document).on("keyup",'#jumlah_tagihan,#biaya_jasa', calculate);

  function calculate() {
      var jumlah_tagihan = mask_number.currency_remove($('#jumlah_tagihan').val());
          biaya_jasa = mask_number.currency_remove($('#biaya_jasa').val());
          total_bayar = jumlah_tagihan + biaya_jasa;
          $("#total_bayar").val(mask_number.currency_add(total_bayar));
  }
  $(document).ready(function(){
    calculate();
    mask_number.init()
    
    $('#lookup_pelanggan').dataCollect({
        ajaxUrl: "{{ url('pelanggan/datatables') }}",
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN PELANGGAN',
        modalTxtSelect : 'Pilih Pelanggan',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['Kode Pelanggan','Nama Pelanggan','Alamat'],
        dtColumns: [
            {data: "kode"}, 
            {data: "nama"}, 
            {data: "alamat"}, 
        ],
        onSelected: function(data, _this){	
          $('#pelanggan_id').val(data.id);
          $('#nama_pelanggan').val(data.nama); 
            
          return true;
        }
    });
  })

  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();
    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data = {
          'biaya_jasa' : mask_number.currency_remove($("#biaya_jasa").val()),
          'jumlah_tagihan' : mask_number.currency_remove($("#jumlah_tagihan").val()),
          'total_bayar' : mask_number.currency_remove($("#total_bayar").val()),
          'pelanggan_id' : $("#pelanggan_id").val(),
          'tanggal_samsat' : $("#tanggal_samsat").val(),
          'tanggal_lunas' : $("#tanggal_lunas").val(),
          'keterangan' : $("#keterangan").val(),
          'kode_transaksi_samsat' : $("#kode_transaksi_samsat").val(),
          'jenis_kendaraan' : $("#jenis_kendaraan").val(),
          'jenis_pembayaran' : $("#jenis_pembayaran").val(),
          'plat_nomor' : $("#plat_nomor").val(),
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
              }, 1000);  
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