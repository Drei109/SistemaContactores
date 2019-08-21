@extends('template.layout')

@section('content')
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Seguridad</span>  - Roles</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            <div class="d-flex justify-content-center">
                <a href="{{ URL::to('roles/create') }}" class="btn btn-link btn-float text-default btn_nuevo">
                    <i class="icon-diff-added text-primary"></i> <span>Nuevo</span>
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
                <span class="breadcrumb-item active">Roles</span>	
                
            </div>
            <a href="#" class="header-elements-toggle text-default d-md-none">
                    <i class="icon-more"></i>
                </a>
        </div>
    </div>
</div>

<!-- Content area -->
<div class="content">
    <!-- Basic datatable -->
    <div class="card">
        <div class="card-body">
            <table id="datatable" class="table datatable table-hover">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Permisos</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>
                        <td>
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="dropdown-item btn_editar" data-id="' + value + '"><i class="icon-hammer"></i> Editar</a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
                                        <div class="dropdown-item"> <i class="icon-cross"></i>  {!! Form::submit('Eliminar', ['class' => 'bg-transparent  dropdown-toggle border-transparent']) !!} </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- /basic datatable -->
</div>
<!-- /content area -->

@endsection
