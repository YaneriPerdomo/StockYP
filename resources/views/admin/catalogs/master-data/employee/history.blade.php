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
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<style>
    .section-history__content {}

    .section-history__block {

        /*
        clip-path: polygon(50% 0%, 95% 0, 100% 8%, 100% 97%, 95% 100%, 48% 100%, 23% 100%, 0 100%, 0 0, 25% 0);
       */
        height: clamp(11rem, 5.6667rem + -106.6667vw, 10rem);
        background: var(--color-blue);
        padding: 1rem;
        color: white;
        border-radius: 0.5rem;
        position: relative;
        width: 300px;
        display: flex;
        flex-direction: column;

        justify-content: space-between;
        filter: drop-shadow(2px 2px #2d2d2d);
    }

    .section-history {
        flex-wrap: wrap;
    }

    .section-history__style-one {
        position: absolute;
        top: 0%;
        width: 20px;
        background: var(--color-black);
        height: 20px;
        left: -0.5rem;
        border-radius: 0.5rem;
    }

    .section-history__style-two {
        position: absolute;
        top: 45%;
        width: 20px;
        background: var(--color-black);
        height: 20px;
        left: -0.5rem;
        border-radius: 0.5rem;
    }

    .section-history__style-thre {
        position: absolute;
        top: 90%;
        width: 20px;
        background: var(--color-black);
        height: 20px;
        left: -0.5rem;
        border-radius: 0.5rem;
    }

    .section-history__option-more-detail {
        text-align: right;
    }
</style>

<body class="h-100 d-flex flex-column">
    <x-header-admin></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <article class="form w-adjustable">
            <div class="flex-full__justify-content-between p-0 mb-3">
                <div>
                    <legend>
                        <b>Historial de Movimientos</b>
                    </legend>
                </div>
            </div>
            <section class="section-history d-flex gap-3">
                @forelse ($purchase_history->items() as $purchase)
                            <div class="section-history__block">
                                <div>
                                    <p class="section-history__data m-0">
                                        {!! $purchase['message'] !!}
                                    </p>
                                    <span>
                                        <strong>Fecha y hora:</strong>
                                        {{  \Carbon\Carbon::parse($purchase['created_at'])->format('Y-m-d\TH:i') }}
                                    </span>
                                </div>
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
                        {{ $purchase_history->total() == 1 ? 'registro' : 'registros' }}.
                    </p>
                </div>

                <div class="pagination-links d-flex justify-content-center mt-3">
                    {{ $purchase_history->links() }}
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