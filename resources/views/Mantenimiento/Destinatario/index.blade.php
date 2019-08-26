@extends('template.layout')
@section('content')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Mantenimiento</span>  - Destinatarios</h4>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>

		<div class="header-elements d-none">
			<div class="d-flex justify-content-center">
				<a href="#" class="btn btn-link btn-float text-default btn_recargar">
					<i class="icon-reset text-primary"></i><span>Recargar</span>
				</a>
				<a href="#" class="btn btn-link btn-float text-default btn_nuevo">
					<i class="icon-diff-added text-primary"></i> <span>Nuevo</span>
				</a>
				<a href="#" class="btn btn-link btn-float text-default btn_eliminar">
					<i class="icon-bin text-primary"></i> <span>Eliminar</span>
				</a>
			</div>
		</div>
	</div>

	<div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
		<div class="d-flex">
			<div class="breadcrumb">
				<a href="#" class="breadcrumb-item">
					<i class="icon-home2 mr-2"></i> Inicio
				</a>
				<a href="#" class="breadcrumb-item">
					Mantenimiento
				</a>
				<a href="#" class="breadcrumb-item">
					Destinatarios
				</a>
				<span class="breadcrumb-item active">Index</span>	
				
			</div>
			<a href="#" class="header-elements-toggle text-default d-md-none">
					<i class="icon-more"></i>
				</a>
		</div>
	</div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
	<!-- Basic datatable -->
	<div class="card">
		<div class="card-body">
			<table class="table datatable table-hover">
				<tbody><tr><td colspan="6"><div class="alert alert-warning alert-dismissible text-center">Cargando...</span></td></tr></tbody>
			</table>
		</div>
	</div>
	<!-- /basic datatable -->
</div>
<!-- /content area -->

<!-- Scrollable modal -->
<div id="modal_scrollable_salas" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header pb-3">
				<h5 class="modal-title">Locales</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<div id="cuerpo-modal" class="modal-body py-0">
				<table class="table datatable-salas table-hover">
						<tbody><tr><td colspan="3"></td></tr></tbody>
				</table>
			</div>

			<div class="modal-footer pt-3">
				<button id="cerrar_modal_salas" type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn bg-primary btn_guardar_salas">Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- /scrollable modal -->

<!-- Scrollable modal -->
<div id="modal_scrollable_horas" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header pb-3 text-center">
				<h5 class="modal-title">Horas</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<input type="hidden" id="destinatario_id" val="">
			</div>

			<div class="align-middle modal-body py-1 row align-middle">
				<div class="col-lg-8 offset-lg-2 row align-middle">
					<div class="col-lg-8 align-middle">
						<input id="txt_hora_nueva" class="w-100 form-group text-center" name="hora_nueva" type="time" step="1800">
					</div>
					<div class="col-lg-4">
						<button id="agregar_hora" class="w-100 btn btn-sm btn-primary">Agregar</button>
					</div>
				</div>
			</div>
		

			<div id="cuerpo-modal" class="align-middle modal-body py-1 row">
				<div class="col-lg-8 offset-lg-2">
					<table class="table datatable-horas table-hover ">
						<tbody><tr><td colspan="3"></td></tr></tbody>
					</table>
				</div>
			</div>

			<div class="modal-footer pt-3">
				<button id="cerrar_modal_horas" type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn bg-primary btn_guardar_horas">Guardar Cambios</button>
			</div>
		</div>
	</div>
</div>
<!-- /scrollable modal -->
@stop

@push('js')
<script src="{{asset('../assets/views/destinatarios/destinatariosListarView.js')}}"></script>
@endpush