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
              <label class="col-sm-3 control-label">Nasabah</label>
              <div class="col-md-9">
                @if(Helpers::getJabatan() == 'Nasabah')
                    <input type="hidden" id="nasabah_id" name="nasabah_id" required value="{{ Helpers::getIdNasabah() }}">
                    <input type="text" name="nama_nasabah" id="nama_nasabah" value="{{ Helpers::getNama() }}" class="form-control" placeholder="Nama Nasabah" required readonly>
                @else
                  <div class="input-group data_collect_wrapper">
                    <input type="hidden" id="nasabah_id" name="nasabah_id" required>
                    <input type="text" name="nama_nasabah" id="nama_nasabah" value="" class="form-control" placeholder="Nama Nasabah" required readonly>
                    <div class="input-group-btn">
                      <a href="javascript:;" id="lookup_nasabah" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
                    </div>
                  </div>
                @endif
              </div>
            </div>
            
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label"></label>
                <div class="col-md-9">
                    <button type="sumbit" class="btn btn-success btn-block"><i class="fa fa-print" aria-hidden="true"></i> Cetak Buku Tabungan</button>
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
        $('#lookup_nasabah').dataCollect({
          ajaxUrl: "{{ url('nasabah/datatables') }}",
          modalSize : 'modal-md',
          modalTitle : 'DAFTAR PILIHAN NASABAH',
          modalTxtSelect : 'Pilih Nasabah',
          dtOrdering : true,
          dtOrder: [],
          dtThead:['ID Nasabah','Nama Nasabah','Alamat'],
          dtColumns: [
              {data: "id_nasabah"}, 
              {data: "nama_nasabah"}, 
              {data: "alamat"}, 
          ],
          onSelected: function(data, _this){	
            $('#nasabah_id').val(data.id);
            $('#nama_nasabah').val(data.nama_nasabah); 
              
            return true;
          }
      });
    });
</script>
@endsection