@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <form  method="POST" action="{{ url(@$url_print) }}" class="form-horizontal">
      {!! csrf_field() !!}
      <div class="x_panel">
        <div class="x_title">
          <h2>{{ @$header }}</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <button type="sumbit" formtarget="_blank" class="btn btn-success"><i class="fa fa-print" aria-hidden="true"></i> Cetak</button>
            </li>
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
                            <div class="col-md-3">
                              <div class="form-group">
                                <label class="control-label">Kolektor</label>
                                <select name="kolektor" class="form-control" id="kolektor">
                                    <option value="" selected="selected">-- Semua --</option>
                                    <?php foreach(@$kolektor as $dt): ?>
                                      <option value="<?php echo @$dt->id ?>"><?php echo @$dt->nama ?></option>
                                    <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-2 pull-right">
                              <div class="form-group">
                                <label class="control-label">Tahun</label>
                                  <select name="tahun" id="tahun" class="form-control">
                                    <option value="" selected="selected">-- Semua --</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                  </select>
                              </div>
                            </div>
                            <div class="col-md-2 pull-right">
                              <div class="form-group">
                                <label class="control-label">Bulan</label>
                                <select name="bulan" id="bulan" class="form-control">
                                  <option value="" selected="selected">-- Semua --</option>
                                  <?php foreach(@$bulan as $dt): ?>
                                    <option value="<?php echo @$dt['id'] ?>"><?php echo @$dt['desc'] ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <table class="table table-hover" id="{{ $idDatatables }}" width="100%">   
              <thead>
                <tr>
                  <th class="no-sort">No</th>
                  <th>ID Nasabah</th>
                  <th>Nama Nasabah</th>
                  <th>Simpanan</th>
                  <th>Penarikan</th>
                  <th>Kolektor</th>
                </tr>
              </thead>
              <tbody>
              
            </tbody>
            <tfoot>
              <tr>
                  <th colspan="3" style="text-align:right">Total</th>
                  <th></th>
                  <th></th>
                  <th></th>
              </tr>
          </tfoot>
            </table>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- DataTable -->
<script type="text/javascript">
    let _datatables_show = {
      dt__datatables_show:function(){
        var _this = $("#{{ $idDatatables }}");
            _datatable = _this.DataTable({			
              paginate: false,
              ordering: false,
              searching: false,
              info: false,						
              ajax: {
								url: "{{ url("{$urlDatatables}") }}",
								type: "POST",
								data: function(params){
                      params.kolektor = $('#kolektor').val();
                      params.bulan = $('#bulan').val();
                      params.tahun = $('#tahun').val();
										}
								},
              order:[ 4, 'desc'],
              columns: [
                          { 
                                data: "id", 
                                orderable: false,
                                render: function ( val, type, row, meta ){
                                      return meta.row + meta.settings._iDisplayStart + 1;
                          }
                          },
                          { 
                                data: "id_nasabah", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nama_nasabah", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "nominal_setoran", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "nominal_penarikan", 
                                render: function ( val, type, row ){
                                    return (val == 0 || !val) ? 'Rp ' +0 : 'Rp ' + mask_number.currency_add(val)
                                  }
                          },
                          { 
                                data: "kolektor", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                      ],
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
                          simpanan = api
                              .column(3)
                              .data()
                              .reduce(function (a, b) {
                                  return intVal(a) + intVal(b);
                              }, 0);
                          penarikan = api
                              .column(4)
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
                          $(api.column(3).footer()).html('Rp. ' + mask_number.currency_add(simpanan || 0));
                          $(api.column(4).footer()).html('Rp. ' + mask_number.currency_add(penarikan || 0));
                      },

                      createdRow: function ( row, data, index ){		

                      }
                                                  
                  });
							
                  return _this;
				}
			}

$(document).ready(function() {
    _datatables_show.dt__datatables_show();
    $('#kolektor,#bulan,#tahun').on('change', function(e){
        e.preventDefault();
        _datatable.ajax.reload();
    });
    
});
</script>
@endsection
 
