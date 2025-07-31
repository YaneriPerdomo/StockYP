<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ver Detalles
de la Venta  | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="stylesheet" href="../../../css/components/_input.css">
    <link rel="stylesheet" href="../../../css/components/_top-bar.css">
        <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">

    <link rel="stylesheet" href="../../../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

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


         .article--all-job {
        align-self: start;
    }

    .table__operations {
        display: flex !important;
        gap: 0.5rem;
    }
 
    </style>
</head>

<body class="h-100 d-flex flex-column">
     <x-header-admin relativePath='../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__justify-content-center">
        <article class="form w-100">
             <div class="button--back">
                <a href="" onclick="historyBack()">
                    <i class="bi bi-arrow-left-square text-grey"></i> <button class="button text-grey"
                        type="button">Volver historial de ventas general</button>
                </a>
                <script>
                    function historyBack(){
                        return history.back();
                    }
                </script>
            </div>
                
            <div class="flex-full__justify-content-between ">
                <h1 class="fs-3">
                    <b>Solicitud de Revisión de Venta: {{$sale->sale_code	}}</b>
                </h1>
                <span>
                    <b>
                        Tasa de cambio: {{ number_format($sale->exchange_rate_bs	, 2,',','.') }}bs
                    </b>
                </span>
            </div>
                <section>
                    <h2 class="fs-4">Comprobante de Pago</h2>
                     <div action=" " class="search-card flex-full__aligh-start" method="POST"
                style="justify-content: start;">
                <div class="form__item w-50 m-0">
                    <label for="supplier_id_search" class="form__label form__label--required">Vendedor(a)</label>
                    @if ($sale->user_id != null) 
                        @if ($sale->user->employee == []) 
                            @php
                                $vendedor = 'Administrador(a)';
                            @endphp
                        @else
                            @php
                                $vendedor;
                                $vendedor = $sale->user->employee->name . ' ' . $sale->user->employee->lastname . ' (' . $sale->user->user . ')';
                            @endphp
                        @endif
                    @else
                        @php $vendedor = "N/A"; @endphp
                    @endif 
                    <div class="input-group">
                        <span class="form__icon input-group-text"><i class="bi bi-person-badge"></i></span>
                        <input type="text" name="supplier_id_search" id="supplier_id_search" class="form-control"
                            placeholder="Ej: 31048726" aria-label="Número de identificación" 
                            value="{{ $vendedor }}" disabled>
                    </div>
                </div>
            </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="receipt_number" class="form__label">Número del Recibo</label>
                            <div class="input-group">
                                <span
                                    class="form__icon input-group-text @error ('product_id') is-invalid--border @enderror"
                                    id="basic-addon1">
                                    <i class="bi bi-receipt"></i>
                                </span>
                                <input type="text" name="receipt_number" id="receipt_number" class="form-control"
                                    placeholder="" aria-label="Número de Factura" value="{{ $sale->sale_code }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
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
                                        <option value="{{ $value['payment_type_id'] }}" 
                                        disabled
                                        @if ($value['payment_type_id'] == $sale->payment_type_id)
                                            selected
                                        @endif
                                        >{{$value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="expiration_date" class="form__label form__label--required">Fecha de
                                Vencimiento</label>
                            <div class="input-group">
                                <span class="form__icon input-group-text"><i class="bi bi-calendar"></i></span>
                                <input type="date" name="expiration_date" disabled id="expiration_date" class="form-control"
                                    placeholder="Ej: Llanta de repuesto" aria-label="Fecha de vencimiento" value="{{ $sale->expiration_date }}">
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
                            <textarea name="observations" id="observations" rows="3" disabled
                                class="form-control @error('observations') is-invalid @enderror"
                                placeholder="Breve descripción del comprobante..."
                                aria-label="Observaciones">{{ $sale->remarks ?? ''}}</textarea>
                        </div>
                    </div>
                </section>
           <div>

            <h2 class="fs-4">Información del cliente</h2>
            <div action="{{ route('register.search-card') }}" class="search-card flex-full__aligh-start" method="POST"
                style="justify-content: start;">
                <div class="form__item w-50 m-0">
                    <label for="supplier_id_search" class="form__label form__label--required">Número de
                        identificación</label>
                    <div class="input-group">
                        <span class="form__icon input-group-text"><i class="bi bi-person-badge"></i></span>
                        <input type="text" name="supplier_id_search" id="supplier_id_search" class="form-control"
                            placeholder="Ej: 31048726" aria-label="Número de identificación" value="{{ $sale->customer->card }}" disabled>
                    </div>
                </div>
            </div>

            <div id="register_sale">
                @csrf
                @method('POST')

                @if (session('alert-success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('alert-success') }}
                    </div>
                @endif

                <fieldset>
                    <input type="hidden" name="id_customer">
                    <div class="form__item row">
                        <div class="col-4">
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
                                        placeholder="..." aria-label="Nombre del cliente" value="{{ $sale->customer->name }}" disabled>
                                </div>
                                @error('client_name') <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
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
                                        placeholder="..." aria-label="Apellido del cliente" value="{{ $sale->customer->lastname }}" disabled>
                                </div>
                                @error('client_lastname') <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
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
                                        placeholder="..." aria-label="Número de teléfono del cliente" value="{{ $sale->customer->phone }}" disabled>
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
                                aria-label="Dirección del cliente">{{ $sale->customer->address }}</textarea>
                        </div>
                        @error('client_address') <div class="alert alert-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                </fieldset>
            </div>

            <section class="product">
                <h2 class="fs-4 p-0 m-0">Listado de Productos</h2> 
                <div action="" method="post" class="form__sale-register">
                    @csrf
                    @method('POST')
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
                                    </tr>
                                </thead>
                                <tbody class="table-insert">
                                    @foreach ($sale_details as $value )
                                    
                                     <tr class='show'>
                                    <td>
                                        <div class="input-group ">
                                            <span class="form__icon input-group-text" id="basic-addon1">
                                                <i class="bi bi-box"></i>
                                            </span>
                                            <input 
                                                type="hidden" 
                                                id="id" 
                                                 disabled
                                                value="{{ $value->sale_detail_id }}"
                                            >
                                            <input 
                                                type="text" 
                                                disabled 
                                                id = "selected-product"
                                                class="form-control"
                                                placeholder="Ej: 32" 
                                                aria-label="name" 
                                                aria-describedby="basic-addon1" 
                                                value="{{ $value->products->name }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="form__icon input-group-text" id = "basic-addon1">
                                            <i class="bi bi-hash"></i> 
                                        </span>
                                        <input 
                                            type="number" 
                                            disabled
                                            class="form-control" 
                                            placeholder="Ej: 1"
                                            value="{{ $value->quantity }}"
                                            aria-label="quantify"
                                            aria-describedby="basic-addon1"  >
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="input-group">
                                            <span class="form__icon input-group-text" id = "basic-addon1">
                                            <i class="bi bi-currency-dollar"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            disabled
                                            class="form-control" 
                                            placeholder="Ej: 1"
                                            value="@php echo number_format($value->unit_cost_dollars, 2, ',','.') @endphp"
                                            aria-label="quantify"
                                            aria-describedby="basic-addon1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="form__icon input-group-text" id = "basic-addon1">
                                            <i class="bi bi-percent"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                            disabled
                                            class="form-control" 
                                            placeholder="Ej: 1"
                                            value="{{ $value->discount ?? 0}}%"
                                            aria-label="quantify"
                                            aria-describedby="basic-addon1">
                                        </div>
                                    </td>      
                                    <td>
                                        <div class="input-group">
                                            <span class="form__icon input-group-text" id = "basic-addon1">
                                            <i class="bi bi-cash-coin"></i>
                                        </span>
                                        <input 
                                            type="text" 
                                           
                                            class="form-control" 
                                            placeholder="Ej: 1"
                                            value="@php
                                            echo number_format($value->subtotal_dollars, 2, ',','.')
                                            @endphp"
                                            aria-label="quantify"
                                            aria-describedby="basic-addon1">
                                        </div>
                                    </td>  
                                    <!-- <td>
                                         <div class="input-group">
                                <span
                                    class="form__icon input-group-text @error ('product_id') is-invalid--border @enderror"
                                    id="basic-addon1">
                                    <i class="bi bi-patch-check"></i>
                                </span>
                                 <select class="form-select" name="warranty_status_" id="warranty_status_1" aria-label="Seleccione el estado final de la garantía">
                                            <option value="" selected="" disabled="">Seleccione un estado</option>
                                            <option value="Reparado">
                                                Reparado
                                            </option>
                                            <option value="Cambiado">
                                                Cambiado
                                            </option>
                                            <option value="Pendiente de revisión">
                                                Pendiente de revisión
                                            </option>
                                            <option value="Rechazado">
                                                Rechazado
                                            </option>
                                        </select> 
                            </div>
                                    </td>--->
                                </tr>
                                    @endforeach
                                  
                                 
                           
                                </tbody>
                            </table>
                        </div>
                    </section>
                    <section class="flex-full__justify-content-center">
                        <div class="summary">
                            <span class="summary__title">RESUMEN</span>
                            <div class="summary__content">
                                <div class="summary__block summary__calculation">
                                    <span>BASE IMPONIBLE</span>
                                    <span>{{number_format($sale->tax_base, 2, ',','.')}}</span>
                                </div>
                                <div class="summary__block summary__calculation summary__calculation--iva">
                                    <span>IVA {{ $sale->VAT }}% </span>
                                    <span>{{number_format($sale->VAT_tax_dollars,2,',','.')}}</span>
                                </div>
                                <div class="summary__block summary__calculation summary__calculation--credit-rate"
                                    >
                                    <span>TASA DE INTERÉS {{$sale->credit_rate}}%</span>
                                    <span>{{number_format($sale->credit_tax_dollars, 2, ',','.') ?? 0}}</span>
                                </div>
                                <div class="summary__block summary__calculation">
                                    <span>TOTAL A PAGAR</span>
                                    <span>{{number_format($sale->total_price_dollars, 2, ',','.')}}</span>
                                </div>
                                <hr>
                                 <div class="summary__block summary__calculation">
                                    <span>AHORRO (%):</span>
                                    <span>{{number_format($sale->savings, 2, ',','.')}}</span>
                                </div>
                                <div class="summary__block summary__calculation">
                                    <span>TOTAL SOLO EN DIVISAS:</span>
                                    <span>{{number_format($sale->only_currencies, 2, '.',',')}}</span>
                                </div>
                                <span class="summary__block summary__msg">
                                    ¡**Oferta especial**! Paga en Dólares/Divisas por solo {{ number_format($sale->only_currencies, 2, '.',',') }} y ahorra {{number_format($sale->savings, 2, ',','.')}}%.**
                                    <br>
                                    <small>(Precio regular: $@php
                                        $precioRegular = $sale->total_price_dollars / $sale->exchange_rate_bs;
                                        echo number_format($precioRegular, 2, '.',',');
                                    @endphp)</small>
                                </span>
                                
                            </div>
                        </div>
                    </section>
                     <div class="flex-full__justify-content-center">
                        <div class="form-check form-switch ">
                            <input class="form-check-input" 
                                type="checkbox" 
                                disabled
                                role="switch" 
                                @if ($sale->paid_only_dollars == 1)
                                    checked 
                                @endif
                                id="switchCheckChecked"
                                name="switchCheckChecked">
                            
                        </div>
                        <label class="form-check-label" for="switchCheckChecked">
                                Oferta especial "En solo Divisas", pagado
                            </label>
                    </div>
                </div>
            </section>
        </article>

    </main>
    <x-footer></x-footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>