@extends('template.simple_layout')

@section('content')

<!-- Page content -->
<div class="page-content">

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">

            <!-- Registration form -->
            <form class="login-form" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="icon-plus3 icon-2x text-success border-success border-3 rounded-round p-3 mb-3 mt-1"></i>
                            <h5 class="mb-0">Crear una cuenta</h5>
                            <span class="d-block text-muted">Todos los campos son requeridos</span>
                        </div>

                        <div class="form-group text-center text-muted content-divider">
                            <span class="px-2">Datos de usuario</span>
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input id="name"  type="text" class="form-control" placeholder="Nombre" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            <div class="form-control-feedback">
                                <i class="icon-user-check text-muted"></i>
                            </div>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <span class="form-text text-danger"><i class="icon-cancel-circle2 mr-2"></i> {{ $message }}</span>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input id="email" type="text" class="form-control" placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required autocomplete="email">
                            <div class="form-control-feedback">
                                <i class="icon-mention text-muted"></i>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input minlength="6" id="password" type="password" class="form-control" placeholder="Contraseña" name="password" required autocomplete="new-password">
                            <div class="form-control-feedback">
                                <i class="icon-user-lock text-muted"></i>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group form-group-feedback form-group-feedback-left">
                            <input minlength="6" id="password-confirm" type="password" class="form-control" placeholder="Repetir contraseña" name="password_confirmation" required autocomplete="new-password">
                            <div class="form-control-feedback">
                                <i class="icon-user-lock text-muted"></i>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn bg-teal-400 btn-block">Registrarse<i class="icon-circle-right2 ml-2"></i></button>
                    </div>
                </div>
            </form>
            <!-- /registration form -->

        </div>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->
@endsection
