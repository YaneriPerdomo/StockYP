<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial de movimiento de {{$type}} especificado | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../../../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">
     <x-header-admin relativePath='../../../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <article class="form w-adjustable">
            <div class="button--back">
                <a href="{{ route('spurchase-history.index') }}">
                    <i class="bi bi-arrow-left-square text-grey"></i> <button class="button text-grey"
                        type="button">Volver al historial de movimientos</button>
                </a>
            </div>
            <legend class="form__title">
                <b>Historial de movimiento de {{$type}} especificado</b>
            </legend>
            <div class="form__item">
                <label for="product" class="form__label  ">Responsable</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error('purchase_datetime') is-invalid--border @enderror"
                        id="datetime-addon">
                        <i class="bi bi-calendar"></i> {{-- Or bi bi-clock, or bi bi-calendar-check --}}
                    </span>
                    <input type="text" name="purchase_datetime" id="purchase_datetime" class="form-control"
                        aria-label="Fecha y hora de la compra" aria-describedby="datetime-addon" value="{{ $responsible != 'Administrador(a)' ?  $responsible->name . ' ' .$responsible->lastname . ' (' . $responsible->user->rol->name .')' : 'Administrador(a)' }}" disabled>
                </div>
            </div>
            <div class="form__item">
                <label for="description" class="form__label">Motivo de la {{$type}}</label>
                <div class="input-group">
                    <span class="form__icon input-group-text @error('description') is-invalid--border @enderror"
                        id="description-addon"><i class="bi bi-text-paragraph"></i></span>
                    <textarea name="description" id="description" rows="3" disabled class="form-control "
                        placeholder="Breve descripción de la mercancía (material, características, etc.)"
                        aria-label="Descripción de la mercancía">{{$purchase_history['description'] ?? 'No hay descripción'}}</textarea>
                </div>
                @error('description') <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="form__item">
                <label for="product" class="form__label  ">Fecha y hora de {{$type}}</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error('purchase_datetime') is-invalid--border @enderror"
                        id="datetime-addon">
                        <i class="bi bi-calendar"></i> {{-- Or bi bi-clock, or bi bi-calendar-check --}}
                    </span>
                    <input type="datetime-local" name="purchase_datetime" id="purchase_datetime" class="form-control"
                        aria-label="Fecha y hora de la compra" aria-describedby="datetime-addon" value="{{ \Carbon\Carbon::parse($purchase_history['created_at'])
    ->format('Y-m-d\TH:i') }}" disabled>
                </div>
            </div>
            <section class='table' data-count='0'>
                <table class='dataTable'>
                    <thead>
                        <tr>
                            <th>Código del producto</th>
                            <th>Nombre del producto</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody class="table-insert">

                        @forelse ($purchase_history2->items() as $detail)
                            <tr class='show'>
                                <td>
                                    {{ $detail['products']['code'] ?? '' }}
                                </td>
                                <td>
                                    {{ $detail['products']['name'] ?? '' }}
                                </td>
                                <td>
                                    {{ $detail['amount'] ?? '' }}
                                </td>
                            <tr>
                        @empty
                                <tr>
                                    <td colspan="3" class="text-center">No se encontraron detalles de productos para esta
                                        compra.</td>
                                </tr>
                            @endforelse
                    </tbody>
                </table>
            </section>
            <div class="flex-full__justify-content-between">
                <div class="pagination-summary mt-3 text-center">
                    <p>

                        Mostrando
                        <span class="fw-bold">{{ $purchase_history2->firstItem() }}</span>
                        a
                        <span class="fw-bold">{{ $purchase_history2->lastItem() }}</span>
                        de un total de
                        <span class="fw-bold">{{ $purchase_history2->total() }}</span>
                        {{ $purchase_history2->total() == 1 ? 'producto registrado' : 'productos registrados' }}.
                    </p>
                </div>

                <div class="pagination-links d-flex justify-content-center mt-3">
                    {{ $purchase_history2->links() }}
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