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
    <style>
      table, tr, th, td{
        border: 0px!important;
      }
    </style>
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
        <tr>
          <th colspan="3" style="background-color: #ddd">Arus Kas Dari Aktivitas Operasi</th>
        </tr>
        @php $arus_kas_aktivitas_operasi_total = 0 @endphp
        @foreach($arus_kas_aktivitas_operasi as $row)
          @php $arus_kas_aktivitas_operasi_total += $row->total @endphp
          <tr>
            <td width="50%">{{ $row->nama_akun }}</td>
            <td>Rp. {{ number_format( $row->total, 2) }}</td>
          </tr>
        @endforeach
        <tr>
          <th colspan="3" style="background-color: #ddd">Arus Kas Dari Aktivitas Investasi</th>
        </tr>
        @php $arus_kas_aktivitas_investasi_total = 0 @endphp
        @foreach($arus_kas_aktivitas_investasi as $row)
          @php $arus_kas_aktivitas_investasi_total += $row->total @endphp
          <tr>
            <td width="50%">{{ $row->nama_akun }}</td>
            <td>Rp. {{ number_format( $row->total, 2) }}</td>
          </tr>
        @endforeach
        <tr>
          <th colspan="3" style="background-color: #ddd">Arus Kas Dari Aktivitas Pendanaan</th>
        </tr>
        @php $arus_kas_aktivitas_pendanaan_total = 0 @endphp
        @foreach($arus_kas_aktivitas_pendanaan as $row)
          @php $arus_kas_aktivitas_pendanaan_total += $row->total @endphp
          <tr>
            <td width="50%">{{ $row->nama_akun }}</td>
            <td>Rp. {{ number_format( $row->total, 2) }}</td>
          </tr>
        @endforeach
        <br>
        <tr>
          <th colspan="2" style="background-color: #ddd">KAS BERSIH</th>
          <th style="text-align: right!important">Rp. {{ number_format(($arus_kas_aktivitas_operasi_total + $arus_kas_aktivitas_pendanaan_total) - $arus_kas_aktivitas_investasi_total, 2) }}</th>
        </tr>


      </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>