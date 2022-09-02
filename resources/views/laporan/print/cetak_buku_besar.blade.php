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
      <h4>{{ $akun->kode_akun }} {{ @$akun->nama_akun }}</h4>
        <table width="100%">
          <thead>
            <tr>
              <th style="text-align: center!important">No</th>
              <th>Tanggal</th>
              <th>No Bukti</th>
              <th>Keterangan</th>
              <th>Debet</th>
              <th>Kredit</th>
              <th>Saldo Akhir</th>
            </tr>
          </thead>
          <tbody>
            <?php  $no = 1;$debet = 0; $kredit = 0;$saldo_akhir = 0; $saldo_awal_bulan = @$saldo_awal + @$saldo_akhir_bulan_lalu; ?>
              <tr>
                <td align="center">{{ $no++ }}</td>
                <td>{{ date('01 M Y',strtotime($params->date_start)) }}</td>
                <td>SA</td>
                <td>Saldo Awal</td>
                <td>Rp. {{ number_format(0, 2) }}</td>
                <td>Rp. {{ number_format(0, 2) }}</td>
                <td>Rp. {{ number_format($saldo_awal_bulan, 2) }}</td>
              </tr>
            @if(!empty($item)) 
              @foreach($item as $row)
              @php
                $debet += $row->debet; 
                $kredit += $row->kredit; 
                //jika akun pendapatan
                if(in_array($params->akun_id, [5, 6, 7]) || $akun->kelompok == 'Aktiva Tetap'){
                  $saldo_akhir = ( $row->debet > 0) ? $saldo_akhir - $row->debet : $saldo_akhir  + $row->kredit;
                }else{
                  $saldo_akhir = ( $row->debet > 0) ? $saldo_akhir + $row->debet : $saldo_akhir  - $row->kredit;
                }
              @endphp
                <tr>
                  <td align="center">{{ $no++ }}</td>
                  <td>{{ date('d M Y',strtotime($row->tanggal)) }}</td>
                  <td>{{ $row->kode_jurnal }}</td>
                  <td>{{ $row->keterangan }}</td>
                  <td>Rp. {{ number_format($row->debet, 2) }}</td>
                  <td>Rp. {{ number_format($row->kredit, 2) }}</td>
                  <td>Rp. {{ number_format($saldo_akhir + $saldo_awal_bulan, 2) }}</td>
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6" align="center">Tidak terdapat data</td>
              </tr>
            @endif
          </tbody>
          <tfoot>

          </tfoot>

        </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>