<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal form-label-left" name="form_crud">
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
</form>

<script>
    $(document).ready(function(){
      mask_number.init()
    });
</script>