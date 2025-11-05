<ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}" style="border-radius:8px; margin:0.25rem 0.5rem; transition:all 0.3s;">
            <svg class="nav-icon" style="color:#e6b3cc;">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-speedometer') }}"></use>
            </svg>
            {{ __('Bienvenido') }}
        </a>
    </li>

    @if (auth()->user()->can('ver roles') || auth()->user()->can('ver permisos') || auth()->user()->can('ver usuarios'))
        <li class="nav-group" style="margin:0.5rem 0;">
            <a class="nav-link nav-group-toggle" href="#" style="border-radius:8px; margin:0 0.5rem; transition:all 0.3s;">
                <svg class="nav-icon" style="color:#e6b3cc;">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-shield-alt') }}"></use>
                </svg>
                {{ __('Usuarios-Seguridad') }}
            </a>
            <ul class="nav-group-items" style="padding-left:0.5rem;">
                @can('ver roles')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                            <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-clipboard') }}"></use>
                            </svg>
                            {{ __('Roles') }}
                        </a>
                    </li>
                @endcan

                @can('ver permisos')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                            <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-lock-locked') }}"></use>
                            </svg>
                            {{ __('Permisos') }}
                        </a>
                    </li>
                @endcan

                @can('ver usuarios')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                            <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            {{ __('Usuarios') }}
                        </a>
                    </li>
                @endcan

                @can('bitacora')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bitacora.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                            <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
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
        <li class="nav-group" style="margin:0.5rem 0;">
            <a class="nav-link nav-group-toggle" href="#" style="border-radius:8px; margin:0 0.5rem; transition:all 0.3s;">
                <svg class="nav-icon" style="color:#e6b3cc;">
                    <use xlink:href="{{ asset('icons/coreui.svg#cil-people') }}"></use>
                </svg>
                {{ __('Personal-Clientes') }}
            </a>
            <ul class="nav-group-items" style="padding-left:0.5rem;">
                @can('ver clientes')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clients.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                            <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-user') }}"></use>
                            </svg>
                            {{ __('Clientes') }}
                        </a>
                    </li>
                @endcan

                @can('ver estilistas')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('estilistas.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                            <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
                            </svg>
                            {{ __('Estilistas') }}
                        </a>
                    </li>
                @endcan

                @can('ver horarios')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('horarios.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                            <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                                <use xlink:href="{{ asset('icons/coreui.svg#cil-calendar') }}"></use>
                            </svg>
                            {{ __('Horarios') }}
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endif

    <li class="nav-group" style="margin:0.5rem 0;">
        <a class="nav-link nav-group-toggle" href="#" style="border-radius:8px; margin:0 0.5rem; transition:all 0.3s;">
            <svg class="nav-icon" style="color:#e6b3cc;">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-layers') }}"></use>
            </svg>
            {{ __('Inventario-Herramientas') }}
        </a>
        <ul class="nav-group-items" style="padding-left:0.5rem;">
            @can('ver herramientas')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('herramientas.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-wrench') }}"></use>
                        </svg>
                        {{ __('Herramientas') }}
                    </a>
                </li>
            @endcan
            @can('ver asignacion herramientas')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('asignacion_herramientas.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-hand-point-right') }}"></use>
                        </svg>
                        {{ __('Asignacion Herramientas') }}
                    </a>
                </li>
            @endcan
            @can('ver productos')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('productos.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-spa') }}"></use>
                        </svg>
                        {{ __('Productos') }}
                    </a>
                </li>
            @endcan

        </ul>
    </li>

    <li class="nav-group" style="margin:0.5rem 0;">
        <a class="nav-link nav-group-toggle" href="#" style="border-radius:8px; margin:0 0.5rem; transition:all 0.3s;">
            <svg class="nav-icon" style="color:#e6b3cc;">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-calendar-check') }}"></use>
            </svg>
            {{ __('Servicios-Citas') }}
        </a>
        <ul class="nav-group-items" style="padding-left:0.5rem;">

            @can('ver servicios')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('servicios.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-brush-alt') }}"></use>
                        </svg>
                        {{ __('Servicios') }}
                    </a>
                </li>
            @endcan

            @can('ver servicio productos')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('servicio_productos.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-link') }}"></use>
                        </svg>
                        {{ __('Servicios Productos') }}
                    </a>
                </li>
            @endcan

            @can('ver citas')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('citas.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-calendar') }}"></use>
                        </svg>
                        {{ __('Citas') }}
                    </a>
                </li>
            @endcan

            @can('ver notificaciones')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('notificacions.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-bell') }}"></use>
                        </svg>
                        {{ __('Notificaciones') }}
                    </a>
                </li>
            @endcan

        </ul>
    </li>

    <li class="nav-group" style="margin:0.5rem 0;">
        <a class="nav-link nav-group-toggle" href="#" style="border-radius:8px; margin:0 0.5rem; transition:all 0.3s;">
            <svg class="nav-icon" style="color:#e6b3cc;">
                <use xlink:href="{{ asset('icons/coreui.svg#cil-gift') }}"></use>
            </svg>
            {{ __('Promocion-Comunicacion') }}
        </a>
        <ul class="nav-group-items" style="padding-left:0.5rem;">

            @can('ver promociones')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('promocions.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-star') }}"></use>
                        </svg>
                        {{ __('Promociones') }}
                    </a>
                </li>
            @endcan

            @can('ver promocion servicios')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('promocion_servicios.index') }}" style="border-radius:8px; margin:0.25rem 0.5rem; padding-left:2.5rem; transition:all 0.3s;">
                        <svg class="nav-icon" style="color:#d499b3; width:18px; height:18px;">
                            <use xlink:href="{{ asset('icons/coreui.svg#cil-tags') }}"></use>
                        </svg>
                        {{ __('Promocion Servicios') }}
                    </a>
                </li>
            @endcan
           
        </ul>
    </li>


</ul>
