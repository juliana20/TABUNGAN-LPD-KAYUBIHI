
  <!-- jQuery -->
  <script src="{{ url('themes/gentelella/vendors/jquery/dist/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ url('themes/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ url('themes/gentelella/vendors/fastclick/lib/fastclick.js') }}"></script>
  <!-- NProgress -->
  <script src="{{ url('themes/gentelella/vendors/nprogress/nprogress.js') }}"></script>
  <!-- Chart.js -->
  <script src="{{ url('themes/gentelella/vendors/Chart.js/dist/Chart.min.js') }}"></script>
  <!-- morris.js -->
  <script src="{{ url('themes/gentelella/vendors/raphael/raphael.min.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/morris.js/morris.min.js') }}"></script>
  <!-- gauge.js -->
  <script src="{{ url('themes/gentelella/vendors/gauge.js/dist/gauge.min.js') }}"></script>
  <!-- bootstrap-progressbar -->
  <script src="{{ url('themes/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ url('themes/gentelella/vendors/iCheck/icheck.min.js') }}"></script>
  <!-- Skycons -->
  <script src="{{ url('themes/gentelella/vendors/skycons/skycons.js') }}"></script>
  <!-- Flot -->
  <script src="{{ url('themes/gentelella/vendors/Flot/jquery.flot.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/Flot/jquery.flot.pie.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/Flot/jquery.flot.time.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/Flot/jquery.flot.stack.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/Flot/jquery.flot.resize.js') }}"></script>
  <!-- Flot plugins -->
  <script src="{{ url('themes/gentelella/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/flot.curvedlines/curvedLines.js')}}"></script>
  <!-- DateJS -->
  <script src="{{ url('themes/gentelella/vendors/DateJS/build/date.js') }}"></script>
  <!-- JQVMap -->
  <script src="{{ url('themes/gentelella/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
  <!-- bootstrap-daterangepicker -->
  <script src="{{ url('themes/gentelella/vendors/moment/min/moment.min.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ url('themes/gentelella/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

  <!-- Custom Theme Scripts -->
  <script src="{{ url('themes/gentelella/build/js/custom.min.js') }}"></script>
  {{-- <script src="{{ url('themes/gentelella/build/js/custom.js') }}"></script> --}}

  {{-- {{ if datatable }} --}}
<script src="{{ url('') }}/themes/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('') }}/themes/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('') }}/themes/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<script src="{{ url('') }}/themes/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="{{ url('') }}/themes/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ url('') }}/themes/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="{{ url('') }}/themes/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>

{{-- TOASTR NOTIFICATION --}}
<script src="{{ url('') }}/themes/default/assets/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ url('') }}/themes/default/assets/css/toastr.min.css">

{{-- AUDIO --}}
<audio id="audio-alert" src="{{ url('') }}/themes/default/assets/audio/alert.mp3" preload="auto"></audio>
<audio id="audio-fail" src="{{ url('') }}/themes/default/assets/audio/fail.mp3" preload="auto"></audio>

<!-- Switchery -->
<script src="{{ url('') }}/themes/gentelella/vendors/switchery/dist/switchery.min.js"></script>

<!-- Dropzone.js -->
<script src="{{ url('') }}/themes/gentelella/vendors/dropzone/dist/min/dropzone.min.js"></script>

<script src="{{ url('') }}/themes/gentelella/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>

<script src="{{url('themes/default/js/tools.js')}}"></script>
{{-- <script src="{{ url('themes/AdminLTE-2.4.3/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script> --}}
<!-- Select2 -->
<script src="{{ url('') }}/themes/AdminLTE-2.4.3/bower_components/select2/dist/js/select2.full.min.js"></script>
<script>
  @if(Session::has('message'))
     var type="{{Session::get('alert-type','info')}}"
      switch(type){
          case 'info':
              toastr.info("{{ Session::get('message') }}");
              break;
          case 'success':
              toastr.success("{{ Session::get('message') }}");
              break;
          case 'warning':
              toastr.warning("{{ Session::get('message') }}");
              break;
          case 'error':
             toastr.error("{{ Session::get('message') }}");
             break;
      }
  @endif

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

	( function($) {
    $.extend({
        alert_success: function( message, fn, scope ){
          toastr.success(message,'Success', {iconClass:"toast-success"});
						try{ $( "#audio-alert" ).get(0).play(); }catch(ex){}
							
						if( $.isFunction(fn) ){
							setTimeout(function(){
									fn.call( scope || $ )
								}, 1200)
						}
					},
				alert_warning: function( message, fn, scope ){
          toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
          toastr.warning(message,'Perhatian', {iconClass:"toast-warning"});
          
						try{ $( "#audio-fail" ).get(0).play(); }catch(ex){}
							
						if( $.isFunction(fn) ){
							setTimeout(function(){
									fn.call( scope || $ )
								}, 1200)
						}
						
					},
				alert_error: function( message, fn, scope ){
          toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }
          toastr.error(message,'Terjadi Kesalahan', {iconClass:"toast-error"});
						
						try{ $( "#audio-fail" ).get(0).play(); }catch(ex){}
							
						if( $.isFunction(fn) ){
							setTimeout(function(){
									fn.call( scope || $ )
								}, 1200)
						}
						
					}
        });	
	

jQuery.extend(true, jQuery.fn.dataTable.defaults, {
		processing: true,
		serverSide: true,
		paginate: true,
		ordering: true,
		searching: true,
		info: true,
		responsive: true,
    order: [],
		dom: "<'datatable-tools'<'col-md-4'l><'col-md-8 custom-toolbar'f>r>t<'datatable-tools clearfix'<'col-md-4'i><'col-md-8'p>>",
		language: {
			"decimal": "",
			"emptyTable": "Tidak ada hasil ditemukan dari pencarian Anda.",
			"info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ rekaman",
			"infoEmpty": "Menampilkan 0 sampai 0 dari 0 rekaman",
			"infoFiltered": "(disaring dari _MAX_ total rekaman)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Tampilkan _MENU_ Per Halaman",
			"loadingRecords": "Memuat...",
			"processing": "<img src='{{ url('') }}/themes/gentelella/build/images/preloader.gif' style='margin-top:-24px' />",
			"search": "Cari",
			"zeroRecords": "Tidak ada hasil yang sesuai ditemukan",
			"paginate": {
				"first": "Pertama",
				"last": "Terakhir",
				"previous": "Sebelumnya",
				"next": "Berikutnya"
			},
			"aria": {
				"sortAscending": ": aktifkan untuk mengurutkan kolom ascending",
				"sortDescending": ": aktifkan untuk mengurutkan kolom descending"
			}
		}
	});

})( jQuery );
</script>
{{-- {{ endif }} --}}
    





