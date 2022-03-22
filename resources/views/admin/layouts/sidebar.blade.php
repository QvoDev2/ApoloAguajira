<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link @if (Request::is('home*')) active @endif">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Inicio</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.escoltas.index') }}"
                class="nav-link @if (Request::is('admin/escoltas*')) active @endif">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Escoltas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.clientes.index') }}"
                class="nav-link @if (Request::is('admin/clientes*')) active @endif">
                <i class="fas fa-building nav-icon"></i>
                <p>Esquemas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.comisiones.index') }}"
                class="nav-link @if (Request::is('admin/comisiones*')) active @endif">
                <i class="fas fa-file-signature nav-icon"></i>
                <p>Comisiones</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.usuarios.index') }}"
                class="nav-link @if (Request::is('admin/usuarios*')) active @endif">
                <i class="nav-icon fas fa-users"></i>
                <p>Usuarios</p>
            </a>
        </li>
        <li class="nav-item has-treeview {{ Request::is('admin/parametrizacion*') ? 'menu-open' : '' }}">
            <a class="nav-link {{ Request::is('admin/parametrizacion*') ? 'active' : '' }}">
                <i class="nav-icon fa fa-user-cog"></i>
                <p>
                    Parametrización
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.tipoListas.index') }}"
                        class="nav-link @if (Request::is('admin/parametrizacion/tipo-listas*')) active @endif">
                        <i class="fa fa-list nav-icon"></i>
                        <p>Listas</p>
                    </a>
                    <a href="{{ route('admin.ciudades.index') }}"
                        class="nav-link @if (Request::is('admin/parametrizacion/ciudades*')) active @endif">
                        <i class="fas fa-map-marked-alt nav-icon"></i>
                        <p>Ciudades</p>
                    </a>
                </li>
            </ul>
            {{-- <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route("admin.vehiculos.index")}}" class="nav-link @if (Request::is('admin/parametrizacion/vehiculos*')) active @endif">
                        <i class="fas fa-car-side nav-icon"></i>
                        <p>Vehículos</p>
                    </a>
                </li>
            </ul> --}}
        </li>
        <li class="nav-item">
            <a href="{{ route('cambioContrasena') }}" class="nav-link @if (Request::is('contrasena')) active @endif">
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
                        <i class="fas fa-user-circle"></i>
                        <p>Manual UNP</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ asset('manuales/UT.pdf') }}" target="_blank" class="nav-link">
                        <i class="far fa-user-circle"></i>
                        <p>Manual UT</p>
                    </a>
                </li>
            </ul>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ asset('manuales/Técnico.pdf') }}" target="_blank" class="nav-link">
                        <i class="fas fa-users-cog"></i>
                        <p>Manual técnico</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
