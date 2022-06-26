<form  method="POST" action="{{ url($submit_url) }}" class="form-horizontal" name="form_crud">
  {{ csrf_field() }}
  <div class="form-group">
    <label class="col-lg-3 control-label">No Tabungan Berjangka</label>
    <div class="col-lg-9">
      <input type="text" class="form-control" name="f[id_tabungan_berjangka]" id="id_tabungan_berjangka" value="{{ @$item->id_tabungan_berjangka }}" placeholder="No Tabungan Berjangka" required="" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Nasabah</label>
    <div class="col-lg-9">
      <div class="input-group data_collect_wrapper">
        <input type="hidden" id="id_nasabah" name="id[id_nasabah]" required>
        <input type="text" name="f[nama_nasabah]" id="nama_nasabah" class="form-control" placeholder="Nasabah" required="" readonly>
        <div class="input-group-btn">
          <a href="javascript:;" id="lookup_nasabah" class="btn btn-info btn-flat data_collect_btn"><i class="fa fa-search"></i> Cari</a>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Bunga Perbulan</label>
    <div class="col-lg-3">
      <div class="input-group">
        <input type="number" name="f[bunga_tabungan_berjangka]" id="bunga_tabungan_berjangka" class="form-control" placeholder="Bunga" value="{{ @$item->bunga_tabungan_berjangka }}" required="">
        <div class="input-group-btn">
          <a class="btn btn-default btn-flat">%</a>
        </div>
      </div>
    </div>
    <label class="col-lg-3 control-label">Jangka Waktu</label>
    <div class="col-lg-3">
          <select name="f[jangka_waktu]" class="form-control" required="" id="jangka_waktu">
            <option value="" disabled="" selected="" hidden="">-- Pilih --</option>
            <?php foreach(@$option_jangka_waktu as $dt): ?>
              <option data-id="<?php echo @$dt['id'] ?>" data-bulan="<?php echo @$dt['bulan'] ?>" value="<?php echo @$dt['value'] ?>" <?= @$dt['value'] == @$item->jangka_waktu ? 'selected': null ?>><?php echo @$dt['desc'] ?></option>
            <?php endforeach; ?>
          </select>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Tanggal Awal</label>
    <div class="col-lg-9">
      <input type="date" name="f[tanggal_awal]" id="tanggal_awal" class="form-control" placeholder="Tanggal Awal" value="{{ @$item->tanggal_awal }}">
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Tanggal Berakhir</label>
    <div class="col-lg-9">
      <input type="date" name="f[jatuh_tempo]" id="jatuh_tempo" class="form-control" placeholder="Tanggal Berakhir" value="{{ @$item->jatuh_tempo }}" readonly>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Nominal Setoran Perbulan</label>
    <div class="col-lg-9">
      <div class="input-group">
        <div class="input-group-btn">
          <span class="btn btn-default btn-flat">Rp</span>
        </div>
        <input type="text" class="form-control mask-number" name="f[nominal_tabungan_berjangka]" id="nominal_tabungan_berjangka" value="{{ @$item->nominal_tabungan_berjangka }}" placeholder="Nominal Perbulan" autocomplete="off">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Total Bunga</label>
    <div class="col-lg-9">
      <div class="input-group">
        <div class="input-group-btn">
          <span class="btn btn-default btn-flat">Rp</span>
        </div>
        <input type="text" class="form-control mask-number" name="f[total_bunga]" id="total_bunga" value="{{ @$item->total_bunga }}" placeholder="Total Bunga" autocomplete="off" readonly>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">Saldo Akhir</label>
    <div class="col-lg-9">
      <div class="input-group">
        <div class="input-group-btn">
          <span class="btn btn-default btn-flat">Rp</span>
        </div>
        <input type="text" class="form-control mask-number" name="f[total_tabungan_berjangka]" id="total_tabungan_berjangka" value="{{ @$item->total_tabungan_berjangka }}" placeholder="Saldo Akhir" autocomplete="off" readonly>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-lg-3 control-label">&nbsp;</label>
    <div class="col-lg-3">
      <button type="button" class="btn btn-danger btn-block" data-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i> Tutup</button>
    </div>
    <div class="col-lg-3">
      <button type="button" id="simulasi" class="btn btn-info btn-block"><i class="fa fa-refresh" aria-hidden="true"></i> Simulasi</button>
    </div>
    <div class="col-lg-3">
      <button id="submit_form" type="submit" class="btn btn-success btn-block btn-save"><i class="fa fa-floppy-o" aria-hidden="true"></i> @if($is_edit)  Perbarui @else Simpan @endif <i class="fas fa-spinner fa-spin spinner" style="display: none"></i></button> 
    </div>
  </div>
</form>
      

