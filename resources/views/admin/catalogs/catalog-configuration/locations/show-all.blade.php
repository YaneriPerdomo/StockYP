<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de ubicaciones | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../../../css/utilities.css">
    <link rel="stylesheet" href="../css/layouts/_base.css">
    <link rel="stylesheet" href="../css/components/_button.css">
    <link rel="stylesheet" href="../css/components/_footer.css">
    <link rel="stylesheet" href="../css/components/_form.css">
    <link rel="stylesheet" href="../../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../../css/components/_header.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="icon" type="image/x-icon" href="./img/icono.ico">

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
        <article class="form w-adjustable-s  ">
            <div class="flex-full__justify-content-between p-0">
                <div>
                    <legend><b>Listado de Ubicaciones</b></legend>
                </div>
                <div>
                    <a href="{{ route('location.create') }}" class="text-decoration-none text-white">
                        <button class="button button--color-blue">
                            Registar nueva ubicación
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
                                <th>Detalles de ubicación</th>
                                @if (Auth::user()->rol_id == 1)
                                    <th>
                                        Última modificación por
                                    </th>
                                @endif
                                <th>Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($locations->items() == [])
                                <p>No hay cargos registrados por los momentos.</p>
                            @else
                                @foreach ($locations->items() as $value)
                                    <tr class='show'>
                                        <td>{{ $value->name }}</td>
                                        </td>
                                        @if (Auth::user()->rol_id == 1)
                                            <td>
                                                @if ($value->user_id != null)
                                                    @if ($value->user->employee == [])
                                                        {{ 'Administrador(a)' }}
                                                    @else
                                                        @php
                                                            if (str_contains($value->user->rol->name, ')')) {
                                                                echo $value->user->employee->name . ' ' . $value->user->employee->lastname . ' ' . $value->user->rol->name . '';
                                                            } else {
                                                                echo $value->user->employee->name . ' ' . $value->user->employee->lastname . ' (' . $value->user->rol->name . ')';
                                                            }
                                                        @endphp
                                                        <details>
                                                            <summary>Nombre de usuario</summary>
                                                            <p>{{$value->user->user}}</p>
                                                        </details>
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        @endif
                                        <td class='table__operations'>
                                            <a href="{{ route('location.delete', $value->slug)}}">
                                                <button type="button" class="button button--color-red ">
                                                    <i class='bi bi-trash''></i>
                                                                                                                                        </button>
                                                                                                                                    </a>
                                                                                                                                    <a href="{{ route('location.edit', $value->slug)}}">
                                                                                                                                        <button class="button button--color-orange">
                                                                                                                                            <i class="bi bi-pencil-square"></i>
                                                                                                                </button>
                                                                                                            </a>
                                                                                                        </td>
                                                                                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </section>
                <div>
                </div>
                <div class="flex-full__justify-content-between">
                    <div>
                        <p>
                            Mostrando {{ $locations->count() == 1 ? 'registro' : 'registros' }} 1 -
                            {{ $locations->count() }}
                            de un total de {{ $locations->total() }}
                        </p>
                    </div>
                    <div>
                        {{ $locations->links() }}
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