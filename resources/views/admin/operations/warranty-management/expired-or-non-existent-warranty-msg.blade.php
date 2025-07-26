<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Mensaje importante | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../../../css/utilities.css">
    <link rel="stylesheet" href="../css/layouts/_base.css">
    <link rel="stylesheet" href="../css/components/_button.css">
    <link rel="stylesheet" href="../css/components/_footer.css">
    <link rel="stylesheet" href="../css/components/_multiple-steps.css">
    <link rel="stylesheet" href="../css/components/_form.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../../css/components/_header.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">
     <x-header-admin relativePath='../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <article class=" h-100 w-adjustable-s flex-full__aligh-start  ">
            <div class="form p-3 msg">

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
                            Procesar <br> Garantía
                        </span>
                    </div>
                    <div class="multiple-steps__number">
                        <b>1</b>
                        <div class="  multiple-steps__line multiple-steps__error"></div>
                        <b class="multiple-steps__wait">2</b>
                        <div class="multiple-steps__wait multiple-steps__line  "></div>
                        <b class="multiple-steps__wait">3</b>
                        <div class="multiple-steps__wait multiple-steps__line  "></div>
                        <b class="multiple-steps__wait">4</b>
                    </div>
                </div>

                <div class="msg__header mt-1">
                    <b class=" text-red fs-5">
                        <i class="bi bi-exclamation-diamond"></i>
                        Mensaje importante
                    </b><br>
                    <hr>
                </div>
                <div class="msg__body">
                    <p>
                        {!! $msg !!}
                    </p>
                </div>
                <hr>
            </div>
            <hr>
        </article>
    </main>


    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>