@extends('template.layout')
@section('content')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
            <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Destinatarios</span>  - Salas</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
        
        <input type="hidden" id="txt_id" value="{{$destinatario->id}}">

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
					{{$destinatario->correo}}
				</a>
				<span class="breadcrumb-item active">Salas</span>	
				
			</div>
			<a href="#" class="header-elements-toggle text-default d-md-none">
					<i class="icon-more"></i>
				</a>
		</div>
		<div class="header-elements d-none">
			<div class="breadcrumb justify-content-center">
				<div class="breadcrumb-elements-item dropdown p-0">
					<a href="#" class="breadcrumb-elements-item dropdown-toggle" data-toggle="dropdown">
						<i class="icon-gear mr-2"></i>
						Acciones
					</a>

					<div class="dropdown-menu dropdown-menu-right">
						<a href="#" class="dropdown-item">
							<i class="icon-printer"></i> Imprimir
						</a>
						<a href="#" class="dropdown-item">
							<i class="icon-file-excel"></i> Excel
						</a>
						<a href="#" class="dropdown-item">
							<i class="icon-file-pdf"></i> Pdf
						</a>
						
					</div>
				</div>
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
			<table class="table datatable table-hover">
				<tbody><tr><td colspan="6"><div class="alert alert-warning alert-dismissible text-center">Cargando...</span></td></tr></tbody>
			</table>
		</div>
	</div>
	<!-- /basic datatable -->
</div>
<!-- /content area -->
@stop

@push('js')
<script src="{{asset('../assets/views/destinatarios/destinatariosSalasListarView.js')}}"></script>
@endpush