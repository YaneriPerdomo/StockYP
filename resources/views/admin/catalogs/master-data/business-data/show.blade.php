<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Datos de la Empresa | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/layouts/_base.css">
    <link rel="stylesheet" href="../css/components/_button.css">
    <link rel="stylesheet" href="../css/components/_footer.css">
    <link rel="stylesheet" href="../css/components/_form.css">
    <link rel="stylesheet" href="../css/components/_header.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="../css/components/_top-bar.css">
        <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>


<body class="h-100 d-flex flex-column">

    
    <x-header-admin relativePath='../'></x-header-admin>
    <x-selection-operations> </x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <form action="{{ route('business-data.update', $business_data->id) }}" method="post" class="form w-adjustable">
            @csrf
            @method('PUT')

            <legend class="form__title">
                <b>Datos de la Empresa</b>
            </legend>

            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif

            <fieldset>
                <div class="form__item">
                    <label for="business_name" class="form__label form__label--required">Nombre de la empresa</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('business_name') is-invalid--border @enderror"
                            id="business-name-addon"><i class="bi bi-shop"></i></span>
                        <input type="text" name="business_name" id="business_name"
                            class="form-control @error('business_name') is-invalid @enderror"
                            placeholder="Ej: Mi Tienda S.A." aria-label="Nombre del Negocio" autofocus
                            value="{{ $business_data->name }}">
                    </div>
                    @error('business_name') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="form__item">
                    <label for="business_rif" class="form__label "> Tipo de identidad  </label>
                    <div class="input-group">
                        <span
                            class="form__icon input-group-text @error('identity_card_id') is-invalid--border @enderror"
                            id="category-addon"><i class="bi bi-person-badge"></i></span>
                        <select class="form-select @error('identity_card_id') is-invalid @enderror"
                            name="identity_card_id" id="identity_card_id"
                            aria-label="Seleccione la categoría del producto">
                            <option selected >Seleccione una opción</option>
                            @foreach ($rif as $value)
                                <option value="{{ $value->identity_card_id }}"
                                     {{ $business_data->identity_card_id == $value->identity_card_id ? 'selected' : '' }}>
                                     
                                    {{ $value->identity_card }} 
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('business_rif') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="form__item">
                    <label for="rif" class="form__label ">  Número de identificación </label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('rif') is-invalid--border @enderror"
                            id="business-rif-addon"><i class="bi bi-card-heading"></i></span>
                        <input type="text" name="rif" id="rif"
                            class="form-control @error('rif') is-invalid @enderror" placeholder="Ej: 310487265"
                            aria-label="Teléfono del Negocio" value="{{  $business_data->rif }}">
                    </div>
                    @error('rif') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="form__item">
                    <label for="phone" class="form__label ">Teléfono</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('phone') is-invalid--border @enderror"
                            id="business-phone-addon"><i class="bi bi-phone"></i></span>
                        <input type="text" name="phone" id="phone"
                            class="form-control @error('phone') is-invalid @enderror" placeholder="Ej: +58 412 1234567"
                            aria-label="Teléfono del Negocio" value="{{ $business_data->phone }}">
                    </div>
                    @error('phone') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="form__item">
                    <label for="email" class="form__label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('email') is-invalid--border @enderror"
                            id="business-email-addon"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Ej: info@minegocio.com" aria-label="Correo Electrónico del Negocio"
                            value="{{  $business_data->email }}">
                    </div>
                    @error('email') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="form__item">
                    <label for="address" class="form__label form__label--required">Dirección</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('address') is-invalid--border @enderror" id="address-addon">
                            <i class="bi bi-geo-alt"></i>
                        </span>
                        <textarea name="address" id="address" rows="3"
                            class="form-control @error('address') is-invalid @enderror"
                            placeholder="Ej: Calle 10, Casa #5, Sector La Lago."
                            aria-label="Dirección del Negocio">{{ $business_data->address }}</textarea>
                    </div>
                    @error('address') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
                </div>
            </fieldset>

            <div class="form__button w-100">
                <button class="button button--color-blue w-100" type="submit">
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