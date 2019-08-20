@extends('template.layout')

@section('content')
<div class="page-header page-header-light">
	<div class="page-header-content header-elements-md-inline">
		<div class="page-title d-flex">
			<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Seguridad</span>  - Usuarios</h4>
			<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
		</div>

		<div class="header-elements d-none">
			<div class="d-flex justify-content-center">
				<a href="#" class="btn btn-link btn-float text-default btn_recargar">
					<i class="icon-reset text-primary"></i><span>Recargar</span>
				</a>
				<a href="{{ route('users.create') }}" class="btn btn-link btn-float text-default btn_nuevo">
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
					Seguridad
				</a>
				<span class="breadcrumb-item active">Usuarios</span>	
				
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
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha Agregado</th>
                        <th>Roles</th>
                        <th>Operaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('F d, Y h:ia') }}</td>
                        <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>{{-- Retrieve array of roles associated to a user and convert to string --}}
                        <td>
                            <div class="list-icons">
                                <div class="dropdown">
                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                        <i class="icon-menu9"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('users.edit', $user->id) }}" class="dropdown-item btn_editar" data-id="' + value + '"><i class="icon-hammer"></i> Editar</a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
                                        <div class="dropdown-item"> <i class="icon-cross"></i>  {!! Form::submit('Delete', ['class' => 'bg-transparent  dropdown-toggle border-transparent']) !!} </div>
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
@push('js')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        } );
    </script>
@endpush
