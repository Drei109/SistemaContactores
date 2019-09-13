@extends('template.layout')

@section('content')
<!-- Page header -->
	<div class="page-header page-header-light">
		<div class="page-header-content header-elements-md-inline">
			<div class="page-title d-flex">
				<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Inicio</span> - Panel</h4>
				<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
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

		</div>
	</div>
	<!-- /page header -->


	<!-- Content area -->
	<div class="content">
		<!-- Basic datatable -->
		<div class="card">
			<div class="card-body">
				<table class="table thead-primary datatable table-hover table-responsive">
					<tbody><tr><td colspan="6"><div class="alert alert-warning alert-dismissible text-center">Cargando...</span></td></tr></tbody>
				</table>
			</div>
		</div>
		<!-- /basic datatable -->
	</div>
	<!-- /content area -->
@stop

@push('js')
<script src="{{asset('../assets/views/dashboard/dashboardListarView.js')}}"></script>
@endpush