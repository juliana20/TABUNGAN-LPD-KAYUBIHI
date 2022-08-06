<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ @$title }} | {{config('app.app_name')}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="{{url('themes/default/images/favicon.ico')}}">
    <link rel="stylesheet" href="{{ url('themes/default/css/style_report.css')}}">
</head>
<body>
    <h5 align="center">
      {{config('app.app_alias')}} {{config('app.area')}} <br>
      {{config('app.address')}}<hr>
    </h5>
    <h5 align="center">
      {{ @$title }}<br>
    </h5>
    <h5 align="center">
      <u>Bukti Pengeluaran</u>
    </h5>
   
    <div class="container">
      <style>
        .table, .th, .td {
          border: 0px!important;
        }

        table, th, td {
          border: 1px solid rgb(116, 116, 116);
        }
      </style>
      <table class="table">
        <thead>
          <tr>
            <td style="width: 15%" class="td">No Bukti</td>
            <td style="width: 2%" class="td">:</td>
            <td style="width: 33%" class="td">{{ @$item->kode_pengeluaran }}</td>
            <td style="width: 15%" class="td">Akun Kas</td>
            <td style="width: 2%" class="td">:</td>
            <td style="width: 33%" class="td">{{ @$item->nama_akun }}</td>
          </tr>
          <tr>
            <td style="width: 15%" class="td">Tanggal</td>
            <td style="width: 2%" class="td">:</td>
            <td tyle="width: 33%" class="td">{{ date('d M Y', strtotime($item->tanggal)) }}</td>
            <td style="width: 15%" class="td">Keterangan</td>
            <td style="width: 2%" class="td">:</td>
            <td style="width: 33%" class="td">{{ $item->keterangan }}</td>
          </tr>
        </thead>
      </table>
      <table width="100%">
        <thead>
          <tr>
            <th>No</th>
            <th>No Akun</th>
            <th>Nama Akun</th>
            <th>Keterangan</th>
            <th>Nominal</th>
          </tr>
        </thead>
        <tbody>
          @if(!empty($collection)) 
          @php $no = 1; $total = 0; @endphp
              @foreach($collection as $row)
                @php $total += $row->nominal; @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->kode_akun }}</td>
                    <td>{{ $row->nama_akun }}</td>
                    <td>{{ $row->keterangan }}</td>
                    <td>Rp. {{ number_format($row->nominal, 2) }}</td>
                </tr>
            @endforeach

          @else
            <tr>
              <td colspan="5" align="center">Tidak terdapat data</td>
            </tr>
          @endif
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4" align="right"><b>Total</b></td>
            <td><b>Rp. {{ number_format($total, 2) }}</b></td>
          </tr>
        </tfoot>

      </table>
      <br>
      <table style="border: 0px!important">
        <tr>
          <td width="50%" style="border: 0px!important">

          </td>
          <td width="50%" align="right" style="border: 0px!important">
            <p style="margin-bottom: 70px"><?php echo 'Kerambitan, '.date('d M Y') ?>,<br>
            Pembuat</p>

            <p><i>{{ @$item->nama_user }}</i></p>
          </td>
        </tr>
      </table>
      </div>
    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>