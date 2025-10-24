<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <svg class="nav-icon">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            {{ __('Dashboard') }}
        </a>
    </li>

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
                    {{-- user-plus --}}
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

    @can('ver horarios')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('horarios.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                </svg>
                {{ __('Horarios') }}
            </a>
        </li>
    @endcan

    @can('ver citas')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('citas.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                </svg>
                {{ __('Citas') }}
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

    @can('ver notificaciones')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('notificacions.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                </svg>
                {{ __('Notificaciones') }}
            </a>
        </li>
    @endcan
          
    {{-- @can('ver libros')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('books.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-book') }}"></use>
                </svg>
                {{ __('Libros') }}
            </a>
        </li>
    @endcan --}}

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
