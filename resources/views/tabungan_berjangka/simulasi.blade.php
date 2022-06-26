<form action="" class="form-horizontal" style="z-index: 9999!important">
  {{ csrf_field() }}
  <div class="col-lg-6">
    <div class="form-group">
      <label class="col-lg-6 control-label">Nominal Setoran Per Bulan</label>
      <div class="col-lg-6">
        : <label class="control-label">Rp. {{ number_format(@$item->nominal_tabungan_berjangka, 2) }}</label>
      </div>
    </div>
    <div class="form-group">
      <label class="col-lg-6 control-label">Bunga</label>
      <div class="col-lg-6">
        : <label class="control-label">{{ @$item->bunga_tabungan_berjangka }} %</label>
      </div>
    </div>
    <div class="form-group">
      <label class="col-lg-6 control-label">Total Bunga</label>
      <div class="col-lg-6">
        : <label class="control-label">Rp. {{ number_format(@$item->total_bunga,2) }}</label>
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="form-group">
      <label class="col-lg-6 control-label">Jangka Waktu</label>
      <div class="col-lg-6">
        : <label class="control-label">{{ @$item->jangka_waktu }} Tahun</label>
      </div>
    </div>
    <div class="form-group">
      <label class="col-lg-6 control-label">Total Saldo Akhir</label>
      <div class="col-lg-6">
        : <label class="control-label">Rp. {{ number_format(@$item->total_tabungan_berjangka,2) }}</label>
      </div>
    </div>
  </div>
  <br>
  <hr>
  <div class="box-body">
    <div class="col-lg-12">
      <table class="table table-striped table-hover" id="dt_pinjaman" width="100%">   
        <thead>
          <tr>
            <th>Periode</th>
            <th>Setoran</th>
            <th>Bunga</th>
            <th>Saldo Akhir</th>
          </tr>
        </thead>
        <tbody>
          @foreach($collections as $row)
            <tr>
              <td>{{ $row['periode'] }}</td>
              <td>{{ number_format($row['setoran'],2) }}</td>
              <td>{{ number_format($row['bunga'],2) }}</td>
              <td>{{ number_format($row['saldo_akhir'],2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="form-group">
      <div class="col-lg-12">
        <button type="button" class="btn btn-warning btn-block" data-dismiss="modal">Tutup</button>
      </div>
  </div>
</form>
      

<script type="text/javascript">
  $(document).ready(function(){
    
  })
</script>