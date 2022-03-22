<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{env('APP_NAME')}}</title>
        <link rel="shortcut icon" href="{{asset(env('APP_ICON'))}}" />

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <img src="{{asset(env('APP_LOGO'))}}" width="70%">
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Ingresa tu correo para restablecer tu contraseña</p>

                    @if (session('status'))
                        <div class="alert alert-success text-justify">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="post" action="{{ url('/password/email') }}">
                        @csrf

                        <div class="form-group has-feedback">
                            <input type="email" class="form-control @if ($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}" placeholder="Correo electrónico">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-5">
                                <a href="{{route('login')}}" class="btn btn-default">
                                    <i class="fa fa-btn fa-arrow-left"></i> Regresar
                                </a>
                            </div>
                            <div class="col-7">
                                <button type="submit" class="btn btn-primary pull-right">
                                    <i class="fa fa-btn fa-envelope"></i> Enviar link de recuperación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://kit.fontawesome.com/a2b6737558.js" crossorigin="anonymous"></script>

    </body>
</html>
