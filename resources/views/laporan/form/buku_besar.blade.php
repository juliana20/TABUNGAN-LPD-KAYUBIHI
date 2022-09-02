@extends('themes.gentelella.template.template')
@section('content')
<div class="col-sm-6 col-sm-offset-3 col-xs-12">
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>{{ @$title }}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-12">
            <form  method="POST" action="{{ url(@$url_print) }}" class="form-horizontal">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Periode Awal</label>
                <div class="col-md-9">
                    <input type="date" class="form-control" name="f[date_start]" required value="{{ @$item->date_start}}">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Periode Akhir</label>
                <div class="col-md-9">
                    <input type="date" class="form-control" name="f[date_end]" required value="{{ @$item->date_end}}">
                </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Akun</label>
              <div class="col-md-9">
                <div class="input-group data_collect_wrapper">
                  <input type="hidden" id="akun_id" name="f[akun_id]" required>
                  <input type="text" name="nama_akun" id="nama_akun" value="{{ @$item->nama_akun }}" class="form-control" placeholder="Akun" required readonly>
                  <div class="input-group-btn">
                    <a href="javascript:;" id="lookup_akun" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label"></label>
                <div class="col-md-9">
                    <button type="sumbit" formtarget="_blank" class="btn btn-success btn-block" data-dismiss="modal"><i class="fa fa-print" aria-hidden="true"></i> Preview PDF</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
  </div>
  </div>
</div>


<script>
      $(document).ready(function(){
        $('#lookup_akun').dataCollect({
          ajaxUrl: "{{ url('akun/datatables') }}",
          modalSize : 'modal-md',
          modalTitle : 'DAFTAR PILIHAN AKUN',
          modalTxtSelect : 'Pilih Akun',
          dtOrdering : true,
          dtOrder: [],
          dtThead:['Kode Akun','Nama Akun'],
          dtColumns: [
              {data: "kode_akun"}, 
              {data: "nama_akun"}, 
          ],
          onSelected: function(data, _this){	
            $('#akun_id').val(data.id);
            $('#nama_akun').val(data.nama_akun); 
              
            return true;
          }
      });
    });
</script>
@endsection