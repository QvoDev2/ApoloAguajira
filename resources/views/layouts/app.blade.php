<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{env('APP_NAME')}}</title>
        <link rel="shortcut icon" href="{{asset(env('APP_ICON'))}}" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/common.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('css/bootstrap-select.css')}}" />
        <link rel="stylesheet" href="{{asset('css/bs-stepper.min.css')}}" />
        <link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.min.css')}}" />
        <link rel="stylesheet" href="{{asset('leaflet/leaflet.css')}}" />
        <link rel="stylesheet" href="{{asset('leaflet/fullscreen/leaflet.fullscreen.css')}}" />
        <link rel="stylesheet" href="{{asset('leaflet/search/Control.OSMGeocoder.css')}}" />
        <style>
            a {
                cursor: pointer;
            }

            .bordered {
                border: 1px solid #ccc !important;
            }
        </style>
        @yield('css')
        @stack('css')
    </head>

    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <a class="btn btn-default btn-flat" onclick="$('#logout-form').submit()">
                        <i class="fas fa-sign-out-alt" style="font-size: 20px; color: black"></i>
                    </a>
                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </nav>

            <aside class="main-sidebar sidebar-light-primary elevation-4">
                <img src="{{asset(env('APP_LOGO'))}}" width="100%">

                <div class="dropdown-divider"></div>

                <div class="sidebar">
                    @include(auth()->user()->perfil->codigo.'.layouts.sidebar')
                </div>
            </aside>

            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <h1>@yield('title')</h1>
                                @yield('breadcrumb')
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    @include('flash::message')
                    <div class="card">
                        @yield('pills')
                        <div class="card-body">
                            @yield('content')
                            <div class="modal fade" id="ventana" tabindex="-1" role="dialog" aria-labelledby="ventanaLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document" id="ventana-size">
                                    <div class="modal-content" id="ventana-content"><div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <footer class="main-footer text-center">
                <strong>QVO &copy; {{date('Y')}} </strong> Todos los derechos reservados.
            </footer>
        </div>

        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/jquery.blockUI.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/ajax-form.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-select.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-datetimepicker.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/bootstrap-filestyle.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/font-awesome.js')}}"></script>
        <script type="text/javascript" src="{{asset('leaflet/leaflet.js')}}"></script>
        <script type="text/javascript" src="{{asset('leaflet/fullscreen/Leaflet.fullscreen.js')}}"></script>
        <script type="text/javascript" src="{{asset('leaflet/search//Control.OSMGeocoder.js')}}"></script>
        {{-- <script type="text/javascript" src="{{asset('js/bs-stepper.min.js')}}"></script> --}}
        <script type="text/javascript">
            $('#ventana').on('hidden.bs.modal', function (e) {
                if (e.target.id == 'ventana')
                    $('#ventana-content').empty()
            })

            function mostrarErroresAjax(res)
            {
                var html = ''
                $.each(res.responseJSON.errors, function (campo, valor) {
                    $.each(valor, function (campo, val) {
                        html += val + "<br>";
                    })
                })
                $("#errores").html(html)
                $("#errores").removeClass("d-none")
            }

            function cargarModal(url, size)
            {
                $.blockUI()
                $('#ventana-content').load(url, function (response, status, request) {
                    $.unblockUI()
                    if (status == 'success'){
                        $('#ventana').modal('show')
                        $('#ventana-size').removeClass('modal-sm').removeClass('modal-md').removeClass('modal-lg').removeClass('modal-xl').addClass(`modal-${size}`)
                    } else
                        Swal.fire(
                            'Ha ocurrido un error',
                            response.responseText,
                            'error'
                        )
                })
            }

            function soloNumeros(valor, decimal = false) {
                var out = ''
                var filtro = decimal ? '0123456789.' :'0123456789'

                for (var i=0; i < valor.length; i++)
                    if (filtro.indexOf(valor.charAt(i)) != -1)
                        out += valor.charAt(i)

                return out;
            }
        </script>
        @stack('scripts')
    </body>
</html>
