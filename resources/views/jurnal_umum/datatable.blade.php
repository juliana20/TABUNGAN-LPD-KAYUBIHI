@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          {{-- <li class="dropdown">
            <button onclick="window.location='{{ url($nameroutes.'/create') }}'"  class="btn btn-success btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('global.label_create') }}</button>
          </li> --}}
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
          <div class="panel">
              <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                  <h4 class="panel-title"><i class="fa fa-filter"></i> Filter Pencarian</h4>
              </a>
              <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" style="background:#ffffff">
                  <div class="panel-body">
                      <div class="row">
                        <div class="form-group">
                          <div class="col-md-3">
                            <label class="control-label" for="filter_date">Periode</label>
                            <input id="filter_date" type="text" name="filter_date" class="form-control init-daterangepicker" value="" placeholder="Cari Tanggal..." autocomplete="off">
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
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
                  <th></th>
              </tr>
          </tfoot>
        </table>
    </div>
  </div>
</div>
</div>

<!-- DataTable -->
<script type="text/javascript">
  var _datestart = moment().startOf("hour").format('YYYY-MM-DD');
	var _dateend = moment().endOf("hour").format('YYYY-MM-DD');
    var id_datatables = "{{ $idDatatables }}";

    _datatables_show = {
        dt_datatables:function(){
        var _this = $("#"+id_datatables);
            _datatable = _this.DataTable({		
              ajax: {
								url: "{{ url("{$urlDatatables}") }}",
								type: "POST",
								data: function(params){
                        // params.date_start = $('#reservation').data('daterangepicker').startDate.format("YYYY-MM-DD");
                        // params.date_end = $('#reservation').data('daterangepicker').endDate.format("YYYY-MM-DD");
                        params.date_start = _datestart;
                        params.date_end = _dateend;
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
    // $('#reservation').daterangepicker({
    //                locale: {
    //                         format: 'DD/MM/YYYY'
    //                         }
    //              })
  })

  $(document).ready(function() {
     _datatables_show.dt_datatables();
      $('#filter_date').on('apply.daterangepicker', function(ev, picker) {
					_datestart = picker.startDate.startOf("hour").format('YYYY-MM-DD');
					_dateend = picker.endDate.endOf("hour").format('YYYY-MM-DD');
					$('#filter_date').val(picker.startDate.format('DD, MMM YYYY') + ' - ' + picker.endDate.format('DD, MMM YYYY'));
          _datatable.ajax.reload();
				});
				

    
  });

  


  </script>
@endsection
 
