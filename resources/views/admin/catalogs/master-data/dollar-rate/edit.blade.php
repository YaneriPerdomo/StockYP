<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta in_bs="viewport" content="width=device-width, initial-scale=1">
    <title>Actualizar Dólar | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="stylesheet" href="../../../css/components/_input.css">
    <link rel="stylesheet" href="../../../css/components/_top-bar.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">
    
    <x-header-admin relativePath='../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <form action="{{ route('dollar-rate.update') }}" method="post" class="form w-adjustable-s">
            @csrf
            @method('PUT')
            <div class="button--back">
                <a href="{{ route('dollar-rate.index') }}">
                    <i class="bi bi-arrow-left-square text-grey"></i>
                    <button class="button text-grey" type="button">Volver a la página anterior</button>
                </a>
            </div>
            <legend class="form__title">
                <b>Actualizar tipo de cambio del dólar a bolívares</b>
            </legend>
            <small class="text-red">
                <p class="m-0">
                    <b>Aviso importante:</b> Al actualizar, todos los precios de los productos se ajustarán a este nuevo
                    tipo de cambio.
                </p>
            </small>
            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif
            <div class="form__item">
                <label for="in_bs" class="form__label form__label--required">Valor en Bolívares (BS)</label>
                <div class="input-group">
                    <span class="form__icon input-group-text @error ('in_bs') is-invalid--border @enderror"
                        id="basic-addon1"><i class="bi bi-newspaper"></i></span>
                    <input type="text"  name="in_bs" id="in_bs"
                        class="form-control @error ('in_bs') is-invalid @enderror" placeholder="Ej: 120.30"
                        aria-label="Ingrese el valor en bolívares" aria-describedby="basic-addon1" autofocus
                        value="{{ number_format($dollar_rate->in_bs, 2, ',', '.') }}">
                </div>
                @error('in_bs')
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
<!---
       <script>

    let formLabel = document.querySelector('form');

    console.info(formLabel);
    formLabel.addEventListener('submit', e => {
        e.preventDefault();
        confirm('Si actualiza, todos los precios de los productos se ajustarán al cambio establecido. ¿Está de acuerdo?');
        console.log('Evento submit detectado.');
        const userConfirmed = confirm('Si actualiza, todos los precios de los productos se ajustarán al cambio establecido. ¿Está de acuerdo?');
        if (userConfirmed) {
            formLabel.submit();
        }
    });
</script>--!>