<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eliminar cuenta | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="stylesheet" href="../../../css/components/_input.css">
    <link rel="stylesheet" href="../../../css/components/_top-bar.css">
    <link rel="stylesheet" href="../../../css/components/_selection-operations.css">
    <link rel="icon" type="image/x-icon" href="./../../img/icono.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>


<body class="h-100 d-flex flex-column">
   
    <x-header-admin relativePath='../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__justify-content-center">
        <article class=" h-100 w-adjustable flex-full__aligh-start  ">
            <div class="card  p-3">
                <div>
                    <b class="card__title">
                        <i class="bi bi-exclamation-diamond"></i>
                        Eliminar Ubicacion
                    </b><br>
                    <span class="card__sub-title">
                        Esta acción es permanente y no se puede deshacer
                    </span>
                    <hr>
                </div>
                <div class="card__message card__message--delete-acount">
                    <i class="text-red"> <u>Advertencia:</u></i><br>
                    <p>
                        La ubicación se eliminará permanentemente. Sin embargo, una vez que la elimines, los productos
                        no se asociarán a ninguna ubicación hasta que selecciones una nueva.
                    </p>
                </div>
                <hr>
                <div class="card__button-option flex-full__justify-content-between ">
                    <a href="{{ route('location.index') }}" class="text-decoration-white card__link-cancel">
                        <button class="button button--color-grey" type="submit">
                            Cancelar
                        </button>
                    </a>
                    <form action="{{ route('location.destroy', $slug) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="card__button button button--color-red" type="submit">
                            Eliminar permanentemente
                        </button>
                    </form>
                </div>
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