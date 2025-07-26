<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paso 4 | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../../../css/utilities.css">
    <link rel="stylesheet" href="../css/layouts/_base.css">
    <link rel="stylesheet" href="../css/components/_button.css">
    <link rel="stylesheet" href="../css/components/_footer.css">
    <link rel="stylesheet" href="../css/components/_form.css">
    <link rel="stylesheet" href="../../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../../css/components/_header.css">
    <link rel="stylesheet" href="../../../css/components/_multiple-steps.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>


<body class="h-100 d-flex flex-column">
     <x-header-admin relativePath='../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <form action='{{ route('warranty-sale.in-repair') }}' method="post" class="form w-adjustable-s">
            @method('POST')
            @csrf
            <input type="hidden" value="{{ $code_sale }}" name="sale_code">
            <div class="button--back">
                <a href="" onclick="historyBack()">
                    <i class="bi bi-arrow-left-square text-grey"></i> <button class="button text-grey"
                        type="button">Volver</button>
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
                        <b>Procesar <br> Garantía</b>
                    </span>
                </div>
                <div class="multiple-steps__number">
                    <b>1</b>
                    <div class="multiple-steps__line"></div>
                    <b class="">2</b>
                    <div class="multiple-steps__line"></div>
                    <b class=" ">3</b>
                    <div class="multiple-steps__line"></div>
                    <b class=" ">4</b>
                </div>
            </div>

            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif

            @if (session('alert-danger'))
                <div class="alert alert-danger">
                    {{ session('alert-danger') }}
                </div>
            @endif
            <fieldset class="form__fieldset">
                <legend class="form_title">
                    <b>Cumplimiento de Garantía: "En Reparación"</b>
                </legend>
                <div class="form__item">
                    <label for="completion_date" class="form__label">Fecha de Finalización</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('completion_date') is-invalid--border @enderror"
                            id="category-addon">
                            <i class="bi bi-calendar"></i>
                        </span>
                        <input type="date" name="completion_date" id="completion_date"
                            class="form-control @error('completion_date') is-invalid @enderror"
                            placeholder="Ej: Ing.Yane Perdomo" aria-label="Apellido del cliente" value="">
                    </div>
                    @error('completion_date') <div class="alert alert-danger mt-1"> </div>
                    @enderror
                </div>
                <div class="form__item">
                    <label for="technical_manager" class="form__label">Técnico Responsable</label>
                    <div class="input-group">
                        <span
                            class="form__icon input-group-text @error('technical_manager') is-invalid--border @enderror"
                            id="category-addon">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="technical_manager" id="technical_manager"
                            class="form-control @error('technical_manager') is-invalid @enderror"
                            placeholder="Ej: Ing.Yane Perdomo" aria-label="Apellido del cliente" value="">
                    </div>
                    @error('technical_manager') <div class="alert alert-danger mt-1"> </div>
                    @enderror
                </div>


                <div class="form__item">
                    <label for="warranty_condition" class="form__label form__label--required">
                        Observaciones Generales
                    </label>
                    <div class="input-group">
                        <span
                            class="form__icon input-group-text @error('warranty_condition') is-invalid--border @enderror"
                            id="warranty-condition-icon">
                            <i class="bi bi-journal-text"></i>
                        </span>
                        <textarea name="general_observations" id="general_observations" rows="3"
                            class="form-control @error('general_observations') is-invalid @enderror"
                            placeholder="Observaciones que se deben tener en cuenta para determinar si el(los) producto(s) pueden ser reparados..."
                            aria-label="Observaciones"></textarea>
                    </div>
                    @error('general_observations')
                        <div id="warranty-condition-error" class="alert alert-danger mt-1" role="alert"></div>
                    @enderror
                </div>

                <div class="form__button w-100 my-3">
                    <button class="button button--color-blue w-100 button--search" type="submit">
                        Guardar Cambios
                    </button>
                </div>
            </fieldset>
        </form>
    </main>


    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>