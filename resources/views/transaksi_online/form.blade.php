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
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Transaksi</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="text" class="form-control" name="f[kode_transaksi_online]" id="kode_transaksi_online" value="{{ @$item->kode_transaksi_online }}" placeholder="Kode Transaksi Online" required="" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Tanggal Transaksi</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input type="date" class="form-control" name="f[tanggal]" id="tanggal" value="{{ date('Y-m-d', strtotime($item->tanggal)) }}" placeholder="Tanggal Transaksi" required="">
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
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Jenis Transaksi</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select name="f[jenis_transaksi_id]" class="form-control" required="" id="jenis_transaksi_id">
                  <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
                  <?php foreach(@$option_jenis_transaksi as $dt): ?>
                    <option value="<?php echo @$dt->id ?>" <?= @$dt->id == @$item->jenis_transaksi_id ? 'selected': null ?>><?php echo @$dt->nama ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12">Jumlah</label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="input-group">
                  <div class="input-group-btn">
                    <span class="btn btn-default btn-flat">Rp</span>
                  </div>
                  <input type="text" name="f[jumlah]" id="jumlah" class="form-control mask-number" placeholder="Jumlah" value="{{ @$item->jumlah }}" required="">
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
                <select name="f[keterangan]" class="form-control" required="" id="keterangan">
                  <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
                  <option value="Lunas" <?= 'Lunas' == @$item->keterangan ? 'selected': null ?>>Lunas</option>
                  <option value="Tidak Lunas" <?= 'Tidak Lunas' == @$item->keterangan ? 'selected': null ?>>Tidak Lunas</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-offset-3 col-lg-9">
                <button type="submit" class="btn btn-success btn-save" {{ @$item->ada_perubahan == 1 ? 'disabled' : '' }}>@if($is_edit) Perbarui @else Simpan @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
              <br><br>
              @if(@$item->ada_perubahan == 1)
                <p style="color: red"><i>* Terdapat perubahan data yang belum divalidasi <a href="javascript:void(0)" id="modalPerubahan" style="color: blue">Lihat perubahan</a></i></p>
              @endif
              </div>
            </div>
          </form>
        </div>
      </div>
      </div>
    </div>
  </div>
      

<script type="text/javascript">
    var log_id = "{{ $item->log_id }}";
    let lookup_modal_perubahan = {
      init: function() {
          $('#modalPerubahan').on( "click", function(e){
            e.preventDefault();
            var _prop= {
              _this : $( this ),
              remote : "{{ url("$nameroutes") }}/perubahan/" + log_id,
              size : 'modal-lg',
              title : "DATA PERUBAHAN TERAKHIR",
            }
            ajax_modal.show(_prop);											
          });  
        },
    };


  $(document).on("keyup",'#jumlah,#biaya_jasa', calculate);

  function calculate() {
      var jumlah = mask_number.currency_remove($('#jumlah').val());
          biaya_jasa = mask_number.currency_remove($('#biaya_jasa').val());
          total_bayar = jumlah + biaya_jasa;
          $("#total_bayar").val(mask_number.currency_add(total_bayar));
  }
  $(document).ready(function(){
    calculate();
    mask_number.init()
    lookup_modal_perubahan.init();
    
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
          'jumlah' : mask_number.currency_remove($("#jumlah").val()),
          'total_bayar' : mask_number.currency_remove($("#total_bayar").val()),
          'pelanggan_id' : $("#pelanggan_id").val(),
          'tanggal' : $("#tanggal").val(),
          'keterangan' : $("#keterangan").val(),
          'kode_transaksi_online' : $("#kode_transaksi_online").val(),
          'jenis_transaksi_id' : $("#jenis_transaksi_id").val(),
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

@endsection