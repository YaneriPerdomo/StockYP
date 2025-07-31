<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicia sesión | <x-systen-name></x-systen-name></title>
    <link rel="icon" type="image/x-icon" href="./img/icono.ico">
    <link rel="stylesheet" href="./css/layouts/_base.css">
    <link rel="stylesheet" href="./css/components/_form.css">
    <link rel="stylesheet" href="./css/pages/_login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>
    <div class="logo text-decoration-none text-white fs-4">
        StockYP
    </div>

    <main class="flex-all-center">
        <form action="{{ route('attemptLogin') }}" class="form form--login" method="post">
            @csrf
            <legend class="form__title text-center text-color-black">
                <h1>
                    <strong>
                        Inicia sesión
                    </strong>
                </h1>
            </legend>
            @error ('message_incorrect_credentials')
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @enderror

            <div class="form__item">
                <label for="" class="form__label form__label--required">Nombre de Usuario</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text" id="basic-addon1">
                        <i class="bi bi-person-circle"></i>
                    </span>
                    <input type="search" name="user" class="form-control " placeholder="Ej: Admin" aria-label="Username"
                        aria-describedby="basic-addon1" autofocus value="{{ old('user') }}">
                </div>
                @error('user')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form__item">
                <label for="" class="form__label form__label--required">Contraseña</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
                    <input type="password" name="password" class="form-control " placeholder="*******"
                        aria-label="Username" aria-describedby="basic-addon1" value="">
                </div>
                @error('password')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <br>
            <div class="form__button w-100">
                <button class="button w-100 button--bg-blue fs-5" type="submit">
                    Entrar
                </button>
            </div>
        </form>
    </main 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</body>

</html>