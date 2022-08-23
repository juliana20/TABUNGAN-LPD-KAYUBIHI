<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="{{ url('') }}/themes/login/Login_v2/images/icons/favicon.ico"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.app_name') }} | {{ @$title }}</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap -->
    <link href="{{ url('') }}/themes/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url('') }}/themes/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ url('') }}/themes/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ url('') }}/themes/gentelella/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="{{ url('') }}/themes/gentelella/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ url('') }}/themes/gentelella/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="{{ url('') }}/themes/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ url('') }}/themes/gentelella/vendors/jquery/dist/jquery.min.js"></script>
    <script src="{{ url('')}}/themes/gentelella/vendors/moment/min/moment.min.js"></script>
    {{-- <script src="{{url('')}}/theme/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script> --}}
    <link href="{{ url('') }}/themes/gentelella/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="{{ url('') }}/themes/gentelella/build/css/custom.min.css" rel="stylesheet">
    <link href="{{ url('') }}/themes/default/assets/css/custom.style.css" rel="stylesheet">

    {{-- @notifyCss --}}
    <link href="{{ url('themes/default/assets/css/notify.css') }}" rel="stylesheet">

    {{-- datatable --}}
    <link href="{{ url('') }}/themes/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('')}}/themes/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('')}}/themes/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('')}}/themes/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="{{ url('')}}/themes/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Switchery -->
    <link href="{{ url('')}}/themes/gentelella/vendors/switchery/dist/switchery.min.css" rel="stylesheet">

    <!-- Dropzone.js -->
    <link href="{{ url('')}}/themes/gentelella/vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">

    <!-- Sweatalert -->
    <script src="{{ url('themes/default/assets/js/sweetalert.min.js')}}"></script>
</head>