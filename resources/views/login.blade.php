<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicia sesión | <x-systen-name></x-systen-name></title>
    <link rel="icon" type="image/x-icon" href="./img/icono.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>
<style>
    .height-full {
        height: 100%;
    }


    .alert {
        margin: 0;
    }

    :root {
        --color-blue: rgb(98, 113, 224);
        --color-black: rgb(47, 47, 47);
    }

    body {
        display: flex;
        flex-direction: column;
        height: 100%;
        position: relative;
        background-image: linear-gradient(0deg, var(--color-black) 0% 50%,
                var(--color-blue) 50% 100%);
    }

    .form {
        padding: 2rem;
        border-radius: 1rem;
        border: solid 1px #e8d8ff;
        margin: 0.5rem;
        background: white;
    }

    .form--login {
        width: clamp(300px, 30%, 400px);
    }

    .flex-all-center {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .button {
        color: white;
        padding 0.3rem 1rem;
        border: 0rem;
        padding: 0.5rem;
        border-radius: 1rem;
    }

    .text-color-blue {
        color: var(--color-blue);
    }

    .button--bg-blue {
        background: var(--color-blue);
    }

    .logo {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
    }

    .form__item {
        margin-bottom: 0.6rem;
    }
</style>

<body>
    <div class="logo text-decoration-none text-white fs-4">
        StockYP
    </div>

    <main class="flex-all-center h-100">
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
                <label for="" class="form__label">Usuario</label>
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
                <label for="" class="form__label">Contraseña</label>
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
    </main <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</body>

</html>