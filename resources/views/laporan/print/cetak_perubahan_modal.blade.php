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
      Periode : {{ date('d-m-Y', strtotime($params->periode)) }}
    </h4>
    <div class="container">
      <table width="100%">
        <tr>
          <td colspan="2">Modal Awal</td>
          <td style="text-align: right!important">Rp. {{ number_format($modal_awal, 2) }}</td>
        </tr>
        <tr>
          <td width="60%">Laba Bersih</td>
          <td>Rp. {{ number_format( $laba_bersih, 2) }}</td>
        </tr>
        <tr>
          <td width="60%">Prive</td>
          <td>(Rp. {{ number_format( $prive, 2) }})<hr></td>
        </tr>
        <tr>
          <td colspan="2">Penambahan Modal</td>
          <td style="text-align: right!important">Rp. {{ number_format($laba_bersih - $prive, 2) }}<hr></td>
        </tr>
        <tr>
          <th colspan="2" style="background-color: #ddd">Modal Akhir {{ date('d M Y', strtotime($params->periode)) }}</th>
          <th style="text-align: right!important">Rp. {{ number_format($modal_awal + ($laba_bersih - $prive), 2) }}</th>
        </tr>
      </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>