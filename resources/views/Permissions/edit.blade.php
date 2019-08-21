@extends('template.layout')
@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Seguridad </span>  - Permisos</h4>
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
                        Seguridad
                    </a>
                    <a href="#" class="breadcrumb-item">
                        Permisos
                    </a>
                    <span class="breadcrumb-item active">Nuevo</span>	
    
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->


<div class="content">
    <div class="card">
        <div class="card-body">
                {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}

                <legend class="text-uppercase font-size-sm font-weight-bold">Formulario Registro Nuevo</legend>

                <div class="form-group row">
                    {{ Form::label('name', 'Name', array('class' => 'col-form-label col-lg-2 cursor-pointer')) }}
                    <div class="col-lg-10 ">
                        {{ Form::text('name', null , array('class' => 'form-control')) }}
                    </div>
                </div>

                {{ Form::submit('Editar', array('class' => 'btn btn-primary')) }}
            
                {{ Form::close() }}
        </div>
    </div>
</div>

@endsection 
