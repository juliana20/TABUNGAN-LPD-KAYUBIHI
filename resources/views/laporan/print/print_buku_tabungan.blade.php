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
      {{ !empty($params->nama_nasabah) ? $params->nama_nasabah : '' }} <br>
    </h4>
    <div class="container">
        <table width="100%">
          <thead>
            <tr>
              <th style="text-align: center!important">No</th>
              <th>Tanggal</th>
              <th>Penyetoran</th>
              <th>Pengambilan</th>
              <th>Sisa</th>
              <th>Petugas</th>
            </tr>
          </thead>
          <tbody>
            @php $no = 1; $bunga = 0; $saldo = 0; @endphp
            @if(!empty($item)) 
              @foreach($item as $row)
              @php 
                $nominal_setoran = !empty($row['nominal_setoran']) ? $row['nominal_setoran'] : 0;
                $nominal_penarikan = !empty($row['nominal_penarikan']) ? $row['nominal_penarikan'] : 0;
                $bunga +=  $row['nominal_bunga'];
                $saldo_akhir = $row['saldo_akhir'];
                if($loop->last):
                  $saldo = $row['saldo_akhir'];
                endif
              @endphp
                <tr>
                  <td align="center">{{ $no++ }}</td>
                  @if($row['nominal_bunga'] > 0 )
                    <td colspan="5">{{ $row['nominal_bunga'] > 0 ? 'Bunga : '. 'Rp.'. number_format($row['nominal_bunga'], 2) : date('d-m-Y', strtotime($row['tanggal'])) }}</td>
                  @else
                    <td>{{ $row['nominal_bunga'] > 0 ? 'Bunga' : date('d-m-Y', strtotime($row['tanggal'])) }}</td>
                    <td align="right">{{ $row['nominal_bunga'] > 0 ? '' : 'Rp.'. number_format($nominal_setoran, 2) }}</td>
                    <td align="right" style="color: rgb(247, 4, 4)">{{ $row['nominal_bunga'] > 0 ? '' : 'Rp.'. number_format($nominal_penarikan, 2) }}</td>
                    <td align="right">Rp. {{ number_format($saldo_akhir, 2) }}</td>
                    <td>{{ $row['kolektor'] }}</td>
                  @endif
                  
                </tr>
              @endforeach
            @else
              <tr>
                <td colspan="6" align="center">Tidak terdapat data</td>
              </tr>
            @endif
            </tbody>
            <tfoot>
              <tr>
                <td colspan="2">Total Bunga</td>
                <td><strong>Rp. {{ number_format($bunga, 2) }}</strong></td>
                <td style="text-align: right">Saldo Akhir</td>
                <td colspan="2"><strong>Rp. {{ number_format($saldo + $bunga, 2) }}</strong></td>
              </tr>
            </tfoot>
        </table>
        <br>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>