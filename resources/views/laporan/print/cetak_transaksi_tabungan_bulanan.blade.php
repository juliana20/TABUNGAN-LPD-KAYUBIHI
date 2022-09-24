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
              <th>ID Nasabah</th>
              <th>Nama Nasabah</th>
              <th>Simpanan</th>
              <th>Penarikan</th>
              <th>Kolektor</th>
            </tr>
          </thead>
          <tbody>
            @php $no = 1; $jumlah_setoran = 0; $jumlah_penarikan = 0; @endphp
            @if(!empty($item)) 
              @foreach($item as $row)
              @php 
                $nominal_setoran = !empty($row['nominal_setoran']) ? $row['nominal_setoran'] : 0;
                $nominal_penarikan = !empty($row['nominal_penarikan']) ? $row['nominal_penarikan'] : 0;
                $jumlah_setoran += $nominal_setoran; 
                $jumlah_penarikan += $nominal_penarikan; 
              @endphp
                <tr>
                  <td align="center">{{ $no++ }}</td>
                  <td>{{ $row['id_nasabah'] }}</td>
                  <td>{{ $row['nama_nasabah'] }}</td>
                  <td align="right">Rp. {{ number_format($nominal_setoran, 2) }}</td>
                  <td align="right">Rp. {{ number_format($nominal_penarikan, 2) }}</td>
                  <td>{{ $row['kolektor'] }}</td>
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
              <td colspan="3" align="right"><b>Total</b></td>
              <td align="right"><b>Rp. {{ number_format($jumlah_setoran, 2) }}</b></td>
              <td align="right"><b>Rp. {{ number_format($jumlah_penarikan, 2) }}</b></td>
              <td></td>
            </tr>
          </tfoot>

        </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>