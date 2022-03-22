<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link @if(Request::is('home*')) active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Inicio</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('union_temporal.escoltas.index')}}" class="nav-link @if(Request::is('union_temporal/escoltas*')) active @endif">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Escoltas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('union_temporal.clientes.index')}}" class="nav-link @if(Request::is('union_temporal/clientes*')) active @endif">
                <i class="fas fa-building nav-icon"></i>
                <p>Esquemas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('union_temporal.comisiones.index')}}" class="nav-link @if(Request::is('union_temporal/comisiones*')) active @endif">
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
    </ul>
</nav>