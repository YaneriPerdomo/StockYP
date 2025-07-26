<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @if (Auth::user()->rol_id != 1)
                            Mi Cuenta
                        @else
                            Configuración

                        @endif | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../css/utilities.css">
    <link rel="stylesheet" href="../css/layouts/_base.css">
    <link rel="stylesheet" href="../css/components/_button.css">
    <link rel="stylesheet" href="../css/components/_footer.css">
    <link rel="stylesheet" href="../css/components/_form.css">
    <link rel="stylesheet" href="../css/components/_header.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="../css/components/_top-bar.css">
    <link rel="icon" type="image/x-icon" href="./img/icono.ico">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>


<body class="h-100 d-flex flex-column">

    
    <x-header-admin relativePath='../'></x-header-admin>
    <x-selection-operations> </x-selection-operations>
    <main class="flex__grow-2">
        <article class="container-xxl h-100 my-2 ">   
              <section class="forms my-3">
            @if (Auth::user()->rol_id == 4 || Auth::user()->rol_id == 2 || Auth::user()->rol_id == 3 )
              
                    <form action="" class="form">
                 <h1 class="fs-3 m-0"><b>Mi cuenta</b></h1>

                        <fieldset>
                 <legend>Informacion Personal</legend>
                    <div class="form__item">
                    <label for="employee_name" class="form__label ">Nombre</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('employee_name') is-invalid--border @enderror"
                            id="customer-name-addon"><i class="bi bi-person"></i></span>
                        <input type="text" name="employee_name" id="employee_name"
                            class="form-control " disabled placeholder="Ej: Juan"
                            aria-label="Nombre del cliente" value="{{ $employee->name }}">
                    </div>
                 </div>

                <div class="form__item">
                    <label for="employee_lastname" class="form__label ">Apellido</label>
                    <div class="input-group">
                        <span
                            class="form__icon input-group-text @error('employee_lastname') is-invalid--border @enderror"
                            id="customer-lastname-addon"><i class="bi bi-person"></i></span>
                        <input type="text" name="employee_lastname" id="employee_lastname"
                            class="form-control  " disabled
                            placeholder="Ej: Pérez" aria-label="Apellido del cliente" value="{{ $employee->lastname }}"> {{-- Assuming
                        $customer->lastname exists --}}
                    </div>
                 </div>

                <div class="form__item">
                    <label for="gender" class="form__label ">Género</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error ('gender_id') is-invalid--border @enderror"
                            id="gender-addon">
                            <i class="bi bi-gender-ambiguous"></i>
                        </span>
                        <select class="form-select @error('gender_id') is-invalid @enderror" name="gender_id"
                            id="gender" aria-label="Seleccione el género" disabled>
                            <option disabled selected>Seleccione una opción</option>
                            <option value="1" @if ($employee->gender_id == 1) selected @endif>Masculino</option>
                    <option value="2" @if ($employee->gender_id == 2) selected @endif>Femenino</option>
                        </select>
                    </div>
                     
                </div>

                <div class="form__item">
                    <label for="identity_card_id" class="form__label ">Tipo de identidad</label>
                    <div class="input-group">
                        <span
                            class="form__icon input-group-text @error('identity_card_id') is-invalid--border @enderror"
                            id="identity-type-addon"><i class="bi bi-card-heading"></i></span>
                        <select class="form-select @error('identity_card_id') is-invalid @enderror"
                            name="identity_card_id" id="identity_card_id"
                            aria-label="Seleccione el tipo de documento de identidad" disabled>
                            <option selected disabled>Seleccione una opción</option>
                              @foreach ($identity_cards as $value)
                        <option value="{{ $value->identity_card_id }}"
                            {{ $employee->identity_card_id == $value->identity_card_id ? 'selected' : '' }}> {{-- Corrected property access --}}
                            {{ $value->identity_card }}
                        </option>
                    @endforeach

                        </select>
                    </div>
                 </div>

                <div class="form__item">
                    <label for="card" class="form__label ">Número de identificación</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('card') is-invalid--border @enderror"
                            id="card-number-addon"><i class="bi bi-credit-card"></i></span>
                        <input type="text" name="card" id="card"
                            class="form-control @error('card') is-invalid @enderror" placeholder="Ej: 12345678" disabled
                            aria-label="Número de documento de identidad del cliente" value="{{ $employee->card }}">
                    </div>
                </div>
                <div class="form__item">
                    <label for="telephone_number" class="form__label">Número de Teléfono</label>
                    <div class="input-group ">
                        <span
                            class="form__icon input-group-text @error ('telephone_number') is-invalid--border @enderror"
                            id="basic-addon1">
                            <i class="bi bi-telephone"></i> </span>
                        <input type="text" name="telephone_number" id="telephone_number"
                            class="form-control @error ('telephone_number') is-invalid @enderror"
                            placeholder="Ej: 58+ 412-1234567" aria-label="Número de Teléfono" disabled
                            aria-describedby="basic-addon1" value="{{ $employee->telephone_number }}">
                    </div>
                    
                </div>
                <div class="form__item">
                    <label for="address" class="form__label">Dirección</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('address') is-invalid--border @enderror"
                            id="address-addon"><i class="bi bi-geo-alt"></i></span>
                        <textarea name="address" id="address" rows="3"
                            class="form-control "
                            placeholder="Ej: Calle 10, Casa #5, Sector La Lago."
                            disabled
                            aria-label="Dirección del cliente">{{$employee->address}}</textarea>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Informacion de Usuario</legend>
                <div class="form__item">
                    <label for="employee_user" class="form__label ">Nombre de Usuario</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('employee_user') is-invalid--border @enderror"
                            id="customer-name-addon"><i class="bi bi-person"></i></span>
                        <input type="text" name="employee_user" id="employee_user"
                            class="form-control @error('employee_user') is-invalid @enderror" placeholder="Ej: Juan2024"
                            aria-label="Nombre del cliente" value="{{ $employee->user->user }}" disabled>
                    </div>
                </div>

                <div class="form__item">
                    <label for="employee_email" class="form__label ">Correo electrónico</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text @error('employee_email') is-invalid--border @enderror"
                            id="customer-email-addon"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="employee_email" id="employee_email"
                            class="form-control @error('employee_email') is-invalid @enderror"
                            placeholder="Ej: juan.perez@example.com" aria-label="Correo electrónico del cliente"
                            value="{{ $employee->user->email }}" disabled>
                    </div>
                 </div>

                <div class="form__item">
                    <label for="role_id" class="form__label ">Rol de Acceso</label>
                    <div class="input-group">
                        <span
                            class="form__icon input-group-text @error('role_id') is-invalid--border @enderror"
                            id="identity-type-addon"><i class="bi bi-person-gear"></i></span>
                        <select class="form-select @error('role_id') is-invalid @enderror"
                            name="role_id" id="role_id" disabled
                            aria-label="Seleccione el tipo de documento de identidad">
                            <option selected >Seleccione una opción</option>
                              @foreach ($roles as $value)
                        <option value="{{ $value->rol_id }}"
                            {{ $employee->user->rol_id == $value->rol_id ? 'selected' : '' }}> {{-- Corrected property access --}}
                            {{ $value->name }}
                        </option>
                    @endforeach

                        </select>
                    </div>
                 </div>

                
            </fieldset>

                    </form>
                </section>
            @else
                   <h1 class="fs-3 m-0"><b>Mi cuenta</b></h1>
               
                      <p class="mb-2">
                    Gestiona tu información personal y de seguridad
                    </p>
                       
                    <form action="{{ route('configuration.update') }}" class="form m-0 form--update-account" method="post">
                        @csrf
                        @method('PUT')
                        @if (session('alert-success-update-data'))
                            <div class="alert alert-success">
                                {{ session('alert-success-update-data') }}
                            </div>
                        @endif
                        <legend class="form__title"><b>Datos de usuario</b></legend>
                        <span class="form__description">Actualiza tu nombre de usuario</span>
                        <div class="form__item">
                            <label for="" class="form__label form__label--required">Nombre de Usuario</label>
                            <div class="input-group ">
                                <span class="form__icon input-group-text  @error ('user') is-invalid--border @enderror"
                                    id="basic-addon1"><i class="bi bi-person-circle"></i></span>
                                <input type="search" name="user" class="form-control @error ('user') is-invalid @enderror "
                                    placeholder="Ej: Yane3" aria-label="Username" aria-describedby="basic-addon1" autofocus
                                    value="{{ auth::user()->user }}">
                            </div>
                            @error('user')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form__item">
                            <div class="form__button flex-full__justify-content-end ">
                                <button class="button button--color-blue" type="submit">
                                    Guardar cambios
                                </button>
                            </div>
                    </form>
                    <form action="{{ route('configuration.update-password') }}" class="form--update-password" method="post">
                        @csrf
                        @method('PUT')
                        @if (session('alert-success-update-password'))
                            <div class="alert alert-success">
                                {{ session('alert-success-update-password') }}
                            </div>
                        @endif
                        <legend class="form__title"><b>Seguridad</b></legend>

                        <span class="form__description">Cambia tu contraseña para mantener tu cuenta segura</span>

                        <div class="form__item">
                            <label for="" class="form__label form__label--required"> Nueva contraseña </label>
                            <div class="input-group ">
                                <span class="form__icon input-group-text @error ('password') is-invalid--border @enderror"
                                    id="basic-addon1"><i class="bi bi-key"></i></span>
                                <input type="password" name="password"
                                    class="form-control @error ('password') is-invalid @enderror"
                                    placeholder="Mínimo 8 caracteres" aria-label="Username" aria-describedby="basic-addon1"
                                    value="">
                            </div>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form__item">
                            <label for="" class="form__label form__label--required">Confirmar nueva contraseña </label>
                            <div class="input-group ">
                                <span
                                    class="form__icon input-group-text @error ('password_confirmation') is-invalid--border @enderror"
                                    id="basic-addon1"><i class="bi bi-key"></i></span>
                                <input type="password" name="password_confirmation"
                                    class="form-control @error ('password_confirmation') is-invalid @enderror "
                                    placeholder="Repite tu nueva contraseña" aria-label="Username"
                                    aria-describedby="basic-addon1" value="">
                            </div>
                            @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form__button flex-full__justify-content-end ">
                            <button class="button button--color-blue" type="submit">
                                Actualizar nueva contraseña
                            </button>
                        </div>
                    </form>
                </section>
            @endif

        </article>
    </main>
    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>