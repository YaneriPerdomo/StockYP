<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial de Movimientos | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_delete-h-100.css">
    <link rel="stylesheet" href="../../../css/pages/_purchase-history.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">
     <x-header-admin relativePath='../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 m-0 ">
        <article class="row m-0">
            <div class="col-lg-8 col-12"  style="  padding-right: 0;">
                <section class="p-2 mt-2">
                    <div class="form  m-0">
                        <div class="flex-full__justify-content-between p-0 mb-3">
                            <div>
                                <legend>
                                    <b>Historial de Movimientos</b>
                                </legend>
                            </div>
                        </div>
                        @if (session('alert-success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('alert-success') }}
                            </div>
                        @endif
                        @if (session('alert-danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('alert-danger') }}
                            </div>
                        @endif
                        <section class="section-history d-flex gap-3">
                            @forelse ($purchase_history->items() as $purchase)
                                                    <div class="section-history__block">
                                                        <div>
                                                            <p class="section-history__data m-0">
                                                                {!! $purchase['message'] !!}
                                                            </p>
                                                            <span>
                                                                <strong>Fecha y hora:</strong>
                                                                {{  \Carbon\Carbon::parse($purchase['created_at'])
                                                                    ->format('Y-m-d\TH:i') }}
                                                            </span>
                                                        </div>
                                                        {{-- Elementos de estilo o decorativos --}}
                                                        <form action="{{ route('spurchase-history.one-delete', $purchase['merchandise_history_id']) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                             <button class="section-history__delete"><i class="bi bi-x-lg"></i></button>
                                                        </form>
                                                        <span class="section-history__style-one"></span>
                                                        <span class="section-history__style-two"></span>
                                                        <span class="section-history__style-thre"></span>

                                                        @if ($purchase['good_id'] != null || $purchase['return_merchandise_id'] != null)
                                                            <div class="section-history__option-more-detail">
                                                               
                                                                 <a href="{{ route('spurchase-history.show', [$purchase['good_id'] ?? $purchase['return_merchandise_id'], $purchase['good_id'] == null ? 'salida' : 'entrada'])}}"
                                                                    class="section-history__link text-decoration-none text-white">
                                                                    <i>Ver más detalles</i>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                            @empty
                                {{-- Mensaje a mostrar si no hay historial de compras --}}
                                <p class="text-muted m-0">No se encontraron registros en tu historial de movimientos.</p>
                            @endforelse
                        </section>
                        <div class="flex-full__justify-content-between p-0">
                            <div class="pagination-summary mt-3 text-center">
                                <p>

                                    Mostrando
                                    <span class="fw-bold">{{ $purchase_history->firstItem() }}</span>
                                    a
                                    <span class="fw-bold">{{ $purchase_history->lastItem() }}</span>
                                    de un total de
                                    <span class="fw-bold">{{ $purchase_history->total() }}</span>
                                    {{ $purchase_history->total() <= 1 ? 'registro' : 'registros' }}.
                                </p>
                            </div>

                            <div class="pagination-links d-flex justify-content-center mt-3">
                                {{ $purchase_history->links() }}
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-lg-4 col-12" style="padding-left: 0;">
                <section class="p-2 mt-2">
                    <div class="form m-0">
                        <button class="button button--color-red w-100" type="button" data-bs-toggle="modal"
                            @if (!$purchase_history->items())
                                disabled
                            @endif
                            style="
                            @if (!$purchase_history->items())
                                background: rgb(240, 96, 91) !important
                            @endif
                            "
                            data-bs-target="#staticBackdrop">Eliminar todo el historial</button>
                        <hr>
                        <p class="text-muted m-0">El botón de arriba, te permitirá eliminar todos los registros contenidos
                            en el Historial de Movimientos de forma permanente. Ten en cuenta que esta acción es
                            irreversible
                            y una vez confirmada, no podrás recuperar la información. Por favor, asegúrate de que
                            realmente
                            deseas proceder antes de continuar.</p>
                    </div>
                </section>
            </div>
        </article>
    </main>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header background-red">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Eliminar todo el historial de movimientos</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar todo el historial de transacciones de entrada y salida?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('spurchase-history.all-delete') }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn button--color-red text-white">Si, @php
                            if (Auth::user()->rol_id == 1) {
                                echo 'Seguro/a';
                            } else {
                                $show = match (Auth::user()->employee->gender_id) {
                                    1 => 'Seguro',
                                    2 => 'Segura',
                                    default => 'null'
                                };
                                echo $show;
                            }
                        @endphp</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>


</body>

</html>