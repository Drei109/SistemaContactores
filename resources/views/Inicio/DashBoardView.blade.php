@extends('template.layout')

@section('content')
<!-- Page header -->
<!-- Content area -->
{{-- <div class="page-header bg-white" style="">
	<div class="page-header-content header-elements-inline">
		<div class="page-title">
			<h5>
				<i class="icon-arrow-left52 mr-2"></i>
				<span class="font-weight-semibold">DASHBOARD</span>
				<small class="d-block opacity-75">Registros y Estadísticas</small>
			</h5>
		</div>

		<div class="header-elements d-flex align-items-center">
			<button class="btn btn-link text-white btn-icon btn-sm"><i class="icon-gear"></i></button>
		</div>
	</div>
</div> --}}
<div class="content">
	<!-- Basic datatable -->
	<div class="card">
		<div class="card-header bg-dark text-center p-2">
			<h5 class="font-weight-bold mb-0 align-self-center d-inline-block">Registros de los locales del día</h5>
			<div class="float-right">
				<input id="calendarInput" class="d-inline-block mr-1 border-0 bg-dark" type="text" />
				<i id="calendarIcon" class="icon-calendar22"></i>
			</div>
		</div>
		<div class="card-body">
			<table id="datatable" class="table datatable-basic datatable table-responsive table-bordered"
				style="border-top: 1px solid #dddddd;">
				<tbody>
					<tr>
						<td colspan="6">
							<div class="alert alert-warning alert-dismissible text-center">Cargando...</span>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<!-- /basic datatable -->
	<div class="card">
		<div class="card-group">
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
			<div class="card">
				<div class="card-body">
					<canvas id="myChart2"></canvas>
				</div>
			</div>
		</div>
	</div>

	<div class="card-group mt-2">
		<div class="card">
			<div class="card-header bg-dark text-center p-0">
				<h5 class="font-weight-bold p-2 mb-0">Estadísticas - Hora de encendido de los últimos 30 días</h5>
			</div>
			<div class="card-body">
				<div class="chart-container" style="position: relative;">
					<canvas id="seguimientoChart" height="350"></canvas>
				</div>
			</div>
		</div>
	</div>

</div>
<!-- /content area -->
@stop

@push('js')
<script src="{{asset('../assets/views/dashboard/dashboardListarView.js')}}"></script>
@endpush