<script type="text/javascript">
$('#simulasi').on( "click", function(e){
  e.preventDefault();
  var bunga_tabungan_berjangka = mask_number.currency_remove($('#bunga_tabungan_berjangka').val());
      jangka_waktu = $('#jangka_waktu').val();
      jumlah_bulan = $("#jangka_waktu").find(':selected').attr('data-bulan');
      nominal_tabungan_berjangka = mask_number.currency_remove($('#nominal_tabungan_berjangka').val());
      total_tabungan_berjangka = mask_number.currency_remove($('#total_tabungan_berjangka').val());
      tanggal_awal = $('#tanggal_awal').val();
      jatuh_tempo = $('#jatuh_tempo').val();



  var _prop= {
    _this : $( this ),
    remote : "{{ url("$nameroutes") }}/simulasi/" 
                              + bunga_tabungan_berjangka 
                              + '/' 
                              + jangka_waktu 
                              + '/' 
                              + nominal_tabungan_berjangka 
                              + '/' 
                              + total_tabungan_berjangka
                              + '/' 
                              + tanggal_awal 
                              + '/' 
                              + jatuh_tempo
                              + '/'
                              + jumlah_bulan,
    size : 'modal-lg',
    title : "Simulasi Tabungan Berjangka",
  }
  lookup_ajax_modal.show(_prop);											
});  

$(document).on("keyup",'#nominal_tabungan_berjangka', calculate);
$(document).on("keyup",'#bunga_tabungan_berjangka', calculate);

function calculate() {
    var nominal_perbulan = mask_number.currency_remove($('#nominal_tabungan_berjangka').val());
        bunga = $("#bunga_tabungan_berjangka").val();
        jangka_waktu = $("#jangka_waktu").val();
        jumlah_bulan = $("#jangka_waktu").find(':selected').attr('data-bulan');

        total_bunga = nominal_perbulan * bunga * jangka_waktu;
        total_tabungan_berjangka = (nominal_perbulan * jumlah_bulan) + (total_bunga);

        $("#total_bunga").val(mask_number.currency_add(total_bunga));
        $('#total_tabungan_berjangka').val(mask_number.currency_add(total_tabungan_berjangka));
        

}

  $(document).ready(function(){

    $("#jangka_waktu").on('change', function(e){
      console.log($("#jangka_waktu").find(':selected').attr('data-id'))
			var _date_end = moment($("#tanggal_awal").val()).add(Number($("#jangka_waktu").find(':selected').attr('data-id')), 'days').format("YYYY-MM-DD");
			$('#jatuh_tempo').val(_date_end);
      calculate()
		});
    $("#tanggal_awal").on('change', function(e){
			var _date_end = moment($("#tanggal_awal").val()).add(Number($("#jangka_waktu").find(':selected').attr('data-id')), 'days').format("YYYY-MM-DD");
			$('#jatuh_tempo').val(_date_end);
      calculate()
		});

    

    mask_number.init()
    
    $('#lookup_nasabah').dataCollect({
        ajaxUrl: "{{ url('nasabah/datatables') }}",
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
    nominal_tabungan_berjangka = mask_number.currency_remove($('#nominal_tabungan_berjangka').val());
    if(nominal_tabungan_berjangka == '' || nominal_tabungan_berjangka == 0)
    {
      $.alert_warning('Nominal setoran belum di masukkan!');
      return false
    }
    $('.btn-save').addClass('disabled', true);
    $(".spinner").css("display", "");
    var post_data = {
          'id_nasabah' : $("#id_nasabah").val(),
          'jangka_waktu' : $("#jangka_waktu").val(),
          'jangka_waktu_hari' : $("#jangka_waktu").find(':selected').attr('data-id'),
          'jangka_waktu_bulan' : $("#jangka_waktu").find(':selected').attr('data-bulan'),
          'tanggal_awal' : $("#tanggal_awal").val(),
          'jatuh_tempo' : $("#jatuh_tempo").val(),
          'bunga_tabungan_berjangka' : $("#bunga_tabungan_berjangka").val(),
          'nominal_tabungan_berjangka' : mask_number.currency_remove($("#nominal_tabungan_berjangka").val()),
          'total_tabungan_berjangka' : mask_number.currency_remove($("#total_tabungan_berjangka").val()),
          'total_bunga' : mask_number.currency_remove($("#total_bunga").val()),
        }


     data_post = {
          "f" : post_data,
        }

    // var data_post = new FormData($(this)[0]);
    $.post($(this).attr("action"), data_post, function(response, status, xhr) {
      if( response.status == "error"){
          $.alert_warning(response.message);
              $('.btn-save').removeClass('disabled');
              $(".spinner").css("display", "none");
              return false
          }
          $.alert_success(response.message);
              $('.btn-save').removeClass('disabled');
              $(".spinner").css("display", "none");
              ajax_modal.hide();
              setTimeout(function(){
                // location.reload();
                document.location.href = "{{ url("$nameroutes") }}";        
              }, 500);  
      }).catch(error => {
            $.alert_error(error);
                $('.btn-save').removeClass('disabled');
                $(".spinner").css("display", "none");
                return false
      });
});
</script>