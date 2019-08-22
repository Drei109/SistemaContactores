@extends('template.layout')

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
				<a href="#" class="btn btn-link btn-float text-default btn_regresar">
					<i class="icon-arrow-left7 text-primary"></i> <span>Regresar</span>
				</a>
				<a href="#" class="btn btn-link btn-float text-default btn_limpiar">
					<i class="icon-clipboard text-primary"></i> <span>Limpiar</span>
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
				<span class="breadcrumb-item active">Nuevo</span>	

			</div>
		</div>
	</div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
	<!-- Basic datatable -->
	<div class="card">
		<div class="card-body">
			<form class="mb-3" id="formulario_nuevo" action="#">
				<legend class="text-uppercase font-size-sm font-weight-bold">Formulario Registro Nuevo</legend>
				<div class="form-group row">
					<label class="col-form-label col-lg-2 cursor-pointer" for="txt_nombre">Nombre</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="txt_nombre" name="nombre" required="required" placeholder="Nombre de destinatario" autocomplete="off">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2 cursor-pointer" for="txt_correo">Correo</label>
					<div class="col-lg-6">
                        <input type="email" class="form-control" id="txt_correo" name="correo" required="required" placeholder="Correo electrónico" autocomplete="off">
					</div>
					<label class="col-form-label col-lg-2 cursor-pointer" for="txt_correo_hora">Hora de envío</label>
					<div class="col-lg-2">
                        <input type="time" class="form-control text-center" id="txt_correo_hora" name="correo_hora" required="required" autocomplete="off">
                    </div>
				</div>

				<div class="form-group row">
					<div class="col-lg-10 offset-lg-2">
						<button type="button" class="btn btn-primary btn_guardar"><i class="icon-floppy-disk"></i> Guardar </button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<!-- /basic datatable -->
</div>
<!-- /content area -->
@stop

@push('js')
<script src="{{asset('../assets/views/destinatarios/destinatariosNuevoView.js')}}"></script>
@endpush