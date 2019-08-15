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

	<!-- /global stylesheets -->
	@stack('styles')
</head>

<body>

	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark">
		<div class="navbar-brand">
			{{-- <span>Sistema <em>Contactores</em></span> --}}
			<a href="index-2.html" class="d-inline-block">
				<img src="../../../../global_assets/images/logo_new.png" alt="">
			</a>
		</div>

		<div class="d-md-none">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
				<i class="icon-tree5"></i>
			</button>
			<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
				<i class="icon-paragraph-justify3"></i>
			</button>
		</div>

		<div class="collapse navbar-collapse" id="navbar-mobile">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
						<i class="icon-paragraph-justify3"></i>
					</a>
				</li>

			</ul>

			<span class="ml-md-3 mr-md-auto"></span>

			<ul class="navbar-nav">
				
				<li class="nav-item dropdown dropdown-user">
					<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
						<img src="../../../../global_assets/images/demo/users/face9.jpg" class="rounded-circle mr-2" height="34" alt="">
						@if (!Auth::guest())
							<span>{{ app('auth')->user()->name}}</span>	
						@else
							<span>Invitado</span>
						@endif
						
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> Cuenta</a>
						<a href="#" class="dropdown-item"><i class="icon-coins"></i> Mi Tareaje</a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Configuracion</a>
						<a href="#" class="dropdown-item"><i class="icon-switch2"></i> Salir</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">

			<!-- Sidebar mobile toggler -->
			<div class="sidebar-mobile-toggler text-center">
				<a href="#" class="sidebar-mobile-main-toggle">
					<i class="icon-arrow-left8"></i>
				</a>
				Navigation
				<a href="#" class="sidebar-mobile-expand">
					<i class="icon-screen-full"></i>
					<i class="icon-screen-normal"></i>
				</a>
			</div>
			<!-- /sidebar mobile toggler -->


			<!-- Sidebar content -->
			<div class="sidebar-content">

				<!-- User menu -->
				@auth
				<div class="sidebar-user">
					<div class="card-body">
						<div class="media">
							<div class="mr-3">
								<a href="#"><img src="../../../../global_assets/images/demo/users/face9.jpg" width="38" height="38" class="rounded-circle" alt=""></a>
							</div>

							<div class="media-body">
								<div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
								<div class="font-size-xs opacity-50">
									<i class="icon-pin font-size-sm"></i> {{ Auth::user()->email }}
								</div>
							</div>

							<div class="ml-3 align-self-center">
								<a href="#" class="text-white"><i class="icon-cog3"></i></a>
							</div>
						</div>
					</div>
				</div>
				@endauth
				<!-- /user menu -->


				<!-- Main navigation -->
				<div class="card card-sidebar-mobile">
					<ul class="nav nav-sidebar" data-nav-type="accordion">

						<!-- Main -->
						<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Menu</div> <i class="icon-menu" title="Main"></i></li>
						<li class="nav-item">
							<a href="#" class="nav-link active">
								<i class="icon-home4"></i>
								<span>
									Inicio
								</span>
							</a>
						</li>
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-copy"></i> <span>Mantenimiento</span></a>
							<ul class="nav nav-group-sub" data-submenu-title="Layouts">
								<li class="nav-item"><a href="{{route('Salas.index')}}" class="nav-link">Salas</a></li>
								<li class="nav-item"><a href="{{route('Destinarios.index')}}" class="nav-link">Destinatarios</a></li>
								{{-- <li class="nav-item"><a href="#" class="nav-link">Salas - Destinatarios</a></li> --}}
							</ul>
						</li>
						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-lock2"></i> <span>Seguridad</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Themes">
								<li class="nav-item"><a href="{{route('Seguridad.Empleados')}}" class="nav-link active">Empleados</a></li>
								<li class="nav-item"><a href="{{route('Seguridad.Usuarios')}}" class="nav-link">Usuarios</a></li>
								<li class="nav-item"><a href="{{route('Seguridad.Roles')}}" class="nav-link">Roles</a></li>
								<li class="nav-item"><a href="{{route('Seguridad.Permisos')}}" class="nav-link">Permisos</a></li>
							</ul>
						</li>

						<li class="nav-item nav-item-submenu">
							<a href="#" class="nav-link"><i class="icon-file-spreadsheet"></i> <span>Reportes</span></a>

							<ul class="nav nav-group-sub" data-submenu-title="Themes">
								<li class="nav-item nav-item-submenu">
									<ul class="nav nav-group-sub">
										<li class="nav-item"><a href="#" class="nav-link">Asistencia</a></li>
										<li class="nav-item"><a href="#" class="nav-link">Asistencia x Factor Nocturno</a></li>
										<li class="nav-item"><a href="#" class="nav-link">Cambios Efectuados</a></li>
									</ul>
								</li>
								<li class="nav-item"><a href="#" class="nav-link">Nuevo</a></li>
							</ul>
						</li>


						<!-- /main -->

					</ul>
				</div>
				<!-- /main navigation -->

			</div>
			<!-- /sidebar content -->
			
		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			@yield('content')


			<!-- Footer -->
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Software3000
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2019 <a href="#">Software3000.net</a>
					</span>
				</div>
			</div>
			<!-- /footer -->

		</div>

		<!-- /main content -->

	</div>
	<!-- /page content -->

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
	<script src="{{asset('../global_assets/js/plugins/ui/moment/moment.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/pickers/daterangepicker.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/notifications/noty.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
	<script src="{{asset('../global_assets/js/plugins/forms/validation/validate.min.js')}}"></script>
	<script src="{{asset('../assets/js/app.js')}}"></script>
	<script src="{{asset('../assets/js/general.js')}}"></script>
	<script src="{{asset('../global_assets/js/main/jquery-ui.js')}}"></script>
	<!-- /theme JS files -->
	@stack('js')
</body>
</html>

