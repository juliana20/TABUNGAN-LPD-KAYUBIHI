@extends('themes.gentelella.template.template')
@section('content')
<style>
  .form-horizontal .control-label {
    text-align: left!important;
}
</style>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li class="dropdown">
            <a href="{{ url($nameroutes."/cetak-nota/{$item->id}") }}" target="_blank" class="btn" style="color:#000"><i class="fa fa-print" aria-hidden="true"></i> Cetak Nota Transaksi</a>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-sm-10 col-sm-offset-1">
        <form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
          <div class="form-group">
            <label class="col-lg-3 control-label">Kode Transaksi</label>
            <div class="col-lg-9">
              <label class="control-label">: {{ $item->kode_transaksi_online }}</label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Tanggal Transaksi</label>
            <div class="col-lg-9">
              <label class="control-label">: {{ date('d-m-Y', strtotime($item->tanggal)) }}</label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Pelanggan</label>
            <div class="col-lg-9">
              <label class="control-label">: {{ @$item->nama_pelanggan }}</label>
            </div>
          </div>
        </form>
          <table class="table table-bordered table-hover" width="100%">   
            <thead>
              <tr>
                <th>Jenis Transaksi</th>
                <th>Jumlah Tagihan</th>
                <th>Biaya Jasa</th>
                <th>Total Bayar</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $item->jenis_transaksi }}</td>
                <td>Rp. {{ number_format($item->jumlah, 0) }}</td>
                <td>Rp. {{ number_format($item->biaya_jasa, 0) }}</td>
                <td>Rp. {{ number_format($item->total_bayar, 0) }}</td>
                <td>{{ $item->keterangan }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>    
      

<script type="text/javascript">
  $(document).ready(function(){
    mask_number.init()
  })
</script>

@endsection