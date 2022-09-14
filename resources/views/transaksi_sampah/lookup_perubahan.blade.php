<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal form-label-left" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="control-label col-md-3 col-sm-3 col-xs-12">Kode Transaksi</label>
    <div class="col-md-9 col-sm-9 col-xs-12">
      <input type="text" class="form-control" name="f[kode_transaksi_sampah]" id="kode_transaksi_sampah" value="{{ @$item->kode_transaksi_sampah }}" placeholder="Kode Transaksi Sampah" required="" readonly>
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
        <input type="text" name="f[nama_pelanggan]" id="nama_pelanggan" class="form-control" placeholder="Pelanggan" value="{{ @$item->nama_pelanggan }}" required readonly>
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
  {{-- <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <button type="submit" class="btn btn-success btn-save" {{ @$item->ada_perubahan == 1 ? 'disabled' : '' }}>@if($is_edit) Perbarui @else Simpan @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
      <br><br>
      @if(@$item->ada_perubahan == 1)
        <p style="color: red"><i>* Terdapat perubahan data yang belum divalidasi <a href="javascript:void(0)" id="modalPerubahan" style="color: blue">Lihat perubahan</a></i></p>
      @endif
      </div>
      
  </div>
   --}}
</form>

<script>
    $(document).ready(function(){
      mask_number.init()
    });
</script>