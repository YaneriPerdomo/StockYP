<header>
    <a href="@php

        $relativePath = match ($search) {
           'false'  => $relativePath,
           'salesHistory'  => '../../../../' ,
           'allStock', 'products' => '../../../'
        };
        if (Auth::user()->rol_id == 1) {
            echo $relativePath . 'bienvenido-a';
        } else {
            if (Auth::user()->employee->gender_id == 1) {
                echo $relativePath . 'bienvenido';
            } else {
                echo $relativePath . 'bienvenida';
            }
        }
    @endphp" class="text-decoration-none text-white fs-4">
        StockYP
    </a>
    <div>
        <div class="top-bar__avatar">
        </div>
        <div class=" dropdown">
            <button class="button text-white button--bg-blue dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Hola, {{ Auth::user()->user ?? 0}}!
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
                <li><a class="dropdown-item" href="@php
                    if (Auth::user()->rol_id == 1) {
                        echo 'bienvenido';
                    } else {
                        if (Auth::user()->gender_id == 1) {
                            echo 'bienvenido';
                        } else {
                            echo 'bienvenida';
                        }
                    }
                @endphp">Inicio</a></li>
                <li><a class="dropdown-item" href="{{ route('configuration.index') }}">
                        @if (Auth::user()->rol_id != 1)
                            Mi Cuenta
                        @else
                            Configuración

                        @endif
                    </a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="dropdown-item">
                        @csrf
                        <button class="button button--logout">Cerrar sesion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>