<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Ampliar el Periodo de Garantía | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../../../css/utilities.css">
    <link rel="stylesheet" href="../css/layouts/_base.css">
    <link rel="stylesheet" href="../css/components/_button.css">
    <link rel="stylesheet" href="../css/components/_footer.css">
    <link rel="stylesheet" href="../css/components/_form.css">
    <link rel="stylesheet" href="../../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../../css/components/_header.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="../css/components/_multiple-steps.css">
        <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">
     <x-header-admin relativePath='../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <form action='{{ route('warranty-sale.warranty-extesion-form-post', $code_sale) }}' method="post"
            class="form w-adjustable-s">
            @method('POST')
            @csrf
            <div class="button--back">
                <a href="" onclick="historyBack()">
                    <i class="bi bi-arrow-left-square text-grey"></i> <button class="button text-grey"
                        type="button">Volver </button>
                </a>
                <script>
                    function historyBack() {
                        return history.back();
                    }
                </script>
            </div>
                                <legend><b>Seguimientos de Ventas y Garantias</b></legend>

            <div class="multiple-steps">
                <div class="flex-full__justify-content-between p-0 multiple-steps__context">
                    <span class="multiple-steps__text">
                        Buscar Venta <br> por Código
                    </span>
                    <span class="multiple-steps__text">

                        Ver Detalles <br> de la Venta

                    </span>
                    <span class="multiple-steps__text">
                        Seleccionar Condiciones <br> de Garantía
                    </span>
                    <span class="multiple-steps__text">
                        Procesar <br> Garantía
                    </span>
                </div>
                <div class="multiple-steps__number">
                    <b>1</b>
                    <div class="multiple-steps__line--interrupted   multiple-steps__line"></div>
                    <b class="multiple-steps__wait ">2</b>
                    <div class="multiple-steps__wait multiple-steps__line  "></div>
                    <b class="multiple-steps__wait">3</b>
                    <div class="multiple-steps__wait multiple-steps__line  "></div>
                    <b class="multiple-steps__wait">4</b>
                </div>
            </div>


            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif
            <legend class="form__title">
                <b>
                    Ampliar el Periodo de Garantía
                </b>
            </legend>
            <div class="form__item">
                <label for="expiration_date" class="form__label form__label--required">Fecha de garantía</label>
                <div class="input-group">
                    <span class="form__icon input-group-text @error('expiration_date') is-invalid--border @enderror"
                        id="sale-code-icon">
                        <i class="bi bi-tag-fill"></i> </span>
                    <input type="date" name="expiration_date" id="sale_code"
                        class="form-control @error('expiration_date') is-invalid @enderror" placeholder="Ej: KfdVNC4F"
                        aria-label="Código único de la venta para buscar garantía" aria-describedby="sale-code-icon"
                        autofocus value="{{ $sale->expiration_date }}">
                </div>
                @error('expiration_date')
                    <div class="alert alert-danger mt-1" role="alert">{{ $message }}</div>
                @enderror
            </div>

            <div class="form__button w-100 my-3">
                <button class="button button--color-blue w-100 button--search" type="submit">
                    Guardar Cambios
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