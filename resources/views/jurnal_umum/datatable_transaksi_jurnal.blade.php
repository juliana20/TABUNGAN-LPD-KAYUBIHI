@extends('themes.gentelella.template.template')
@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$header }}</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li class="dropdown">
            <button onclick="window.location='{{ url($nameroutes.'/create') }}'"  class="btn btn-success btn-sm"><i class="fa fa-plus-circle" aria-hidden="true"></i> {{ __('global.label_create') }}</button>
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
                  <th class="no-sort">Aksi</th>
                  <th>Tanggal</th>
                  <th>No Bukti</th>
                  <th>User</th>
                  <th>Keterangan</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              
            </tbody>
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
                        params.date_start = _datestart;
                        params.date_end = _dateend;
										}
								},							
              pageLength: 100,
              columns: [
                          {
                                data: "id",
                                orderable: false,
                                className: "text-center",
                                render: function ( val, type, row ){
                                    var buttons = '<div class="btn-group" role="group">';
                                        buttons += '<a href=\"{{ url('jurnal-umum/detail') }}/'+ val +'\" title=\"Lihat Data\" class="btn btn-info btn-xs"><i class=\"fa fa-eye\"></i> Lihat</a>';      
                                        buttons += "</div>";

                                      return buttons
                                  }
                          },
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
                                data: "nama_user", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "keterangan", 
                                render: function ( val, type, row ){
                                    return val
                                  }
                          },
                          { 
                                data: "status_batal", 
                                render: function ( val, type, row ){
                                    if(val == 1){
                                      return `<span class="label label-danger">Dibatalkan</span>`;
                                    }else{
                                      return `<span class="label label-success">Aktif</span>`;
                                    }
                                  }

                          }
                      ],
                                                  
                  });
							
                  return _this;
				}

			}
  

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
 
