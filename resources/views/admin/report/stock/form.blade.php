<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informe de Stock | <x-systen-name></x-systen-name> </title>
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
        <form action="{{ route('stock-report.reportPDF') }}" method="post" class="form w-adjustable-s">
            @csrf
            @method('POST')

            <legend class="form__title">
                <b>Generar Informe de Stock</b>
            </legend>

            <div class="form__item">
                <label for="report_type" class="form__label form__label--required">Tipo de Informe</label>
                <div class="input-group">
                    <span class="form__icon input-group-text @error('report_type') is-invalid--border @enderror"
                        id="report-type-addon">
                        <i class="bi bi-filetype-pdf"></i>
                    </span>
                    <select class="form-select @error('report_type') is-invalid @enderror" name="report_type"
                        id="report_type" aria-label="Seleccione el tipo de informe a generar" required>
                        <option value="" selected disabled>Seleccione una opción de informe</option>
                        <option value="todo">Todos los productos</option>
                        <option value="critico">Productos críticos (en estado de bajo o crítico)</option>
                        <option value="agotado">Productos agotados (fuera de stock)</option>
                    </select>
                </div>
                @error('report_type')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form__button w-100 my-3">
                <button class="button button--color-blue w-100" type="submit">
                    Generar <b>PDF</b>
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