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
      table, tr, th,td{
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
    <div class="col-sm-12">
      <div class="">
          <table class="table">
              <thead>
                  <tr>
                      <th align="center"><b>Aktiva</b></th>
                      <th align="center"><b>Pasiva</b></th>                        
                  </tr> 
              </thead>
              <tbody>	
                  <tr>
                      <td width="50%">
                        @php $total_aktiva = 0; @endphp
                        @foreach($aktiva as $key => $item)
                          <table>
                              <tr>
                                <td colspan="2"><b>{{ $key }}</b></td>
                              </tr>
                              @php $subtotal_aktiva = 0; @endphp
                              @foreach($item as $row)
                                @php $subtotal_aktiva += ($row['normal_pos'] == 'Kredit') ? $row['nilai'] * -1 : $row['nilai']; @endphp
                                <tr>
                                  <td width="50%" style="padding-left: 20px">{{ $row['nama_akun'] }}</td>
                                  <td>Rp. {{ ($row['normal_pos'] == 'Kredit') ? '('.number_format($row['nilai'],2).')' : number_format($row['nilai'], 2) }}</td>
                                </tr>
                              @endforeach
                              <tr>
                                <td><b>Total {{ $key }}</b></td>
                                <td><b>Rp. {{ number_format($subtotal_aktiva, 2) }}</b></td>
                              </tr>
                          </table>
                          @php $total_aktiva += $subtotal_aktiva; @endphp
                        @endforeach
                        <br>
                       
                      </td>

                      {{-- ===================== --}}
                      @php $total_passivaX = 0; @endphp
                      @foreach($passiva as $key => $item)
                            @php $subtotal_passivaX = 0; @endphp
                            @foreach($item as $row)
                                @php $subtotal_passivaX += $row['nilai']; @endphp
                            @endforeach
                        @php $total_passivaX += $subtotal_passivaX; @endphp
                      @endforeach
                      {{-- ========================= --}}
                      @php $selisih =  $total_aktiva - $total_passivaX @endphp

                      <td width="50%">
                        @php $total_passiva = 0; @endphp
                        @foreach($passiva as $key => $item)
                          <table>
                              <tr>
                                <td colspan="2"><b>{{ $key }}</b></td>
                              </tr>
                              @php $subtotal_passiva = 0; @endphp
                              @foreach($item as $row)
                                  @php $subtotal_passiva += $row['nilai']; @endphp
                                  <tr>
                                    <td width="50%" style="padding-left: 20px">{{ $row['nama_akun'] }}</td>
                                    <td>
                                        Rp. {{ number_format($row['nilai'], 2) }}
                                    </td>
                                  </tr>
                              @endforeach
                                <tr>
                                  <td><b>Total {{ $key }}</b></td>
                                  <td><b>Rp. {{ number_format($subtotal_passiva, 2) }}</b></td>
                                </tr>

                          </table>
                          @php $total_passiva += $subtotal_passiva; @endphp
                        @endforeach
                        <br>
          

                      
                      </td>
                  </tr>
              </tbody>
          </table>
          <table>
            <tr>
              <td width="50%">
                <table>
                  <tr>
                    <td width="50%"><b>TOTAL AKTIVA</b></td>
                    <td><b>Rp. {{ number_format($total_aktiva, 2)  }}</td>
                  </tr>
                </table>
              </td>
              <td width="50%">
                <table>
                  <tr>
                    <td width="50%"><b>TOTAL PASSIVA</b></td>
                    <td><b>Rp. {{ number_format($total_passiva, 2)  }}</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>


      </div>
  </div>

    <p style="z-index: 100;position: absolute;bottom: 0px;float: right;font-size: 11px;"><i>Tanggal Cetak : <?php echo date('d-m-Y') ?></i></p>
</body>
</html>