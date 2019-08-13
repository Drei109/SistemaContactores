@extends('template.layout')

@section('content')
<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Inicio</span> - Panel</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>

			<div class="header-elements d-none">
				<div class="d-flex justify-content-center">
					<a href="#" class="btn btn-link btn-float text-default"><i class="icon-bars-alt text-primary"></i><span>Estadisticas</span></a>
					<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calculator text-primary"></i> <span>Calculos</span></a>
					<a href="#" class="btn btn-link btn-float text-default"><i class="icon-calendar5 text-primary"></i> <span>Programacion</span></a>
				</div>
			</div>
		</div>

		<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
			<div class="d-flex">
				<div class="breadcrumb">
					<a href="index-2.html" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Inicio</a>
					<span class="breadcrumb-item active">Panel</span>
				</div>

				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
			</div>

			<div class="header-elements d-none">
				<div class="breadcrumb justify-content-center">
					<a href="#" class="breadcrumb-elements-item">
						<i class="icon-comment-discussion mr-2"></i>
						Soporte
					</a>

					<div class="breadcrumb-elements-item dropdown p-0">
						<a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
							<i class="icon-gear mr-2"></i>
							Configuracion
						</a>

						<div class="dropdown-menu dropdown-menu-right">
							<a href="#" class="dropdown-item"><i class="icon-user-lock"></i> Account security</a>
							<a href="#" class="dropdown-item"><i class="icon-statistics"></i> Analytics</a>
							<a href="#" class="dropdown-item"><i class="icon-accessibility"></i> Accessibility</a>
							<div class="dropdown-divider"></div>
							<a href="#" class="dropdown-item"><i class="icon-gear"></i> All settings</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">

		<!-- Dashboard content -->
		<div class="row">
			<div class="col-xl-8">

				<!-- Quick stats boxes -->
				<div class="row">
				
					
				</div>
				<!-- /quick stats boxes -->

			</div>
		</div>
		<!-- /dashboard content -->

	</div>
	<!-- /content area -->
@stop