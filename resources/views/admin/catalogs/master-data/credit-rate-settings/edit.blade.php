<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta credit_rate="viewport" content="width=device-width, initial-scale=1">
    <title>Actualizar la Tasa de Crédito | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="stylesheet" href="../../../css/components/_input.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../../../css/components/_top-bar.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">
    
    <x-header-admin relativePath='../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <form action="{{ route('credit-rate-settings.update') }}" method="post" class="form w-adjustable-s">
            @csrf
            @method('PUT')
            <div class="button--back">
                <a href="{{ route('credit-rate-settings.index') }}">
                    <i class="bi bi-arrow-left-square text-grey"></i>
                    <button class="button text-grey" type="button">Volver a la página anterior</button>
                </a>
            </div>
            <legend class="form__title">
                <b>Actualizar la Tasa de Interés del Crédito </b>
            </legend>
            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif
            <div class="form__item">
                <label for="credit_rate" class="form__label form__label--required"> Tasa de Interés del Crédito </label>
                <div class="input-group">
                    <span class="form__icon input-group-text @error ('credit_rate') is-invalid--border @enderror"
                        id="basic-addon1"><i class="bi bi-newspaper"></i></span>
                    <input type="text" name="credit_rate" id="credit_rate"
                        class="form-control @error ('credit_rate') is-invalid @enderror" placeholder="Ej: 8 (para 8%)"
                        aria-label="Impuesto al Valor Añadido (credit_rate)" aria-describedby="basic-addon1" autofocus
                        value="{{ $credit_rate->value ?? 0 }}">
                </div>
                @error('credit_rate')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form__button w-100 my-3">
                <button class="button button--color-blue w-100" type="submit">
                    Guardar cambios
                </button>
            </div>
        </form>
    </main>


    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>