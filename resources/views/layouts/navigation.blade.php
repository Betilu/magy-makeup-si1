<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            {{ __('Bienvenido') }}
        </a>
    </li>

    @if (auth()->user()->can('ver roles') || auth()->user()->can('ver permisos') || auth()->user()->can('ver usuarios'))
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-shield-alt') }}"></use>
                </svg>
                {{ __('G.Usuarios y Seguridad') }}
            </a>
            <ul class="nav-group-items">
                @can('ver roles')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-clipboard') }}"></use>
                            </svg>
                            {{ __('Roles') }}
                        </a>
                    </li>
                @endcan

                @can('ver permisos')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                            </svg>
                            {{ __('Permisos') }}
                        </a>
                    </li>
                @endcan

                @can('ver usuarios')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            {{ __('Usuarios') }}
                        </a>
                    </li>
                @endcan

                @can('bitacora')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bitacora.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                            </svg>
                            {{ __('Bitacora') }}
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif

    @if (auth()->user()->can('ver clientes') || auth()->user()->can('ver estilistas'))
        <li class="nav-group">
            <a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-people') }}"></use>
                </svg>
                {{ __('G.Personal y Clientes') }}
            </a>
            <ul class="nav-group-items">
                @can('ver clientes')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            {{ __('Clientes') }}
                        </a>
                    </li>
                @endcan

                @can('ver estilistas')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('estilistas.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            {{ __('Estilistas') }}
                        </a>
                    </li>
                @endcan

                @can('ver horarios')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('horarios.index') }}">
                            <svg class="nav-icon">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-calendar') }}"></use>
                            </svg>
                            {{ __('Horarios') }}
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif

    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
            </svg>
            {{ __('G.Inventario y Herramientas') }}
        </a>
        <ul class="nav-group-items">
            @can('ver herramientas')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('herramientas.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Herramientas') }}
                    </a>
                </li>
            @endcan
            @can('ver asignacion herramientas')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('asignacion_herramientas.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Asignacion Herramientas') }}
                    </a>
                </li>
            @endcan
            @can('ver productos')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Productos') }}
                    </a>
                </li>
            @endcan

        </ul>
    </li>

    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
            </svg>
            {{ __('G.Servicios y Citas') }}
        </a>
        <ul class="nav-group-items">

            @can('ver servicios')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('servicios.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Servicios') }}
                    </a>
                </li>
            @endcan

            @can('ver servicio productos')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('servicio_productos.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Servicios Productos') }}
                    </a>
                </li>
            @endcan

            @can('ver citas')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('citas.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Citas') }}
                    </a>
                </li>
            @endcan

            @can('ver notificaciones')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notificacions.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Notificaciones') }}
                    </a>
                </li>
            @endcan

        </ul>
    </li>

    <li class="nav-group">
        <a class="nav-link nav-group-toggle" href="#">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
            </svg>
            {{ __('G.Promocion y Comunicacion') }}
        </a>
        <ul class="nav-group-items">

            @can('ver promociones')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('promocions.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Promociones') }}
                    </a>
                </li>
            @endcan

            @can('ver promocion servicios')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('promocion_servicios.index') }}">
                        <svg class="nav-icon">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                        </svg>
                        {{ __('Promocion Servicios') }}
                    </a>
                </li>
            @endcan
           
        </ul>
    </li>


</ul>
