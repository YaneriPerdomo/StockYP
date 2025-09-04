<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informe de Ventas | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="stylesheet" href="../../../css/components/_input.css">
    <link rel="stylesheet" href="../../../css/components/_top-bar.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="icon" type="image/x-icon" href="./img/icono.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">

    <x-header-admin relativePath='../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <form action="{{ route('sale-report.dayReport') }}" method="post" class="form w-adjustable-s">
            @csrf
            @method('POST')
            @if (session('alert-danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('alert-danger') }}
                </div>
            @endif
            <legend class="form__title mb-2">
                <b>
                    Generar Informe de Ventas
                </b>
            </legend>
            <div class="d-flex justify-content-center align-items-center gap-3 mb-0">
                <label for="option-1" class="form-check-label">
                    <input type="radio" name="tipoGenerarPdf" id="option-1" value="generalSummary"
                        class="form-check-input">
                    <span>Resumen General</span>
                </label>
                <label for="option-3" class="form-check-label">
                    <input type="radio" name="tipoGenerarPdf" id="option-3" value="tenProducts"
                        class="form-check-input">
                    <span>Los 10 productos mas vendidos</span>
                </label>
            </div>

            <div class="form__item">
                <label for="" class="form__label ">Fecha Inicial</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error ('start_date') is-invalid--border @enderror"
                        id="basic-addon1"><i class="bi bi-calendar"></i></span>
                    <input type="date" name="start_date" class="form-control @error ('start_date') is-invalid @enderror"
                        placeholder="Ej: Estante tipo A" aria-label="start_date" aria-describedby="basic-addon1"
                        autofocus value="">
                </div>
                @error('start_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form__item">
                <label for="" class="form__label ">Fecha Final</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error ('end_date') is-invalid--border @enderror"
                        id="basic-addon1"><i class="bi bi-calendar"></i></span>
                    <input type="date" name="end_date" class="form-control @error ('end_date') is-invalid @enderror"
                        placeholder="Ej: Estante tipo A" aria-label="Username" aria-describedby="basic-addon1" autofocus
                        value="">
                </div>
                @error('end_date')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form__item ">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="day" value="1"
                        id="switchCheckDefault">
                    <label class="form-check-label" for="switchCheckDefault">
                        Hoy (Si selecciona esta casilla no se tendrá en cuenta el rango de fechas)
                    </label>
                </div>

            </div>
            <div class="form__button w-100 my-3">
                <button class="button button--color-blue w-100" type="submit">
                    Generar <b>PDF</b>
                </button>
            </div>
        </form>
    </main>
    <x-footer></x-footer>
    <script src="../../../public/js/cdn.js" type="module"></script>
    
</body>

</html>