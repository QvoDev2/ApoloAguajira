<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link @if(Request::is('home*')) active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Inicio</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('unp.comisiones.index')}}" class="nav-link @if(Request::is('unp/comisiones*')) active @endif">
                <i class="fas fa-file-signature nav-icon"></i>
                <p>Comisiones</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('cambioContrasena')}}" class="nav-link @if(Request::is('contrasena')) active @endif">
                <i class="nav-icon fas fa-lock"></i>
                <p>Cambiar mi contraseña</p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a class="nav-link">
                <i class="nav-icon fa fa-question-circle"></i>
                <p>
                    Ayuda
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ asset('manuales/UNP.pdf') }}" target="_blank" class="nav-link">
                        <i class="fa fa-info-circle"></i>
                        <p>Manual</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>