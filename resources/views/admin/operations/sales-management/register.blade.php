<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Nueva Venta | <x-systen-name></x-systen-name></title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_radio-input-selection.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/pages/_register-sale.css">
    <link rel="stylesheet" href="../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="stylesheet" href="../../../css/components/_input.css">
    <link rel="stylesheet" href="../../../css/components/_top-bar.css">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <meta name="csrf-token" content="{{ csrf_token() }}">
   
    <style>
        .product__total-sale {
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--color-black);
            padding: 0.7rem;
            color: white;
            border-radius: 2rem;
        }

        .summary {}

        .summary__title {
            background-color: var(--color-black);
            display: block;
            padding: 0.5rem 1rem;
            color: white;
        }

        .summary__content {
            padding: 0.5rem 1rem;

        }

        .summary {
            filter: drop-shadow(2px 2px 3px rgb(200, 200, 200));
            background-color: white;
            border: solid 1px var(--color-black);
            margin: 0.5rem;
        }

        .summary__block {
            display: flex;
            gap: 1rem;
            justify-content: space-between;
        }
    </style>
</head>

<body class=" d-flex flex-column">
    
    <x-header-admin relativePath='../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__justify-content-center">
        <article class="form w-100">
            <div>
                @csrf
                <input type="hidden" name="id_customer">

            </div>

            <div class="flex-full__justify-content-between ">
                <h1 class="fs-3">
                    <b>Registrar Nueva Venta</b>
                </h1>
                <span class="exchange-rate-bs">
                    <b>
                        Tasa de cambio: {{ number_format($bs->in_bs, 2,',','.') }}bs
                    </b>
                </span>
            </div>

            @if (session('alert-success-sale'))
                <div class="alert alert-success" role="alert">
                    {{ session('alert-success-sale') }}
                </div>
            @endif
            @if (session('alert-danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('alert-danger') }}
                </div>
            @endif


            <div class="d-flex justify-content-center align-items-center gap-3 mb-4 radio-input-selection">
                <label for="option-1" class="form-check-label radio-input-selection__one">
                    <input type="radio" name="generate_invoice" id="option-1" value="0" checked
                        class="form-check-input">
                    <span>Generar Venta y Descargar comprobante</span>
                </label>

                <label for="option-2" class="form-check-label radio-input-selection__two">
                    <input type="radio" name="generate_invoice" id="option-2" value="1" class="form-check-input">
                    <span>Solo Generar Venta</span>
                </label>
            </div>

            <script>
                let generate_invoice = document.querySelectorAll('[name="generate_invoice"]');

                document.addEventListener('click', e => {
                    if (e.target.matches('[name="generate_invoice"]')) {
                        generate_invoice.forEach(element => {
                            element.removeAttribute('checkbox');
                        });
                        generate_invoice.forEach(element => {
                            if (element.value === e.target.value) {
                                element.setAttribute('checkbox', true);
                            }
                        });
                        console.info(e.target.value)
                    }
                })
            </script>
            <form id="register_sale">
                <section>
                    <h2 class="fs-4">Comprobante de Pago</h2>
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <label for="receipt_number" class="form__label">Número de Venta</label>
                            <div class="input-group">
                                <span
                                    class="form__icon input-group-text @error ('product_id') is-invalid--border @enderror"
                                    id="basic-addon1">
                                    <i class="bi bi-receipt"></i>
                                </span>
                                <input type="text" name="receipt_number" id="receipt_number" class="form-control"
                                    placeholder="" aria-label="Número de Factura" value="" disabled>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <label for="payment-method" class="form__label form__label--required">Método de Pago</label>
                            <div class="input-group">
                                <span
                                    class="form__icon input-group-text @error ('product_id') is-invalid--border @enderror"
                                    id="basic-addon1">
                                    <i class="bi bi-cash-coin"></i>
                                </span>
                                <select class="form-select" name="payment-method" id="payment-method"
                                    aria-label="Seleccione el método de pago">
                                    <option value="" selected disabled>Seleccione una opción de pago</option>
                                    @foreach ($payment_types as $value)
                                        <option value="{{ $value['payment_type_id'] }}">{{$value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <label for="expiration_date" class="form__label form__label--required">Fecha de
                                Vencimiento</label>
                            <div class="input-group">
                                <span class="form__icon input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" name="expiration_date" id="expiration_date" class="form-control"
                                    placeholder="Ej: Llanta de repuesto" aria-label="Fecha de vencimiento" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form__item">
                        <label for="observations" class="form__label">Observaciones</label>
                        <div class="input-group">
                            <span
                                class="form__icon input-group-text @error('observations') is-invalid--border @enderror"
                                id="observations-addon">
                                <i class="bi bi-chat-dots"></i>
                            </span>
                            <textarea name="observations" id="observations" rows="3"
                                class="form-control @error('observations') is-invalid @enderror"
                                placeholder="Breve descripción del comprobante..."
                                aria-label="Observaciones">{{ old('observations') }}</textarea>
                        </div>
                    </div>
                </section>
            </form>

            <h2 class="fs-4">Información del cliente</h2>
            <form action="{{ route('register.search-card') }}" class="customer-search-form flex-full__aligh-start"
                method="POST" style="justify-content: start;">
                <div class="customer-search-form__field w-r-50 m-0">
                    <label for="customer-search_for"
                        class="customer-search-form__label customer-search-form__label--required">Número de
                        identificación</label>
                    <div class="input-group">
                        <span class="customer-search-form__icon input-group-text"><i
                                class="bi bi-person-badge"></i></span>
                        <input type="text" name="card_customer" id="customer-search_for" class="form-control"
                            placeholder="Ej: 31048726" aria-label="Número de identificación" value="">
                    </div>
                </div>
                <div class="customer-search-form__actions align-self-end">
                    <button class="button button--color-orange" type="submit">
                        Buscar cliente
                    </button>
                </div>
            </form>

            <form id="register_sale">
                @csrf
                @method('POST')
                <div class="register-client text-red" style="display:none">
                    <p class="p-0 m-0" role="alert">
                        Cliente no encontrado. Por favor, regístralo.
                        <a href="{{ route('customer.create') }}" class="text-blue">Aquí</a>
                    </p>
                </div>

                @if (session('alert-success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('alert-success') }}
                    </div>
                @endif

                <fieldset>
                    <input type="hidden" name="id_customer">
                    <div class="form__item row">
                        <div class="col-lg-4 col-12">
                            <div class="form__item">
                                <label for="client_name" class="form__label">Nombre</label>
                                <div class="input-group">
                                    <span
                                        class="form__icon input-group-text @error('client_name') is-invalid--border @enderror"
                                        id="category-addon">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="client_name" id="client_name"
                                        class="form-control @error('client_name') is-invalid @enderror"
                                        placeholder="..." aria-label="Nombre del cliente" value="" disabled>
                                </div>
                                @error('client_name') <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form__item">
                                <label for="client_lastname" class="form__label">Apellido</label>
                                <div class="input-group">
                                    <span
                                        class="form__icon input-group-text @error('client_lastname') is-invalid--border @enderror"
                                        id="category-addon">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text" name="client_lastname" id="client_lastname"
                                        class="form-control @error('client_lastname') is-invalid @enderror"
                                        placeholder="..." aria-label="Apellido del cliente" value="" disabled>
                                </div>
                                @error('client_lastname') <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form__item">
                                <label for="client_phone" class="form__label">Número de Teléfono</label>
                                <div class="input-group">
                                    <span
                                        class="form__icon input-group-text @error('client_phone') is-invalid--border @enderror"
                                        id="category-addon">
                                        <i class="bi bi-phone"></i>
                                    </span>
                                    <input type="text" name="client_phone" id="client_phone"
                                        class="form-control @error('client_phone') is-invalid @enderror"
                                        placeholder="..." aria-label="Número de teléfono del cliente" value="" disabled>
                                </div>
                                @error('client_phone') <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form__item">
                        <label for="client_address" class="form__label">Dirección</label>
                        <div class="input-group">
                            <span
                                class="form__icon input-group-text @error('client_address') is-invalid--border @enderror"
                                id="description-addon">
                                <i class="bi bi-house"></i>
                            </span>
                            <textarea name="client_address" id="client_address" rows="3" disabled
                                class="form-control @error('client_address') is-invalid @enderror" placeholder="..."
                                aria-label="Dirección del cliente"></textarea>
                        </div>
                        @error('client_address') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                </fieldset>
            </form>

            <section class="product">
                <h2 class="fs-4">Listado de Productos</h2>
                <div class="product__total-sale" style="display:none;">
                    <span>
                        <i>USD: 0</i>
                        <i>BS: 0</i>
                    </span>
                </div>

                <form action="{{ route('register.search-product') }}" class="products-search-form product-selection"
                    method="post">
                    <div class="products-search-form__content products-search__content-show ">
                        <label for="products-search-form__name-for" class="form__label form__label--required">
                            Buscador del producto
                        </label>
                        <div class="input-group">
                            <span class=" input-group-text">
                                <i class="bi bi-search products-search-form__icon"></i></span>
                            <input type="text" name="products-search__name" id="products-search__name-form"
                                class="form-control name-product" placeholder="Ej: Llanta de repuesto"
                                aria-label="Nombre del producto">
                        </div>
                        <div class="products-search-form__mgs message-registration-found message-registration-found--product text-red"
                            style="display:none" role="alert">
                            <p class="p-0 m-0">
                                <b>Productos no encontrados para la venta.</b> Por favor, <i><b>sea más descriptivo</b></i> del
                                producto deseado.
                            </p>
                        </div>
                    </div>
                    <div class="products-search-form__content products-search__content-show">
                        <label for="products-search-form__show-for " class="form__label ">Productos a vender</label>
                        <div class="input-group">
                            <span
                                class="form__icon input-group-text @error ('show-available_sale') is-invalid--border @enderror"
                                id="basic-addon1">
                                <i class="bi bi-box-seam products-search-form__icon"></i>
                            </span>
                            <select class="form-select products-search-form__show" name="display-products-sale"
                                id="products-search-form__show-for" style="padding: 0.5rem;"
                                aria-label="Seleccione el producto" data-bs="{{ $bs->in_bs }}">
                            </select>
                        </div>
                    </div>
                </form>

                <form action="{{ route('register.store') }}" method="post" class="form__sale-register">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="base_imponible">
                    <input type="hidden" name="iva">
                    <input type="hidden" name="iva_actual">
                    <input type="hidden" name="tasa_credito">
                    <input type="hidden" name="total_a_pagar">
                    <input type="hidden" name="bs">
                    <input type="hidden" name="cliente_id">
                    <input type="hidden" name="numero_comprobante">
                    <input type="hidden" name="metodo_pago">
                    <input type="hidden" name="fecha_vencimiento">
                    <input type="hidden" name="observaciones">
                    <input type="hidden" name="generar_comprobante_pdf" value="Generar Venta y Descargar comprobante">
                    <input type="hidden" name="tasa_credito_actual">
                    <section class='table' data-count='0'>
                        <div class="table-responsive">
                            <table class='dataTable'>
                                <thead>
                                    <tr>
                                        <th>Descripción del producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario <br> Divisas</th>
                                        <th>Descuento</th>
                                        <th>Total Neto <br>Divisas</th>
                                        <th>Operación</th>
                                    </tr>
                                </thead>
                                <tbody class="table-insert">
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <section class="flex-full__justify-content-center">
                        <div class="summary">
                            <span class="summary__title">RESUMEN</span>
                            <div class="summary__content">
                                <div class="summary__block summary__calculation">
                                    <span>BASE IMPONIBLE: </span>
                                    <span>0,00</span>
                                </div>
                                <div class="summary__block summary__calculation summary__calculation--iva"
                                    data-iva="{{ number_format($iva->iva / 100, 2)}}">
                                    <span>IVA: ({{ $iva->iva }}%)</span>
                                    <span>0,00</span>
                                </div>
                                <div class="summary__block summary__calculation summary__calculation--credit-rate"
                                    data-credit-rate="{{  number_format($credit_rate->value / 100, 2) }}">
                                    <span>TASA DE INTERÉS DEL CRÉDITO: ({{ $credit_rate->value }}%)</span>
                                    <span>0,00</span>
                                </div>
                                <div class="summary__block summary__calculation">
                                    <span>TOTAL A PAGAR:</span>
                                    <span>0,00</span>
                                </div>
                                <div class="summary__block summary__calculation">
                                    <span>TOTAL A PAGAR USD:</span>
                                    <span>0</span>
                                </div>
                                <hr>
                                <div class="summary__block summary__calculation">
                                    <span>DESCUENTO SOLO EN DIVISAS:</span>
                                    <span>0</span>
                                </div>
                                <div class="summary__block summary__calculation">
                                    <span>TOTAL SOLO EN DIVISAS:</span>
                                    <span>0</span>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="flex-full__justify-content-center">
                        <div class="form-check form-switch ">
                            <input class="form-check-input" type="checkbox" role="switch" id="switchCheckChecked"
                                name="switchCheckChecked">
                            <label class="form-check-label" for="switchCheckChecked">
                                Descuento "En Divisas" pagado
                            </label>
                        </div>

                    </div>

                    <div class="form__button w-100 my-3">
                        <button class="button button--color-blue w-100" type="submit">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </section>
        </article>

    </main>
    <x-footer></x-footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

<script src="../../../js/layouts/register_sale.js" type="module"> </script>


</html>