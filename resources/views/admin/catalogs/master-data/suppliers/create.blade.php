<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registar Nuevo Proveedor | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="stylesheet" href="../../../css/components/_input.css">
    <link rel="stylesheet" href="../../../css/components/_top-bar.css">
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
        <form action="{{ route('supplier.store') }}" method="post" class="form w-adjustable">
            @csrf
            @method('POST')
            <div class="button--back">
                <a href="{{ route('supplier.index') }}">
                    <i class="bi bi-arrow-left-square text-grey"></i> <button class="button text-grey"
                        type="button">Volver al listado de proveedores</button>
                </a>
            </div>
            <legend class="form__title">
                <b> Registrar Nuevo Proveedor</b>
            </legend>

            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif
            <div class="form__item">
                <label for="name" class="form__label form__label--required">Nombre del Proveedor</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error ('name') is-invalid--border @enderror"
                        id="basic-addon1">
                        <i class="bi bi-building"></i> </span>
                    <input type="text" name="name" id="name" class="form-control @error ('name') is-invalid @enderror"
                        placeholder="Ej: Don Pescadon" aria-label="Nombre del Proveedor" aria-describedby="basic-addon1"
                        autofocus value="{{ old('name') }}">
                </div>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form__item">
                <label for="gender" class="form__label form__label--required">Género</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error ('gender_id') is-invalid--border @enderror"
                        id="basic-addon1">
                        <i class="bi bi-gender-ambiguous"></i> </span>
                    <select class="form-select  @error('gender_id') is-invalid @enderror" name="gender_id" id="gender"
                        aria-label="Seleccione el género">
                        <option selected disabled>Seleccione una opción</option>
                        <option value="1">Masculino</option>
                        <option value="2">Femenino</option>
                    </select>
                </div>
                @error('gender_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form__item">
                <label for="identity_card_id" class="form__label form__label--required">Tipo de identidad</label>
                <div class="input-group">
                    <span class="form__icon input-group-text @error('identity_card_id') is-invalid--border @enderror"
                        id="identity-type-addon"><i class="bi bi-card-heading"></i></span>
                    <select class="form-select @error('identity_card_id') is-invalid @enderror" name="identity_card_id"
                        id="identity_card_id" aria-label="Seleccione el tipo de documento de identidad">
                        <option selected disabled>Seleccione una opción</option>
                        @foreach ($identity_cards as $value)
                            <option value="{{ $value->identity_card_id }}"> {{$value->identity_card}}</option>
                        @endforeach

                    </select>
                </div>
                @error('identity_card_id') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="form__item">
                <label for="card" class="form__label form__label--required">Número de identificación</label>
                <div class="input-group">
                    <span class="form__icon input-group-text @error('card') is-invalid--border @enderror"
                        id="card-number-addon"><i class="bi bi-credit-card"></i></span>
                    <input type="text" name="card" id="card" class="form-control @error('card') is-invalid @enderror"
                        placeholder="Ej: 12345678" aria-label="Número de documento de identidad del cliente"
                        value="{{ old('card') }}">
                </div>
                @error('card') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="form__item">
                <label for="telephone_number" class="form__label">Número de Teléfono</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error ('telephone_number') is-invalid--border @enderror"
                        id="basic-addon1">
                        <i class="bi bi-telephone"></i> </span>
                    <input type="text" name="telephone_number" id="telephone_number"
                        class="form-control @error ('telephone_number') is-invalid @enderror"
                        placeholder="Ej: 58+ 412-1234567" aria-label="Número de Teléfono"
                        aria-describedby="basic-addon1" autofocus value="{{ old('telephone_number') }}">
                </div>
                @error('telephone_number')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form__item">
                <label for="address" class="form__label ">Dirección</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error ('address') is-invalid--border @enderror"
                        id="basic-addon1">
                        <i class="bi bi-house"></i> </span>
                    <textarea name="address" id="address" rows="2"
                        class="form-control @error ('address') is-invalid @enderror"
                        placeholder="Ej: Sierra Maestra, Calle 10, entre av. 10 y 11, #10-61 Diagonal al Vivero Girasol, Maracaibo, Venezuela"
                        aria-label="Dirección del Proveedor"
                        aria-describedby="basic-addon1">{{old('address')}}</textarea>
                </div>
                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form__item ">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="active" value="1"
                        id="switchCheckDefault">
                    <label class="form-check-label" for="switchCheckDefault">
                        Activo  
                    </label>
                </div>

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