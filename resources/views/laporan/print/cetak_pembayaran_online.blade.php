<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ @$title }} {{config('app.app_name')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="{{url('themes/default/images/favicon.ico')}}">
    <link rel="stylesheet" href="{{ url('themes/default/css/style_report.css')}}">
</head>
<body>
    <h3 align="center">
      {{config('app.app_alias')}} {{config('app.area')}} <br>
      {{config('app.address')}}<hr>
    </h3>
    <h4 align="center">
      {{ @$title }} <br>
      Periode : {{ date('d-m-Y', strtotime($params->date_start)) ." s/d ". date('d-m-Y', strtotime($params->date_end)) }}
    </h4>
    <div class="container">
        <table width="100%">
          <thead>
            <tr>
              <th style="text-align: center!important">No</th>
              <th>No. Transaksi</th>
              <th>Nama Pelanggan</th>
              <th>Tanggal Transaksi</th>
              <th>Jenis Transaksi</th>
              <th>Jumlah Tagihan</th>
              <th>Biaya Jasa</th>
              <th>Total Bayar</th>
            </tr>
          </thead>
          <tbody>
            @php $no = 1;$jumlah_tagihan = 0; $biaya_jasa = 0; $total_bayar = 0; @endphp
            @if(!empty($item)) 
              @foreach($item as $row)
              @php 
                $jumlah_tagihan += $row->jumlah; 
                $biaya_jasa += $row->biaya_jasa; 
                $total_bayar += $row->total_bayar;  
              @endphp
                <tr>
                  <td align="center">{{ $no++ }}</td>
                  <td>{{ $row->kode_transaksi_online }}</td>
                  <td>{{ $row->nama_pelanggan }}</td>
                  <td>{{ date('d M Y',strtotime($row->tanggal)) }}</td>
                  <td>{{ $row->jenis_transaksi }}</td>
                  <td>Rp. {{ number_format($row->jumlah, 2) }}</td>
                  <td>Rp. {{ number_format($row->biaya_jasa, 2) }}</td>
                  <td>Rp. {{ number_format($row->total_bayar, 2) }}</td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="8" align="center">Tidak terdapat data</td>
              </tr>
            @endif
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" align="right"><b>Total</b></td>
              <td><b>Rp. {{ number_format($jumlah_tagihan, 2) }}</b></td>
              <td><b>Rp. {{ number_format($biaya_jasa, 2) }}</b></td>
              <td><b>Rp. {{ number_format($total_bayar, 2) }}</b></td>
            </tr>
          </tfoot>

        </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>