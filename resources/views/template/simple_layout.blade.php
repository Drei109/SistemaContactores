<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<title>Sistema Contactores</title>

	<!-- Global stylesheets -->
	<!-- 	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css"> -->
	<link href="{{asset('../global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('../assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('../assets/css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('../assets/css/layout.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('../assets/css/components.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('../assets/css/colors.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('../assets/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('../assets/css/daterangepicker.css')}}" rel="stylesheet" type="text/css">

	<!-- /global stylesheets -->
	@stack('styles')
</head>

<body>
    @yield('content')

	<!-- Core JS files -->
	<script src="{{asset('../global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/main/bootstrap.bundle.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/loaders/blockui.min.js')}}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{asset('../global_assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
	{{-- <script src="{{asset('../global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/pickers/daterangepicker.js')}}"></script> --}}
	<script src="{{asset('../global_assets/js/plugins/notifications/noty.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
	<script src="{{asset('../assets/js/app.js')}}"></script>
	<script src="{{asset('../assets/js/general.js')}}"></script>
	<script src="{{asset('../global_assets/js/main/jquery-ui.js')}}"></script>

	<script src="{{asset('../global_assets/js/plugins/pickers/datetime/moment.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/pickers/datetime/daterangepicker.js')}}"></script>

	<script src="{{asset('../global_assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/tables/datatables/extensions/jszip/jszip2.min.js')}}"></script>
	
	<!-- /theme JS files -->
	@stack('js')
</body>
</html>

