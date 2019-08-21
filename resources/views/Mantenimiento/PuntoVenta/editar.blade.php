@extends('template.layout')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Mantenimiento</span>  - Salas</h4>
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
					Locales
				</a>
				<span class="breadcrumb-item active">Editar</span>	
				

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
			<form class="mb-3" id="formulario" action="#">
                <legend class="text-uppercase font-size-sm font-weight-bold">Formulario Registro</legend>
                
                <input type="hidden" id="txt_id" name="id" value="{{$id}}">
                
                <div class="form-group row">
					<label class="col-form-label col-lg-2 cursor-pointer" for="nombre">Nombre</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="txt_nombre" name="nombre" placeholder="Nombre de sala" autocomplete="off">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-form-label col-lg-2 cursor-pointer" for="direccion">CC_ID</label>
					<div class="col-lg-10">
						<input type="text" class="form-control" id="txt_cc_id" name="cc_id" placeholder="CC_ID">
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
<script src="{{asset('../assets/views/puntoVentas/puntoVentasEditarView.js')}}"></script>
@endpush