@extends('template.layout')

@section('content')
<!-- Page header -->
	<!-- Content area -->
	<div class="content">
		<div class="card-group mb-sm-3">
			<div class="card d-flex justify-content-center text-center">
				<div class="align-self-center">
					<p class="card-text">Puntos de Venta abiertos</p>
					<h3 class="numberCircle" id="encendidos">0</h3>
				</div>
			</div>
			<div class="card d-flex justify-content-center text-center">
				<div class="align-self-center">
					<p class="card-text">Puntos de Venta cerrados</p>
					<h3 class="numberCircle" id="apagados">0</h3>
				</div>
			</div>
			<div class="card">
				<div class="card-body">
					<canvas id="myChart"></canvas>
				</div>
			</div>
		</div>
		<!-- Basic datatable -->
		
		<div class="card">
			<div class="card-header bg-dark text-center">
				<h5 class="font-weight-bold">Registros del los locales del día</h5>
			</div>
			<div class="card-body">
				<table id="datatable" class="table datatable-basic dataTable no-footer datatable table-responsive">
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