<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Empleados | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../../../css/utilities.css">
    <link rel="stylesheet" href="../css/layouts/_base.css">
    <link rel="stylesheet" href="../css/components/_button.css">
    <link rel="stylesheet" href="../css/components/_footer.css">
    <link rel="stylesheet" href="../css/components/_form.css">
    <link rel="stylesheet" href="../../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../../css/components/_header.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<style>
    .article--all-job {
        align-self: start;
    }

    .table__operations {
        display: flex !important;
        gap: 0.5rem;
    }
</style>

<body class="h-100 d-flex flex-column">
    
    <x-header-admin relativePath='../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <article class="form  w-adjustable ">
            <div class="flex-full__justify-content-between p-0">
                <div>
                    <legend><b>Listado de Empleados</b></legend>
                </div>
                <div>
                    <a href="{{ route('employee.create') }}" class="text-decoration-none text-white">
                        <button class="button button--color-black">
                            Registrar Nuevo Empleado
                        </button>
                    </a>
                </div>
            </div>
            <div class="">
                @if (session('alert-success'))
                    <div class="alert alert-success">
                        {{ session('alert-success') }}
                    </div>
                @endif
                <section class='table'>
                    <table class='dataTable'>
                        <thead>
                            <tr>
                              
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Tipo de Identificación</th>
                                <th>Número de Identificación</th>
                                <th>Número de Teléfono</th>
                                <th>Dirección</th>
                                  <th>Nombre de Usuario</th>
                                <th>Rol de Acceso</th>
                                <th>
                                    Estado de la cuenta
                                </th> 
                                <th>Fecha de Registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees->items() as $value)
                                <tr class='show'>
                                  
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->lastname }}</td>
                                    <td>
                                        {{ $value->identityCard->identity_card }}

                                    </td>
                                    <td>{{ $value->card }}</td>
                                    <td>{{ $value->phone }}</td>
                                    <td>{{ $value->address }}</td>
                                      <td>{{ $value->user->user }}</td>
                                       <td>{{ $value->user->rol->name }}</td>
                                    <td>
                                        @if ($value->gender_id == 1)
                                            @if ($value->user->state == 1)
                                                Activo
                                            @else
                                                Inactivo
                                            @endif
                                        @else
                                            @if ($value->user->state == 1)
                                                Activa
                                            @else
                                                Inactiva
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $date = new DateTime($value->created_at);
                                            $formatter = new IntlDateFormatter(
                                                'es_ES',
                                                IntlDateFormatter::LONG,
                                                IntlDateFormatter::NONE,
                                                'America/Caracas', // Set to Maracaibo's timezone
                                                IntlDateFormatter::GREGORIAN
                                            );
                                            echo $formatter->format($date);
                                        @endphp
                                    </td>
                                    <td class='table__operations'>
                                        <a href=" @if ($value->gender_id == 1)
                                            {{ 'empleado' . '/' . $value->slug . '/eliminar' }}
                                        @else
                                                {{ 'empleada' . '/' . $value->slug . '/eliminar' }}
                                            @endif  " title="Eliminar Empleado">
                                            <button type="button" class="button button--color-red">
                                                <i class='bi bi-trash'></i>
                                            </button>
                                        </a>
                                        <a href="
                                                                    @if ($value->gender_id == 1)
                                                                        {{ 'empleado' . '/' . $value->slug . '/editar' }}
                                                                    @else
                                                                        {{ 'empleada' . '/' . $value->slug . '/editar' }}
                                                                    @endif " title="Editar Empleado">
                                            <button class="button button--color-orange">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </a>
                                        <a href="historial/{{ $value->slug }}/emplead{{ $value->gender_id == 1 ? 'o' : 'a' }}"
                                            title="Historial">
                                            <button class="button button--color-vinotinto">
                                                <i class="bi bi-journal-text"></i>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" style="text-align: center;">No hay empleados registrados por el
                                        momento.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
                <div>
                </div>
                <div class="flex-full__justify-content-between">
                    <div>
                        <p>
                            Mostrando {{ $employees->count() == 1 ? 'registro' : 'registros' }} 1 -
                            {{ $employees->count() }}
                            de un total de {{ $employees->total() }}
                        </p>
                    </div>
                    <div>
                        {{ $employees->links() }}
                    </div>
                </div>
            </div>
        </article>
    </main>


    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>