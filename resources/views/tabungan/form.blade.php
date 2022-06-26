<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">No Rekening</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[no_rek_tabungan]" id="no_rek_tabungan" value="{{ @$item->no_rek_tabungan }}" placeholder="No Rekening Tabungan" required="" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Nasabah</label>
    <div class="col-lg-9">
      <div class="input-group data_collect_wrapper">
        <input type="hidden" value="" id="id_nasabah" name="id[id_nasabah]">
        <input type="text" name="f[nama_nasabah]" id="nama_nasabah" class="form-control" placeholder="Nasabah" value="" required="" readonly>
        <div class="input-group-btn">
          <a href="javascript:;" id="lookup_nasabah" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Bunga</label>
    <div class="col-lg-9">
      <div class="input-group">
        <input type="number" name="f[bunga]" id="bunga" class="form-control" placeholder="Bunga" value="0.3" required="">
        <div class="input-group-btn">
          <a class="btn btn-default btn-flat">%</a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Setoran Awal</label>
    <div class="col-lg-9">
      <div class="input-group">
        <div class="input-group-btn">
          <span class="btn btn-default btn-flat">Rp</span>
        </div>
        <input type="text" class="form-control mask-number" name="t[kredit]" id="setoran" value="{{ @$item->kredit }}" placeholder="Setoran" autocomplete="off">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Akun Kas</label>
    <div class="col-lg-9">
          <select name="t[id_akun]" class="form-control" required="" id="id_akun">
            <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
            <?php foreach(@$option_akun as $dt): ?>
              <option value="<?php echo @$dt->id_akun ?>" <?= @$dt->id_akun == @$item->id_akun ? 'selected': null ?>><?php echo @$dt->nama_akun ?></option>
            <?php endforeach; ?>
          </select>
    </div>
  </div>

  <div class="form-group">
      <div class="col-lg-offset-3 col-lg-9">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button id="submit_form" type="submit" class="btn btn-success btn-save">@if($is_edit) Perbarui @else Simpan @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
      </div>
  </div>
</form>
      

<script type="text/javascript">
  $(document).ready(function(){
    mask_number.init()
    
    $('#lookup_nasabah').dataCollect({
        ajaxUrl: "{{ url('nasabah/datatables_no_tabungan') }}",
        modalSize : 'modal-lg',
        modalTitle : 'DAFTAR PILIHAN NASABAH',
        modalTxtSelect : 'Pilih Nasabah',
        dtOrdering : true,
        dtOrder: [],
        dtThead:['ID Nasabah','Nama Nasabah','Alamat'],
        dtColumns: [
            {data: "id_nasabah"}, 
            {data: "nama_nasabah"}, 
            {data: "alamat_nasabah"}, 
        ],
        onSelected: function(data, _this){	
          $('#id_nasabah').val(data.id_nasabah);
          $('#nama_nasabah').val(data.nama_nasabah); 
            
          return true;
        }
    });
  })
  $('form[name="form_crud"]').on('submit',function(e) {
    e.preventDefault();

    if(mask_number.currency_remove($("#kredit").val()) <= 0 )
    {
      alert('Silahkan lengkapi data tabungan!');
      return false
    }

    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");

    var data_post = new FormData($(this)[0]);
    $.ajax({
        url: $(this).prop('action'),
        type: 'POST',              
        data: data_post,
        contentType : false,
        processData : false,
        success: function(response, status, xhr)
        {
          if( response.status == "error"){
              $.alert_warning(response.message);
              $('.btn-save').removeClass('disabled', true);
              $(".spinner").css("display", "none");
              return false
          }
            
          $.alert_success(response.message);
              setTimeout(function(){
                document.location.href = "{{ url("$nameroutes") }}";        
              }, 500);  
          },
        error: function(error)
        {
          $.alert_error(error);
          $('.btn-save').removeClass('disabled', true);
          $(".spinner").css("display", "none");
          return false
        }
    });
});
</script>