@extends('themes.AdminLTE.layouts.template')
@section('breadcrumb')  
  <h1>
    {{ @$title }}
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Master</a></li>
    <li class="active">{{ @$title }}</li>
  </ol>
@endsection
@section('content')  
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ @$header }}</h3>
        <div class="box-tools pull-right">
            <div class="btn-group">
              
            </div>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <div class="form-group">
          <label class="col-md-1 control-label">Periode</label>
          <div class="col-md-4">
            <div class="input-group">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="reservation">
            </div>
          </div><br><hr>
          <!-- /.input group -->
        </div>
        <table class="table table-hover" id="{{$idDatatables}}" width="100%">   
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Kode Akun</th>
                <th>Nama Akun</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Keterangan</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
            
          </tbody>
          <tfoot>
            <tr>
                <th colspan="4" style="text-align:right">Total</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tfoot>
          </table>
      </div>
    </div>

<!-- DataTable -->
<script type="text/javascript">
    var id_datatables = "{{ $idDatatables }}";

    _datatables_show = {
        dt_datatables:function(){
        var _this = $("#"+id_datatables);
            _datatable = _this.DataTable({		
              ajax: {
								url: "{{ url("{$urlDatatables}") }}",
								type: "POST",
								data: function(params){
                        params.date_start = $('#reservation').data('daterangepicker').startDate.format("YYYY-MM-DD");
                        params.date_end = $('#reservation').data('daterangepicker').endDate.format("YYYY-MM-DD");
										}
								},							
              pageLength: 100,
              columns: [
                          { 
                                data: "tanggal", 
                                render: function ( val, type, row ){
                                     return "<b>"+ val +"</b>"; 
                                  }
                          },
                          { 
                                data: "kode_jurnal", 
                                render: function ( val, type, row ){
                                    return "<b>"+ val +"</b>";
                                  }
                          },
                          { 
                                data: "kode_akun", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama_akun", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "debet", 
                                render: function ( val, type, row ){
                                    return mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "kredit", 
                                render: function ( val, type, row ){
                                    return mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "keterangan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                            data: "kode_jurnal_hide", 
                            className: " text-center", 
                            render: function( val, type, row ){ 
                              return "<b>"+ val +"</b>";
                            } 
                          },
                      ],
                      columnDefs: [{
                          targets: 7,
                          searchable: true,
                          visible: false
                      }],
                      fnRowCallback : function( nRow, aData, iDisplayIndex ) {
									
                          /*var index = iDisplayIndex + 1;
                          $('td:eq(0)',nRow).html(index);
                          return nRow;*/
                
                        },
                      drawCallback : function( settings, iDisplayIndex, nRow ) {
           
                      },
                      footerCallback: function (row, data, start, end, display) {
                          var api = this.api();
              
                          // Remove the formatting to get integer data for summation
                          var intVal = function (i) {
                              return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
                          };
              
                          // Total over all pages
                          debet = api
                              .column(4)
                              .data()
                              .reduce(function (a, b) {
                                  return intVal(a) + intVal(b);
                              }, 0);
                          kredit = api
                              .column(5)
                              .data()
                              .reduce(function (a, b) {
                                  return intVal(a) + intVal(b);
                              }, 0);
                          // // Total over this page
                          // pageTotal = api
                          //     .column(4, { page: 'current' })
                          //     .data()
                          //     .reduce(function (a, b) {
                          //         return intVal(a) + intVal(b);
                          //     }, 0);
              
                          // // Update footer
                          // $(api.column(4).footer()).html('$' + pageTotal + ' ( $' + total + ' total)');
                          $(api.column(4).footer()).html(mask_number.currency_add(debet));
                          $(api.column(5).footer()).html(mask_number.currency_add(kredit));
                      },
                                                  
                  });
							
                  return _this;
				}

			}
  
      
  $(function () {
    //Date range picker
    $('#reservation').daterangepicker()
  })

  $(document).ready(function() {
    _datatables_show.dt_datatables();

    $('#reservation').on('change', function(e){
        e.preventDefault();
        _datatable.ajax.reload();
    });
    
  });

  


  </script>
@endsection
 
