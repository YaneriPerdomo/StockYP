<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Productos | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/utilities.css">
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/layouts/_base.css">
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/components/_button.css">
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/components/_footer.css">
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/components/_form.css">
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/components/_table.css">
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/components/_header.css">
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/components/_search.css">
    <link rel="stylesheet" href="../{{ isset($inputSearch) ? '../' : ''}}css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>
<style>
    .article--all-job {
        align-self: start;
    }

    .table__operations {
        display: flex !important;
        gap: 0.5rem;
    }
</style>

<body class="h-100 d-flex flex-column">

    <x-header-admin relativePath='../' search="products"></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <article class="form w-100 ">
            <div class="flex-full__justify-content-between p-0">
                <div>
                    <legend class="mb-2"><b>Listado de Productos</b></legend>
                    <div class="search">
                        <div class="input-group  search__seeker">
                            <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                <i class="bi bi-search search__icon"></i>
                            </span>
                            <input type="text" name="product_name" id="product_name"
                                class="search__input search__input--text form-control"
                                placeholder="Ej: Llanta de repuesto" aria-label="Nombre del producto" autofocus
                                value="{{ isset($inputSearch) ? str_replace('-', ' ', $inputSearch) : '' }}">
                        </div>
                        <div class="search__action">
                            <button class="button search__button button--color-blue button--search" type="button">
                                Buscar Producto
                            </button>
                        </div>
                    </div>
                    <script>
                        let ItemButttonSearh = document.querySelector('.button--search');
                        let ItemFomSearch = document.querySelector('form');
                        let ItemInputNameProduct = document.querySelector('#product_name');
                        function slugify(text) {
                            const lowercase = text.toLowerCase();
                            const slug = lowercase.replace(/[^a-z0-9]+/g, '-');
                            const trimmedSlug = slug.replace(/^-+|-+$/g, '');
                            return trimmedSlug;
                        }
                        ItemButttonSearh.addEventListener('click', async e => {
                            e.preventDefault();
                            let inputValue = slugify(ItemInputNameProduct.value);
                            if (inputValue != "") {
                                return window.location.href = '../../productos/' + inputValue.trim() + '/buscar';
                            } else {
                                return window.location.href = '../../productos';
                            }
                        })
                    </script>
                </div>
                <div>
                    <a href="{{ route('product.create') }}" class="text-decoration-none text-white">
                        <button class="button button--color-black">
                            Registrar nuevo producto
                        </button>
                    </a>
                </div>
                @php

                    function generate_cost_sale($cost_price, $profit_margin, $discount = 0, $bs = 0)
                    {
                        // 1. Calcular el monto de ganancia en USD
                        $profit_amount_usd = $cost_price * ($profit_margin / 100);

                        // 2. Calcular el precio de venta inicial (costo + ganancia)
                        $initial_selling_price_usd = $cost_price + $profit_amount_usd;

                        // Inicializamos el precio final de venta con el precio inicial
                        $final_selling_price_usd = $initial_selling_price_usd;

                        // 3. Aplicar descuento si existe y es mayor a 0
                        if ($discount > 0) {
                            // Calcular el monto del descuento sobre el precio de venta inicial
                            $discount_amount_usd = $initial_selling_price_usd * ($discount / 100);

                            // Restar el descuento para obtener el precio final en USD
                            $final_selling_price_usd = $initial_selling_price_usd - $discount_amount_usd;
                        }

                        // 4. Formatear el precio final en USD
                        // Usamos str_replace para reemplazar la coma por punto si la configuración local lo requiere,
                        // o simplemente number_format si el resultado ya es con punto decimal para consistencia.
                        $final_selling_price_usd_formatted = number_format($final_selling_price_usd, 2, '.', ',');


                        // 5. Calcular el precio final en Bolívares (BS) si la tasa de cambio es válida
                        $final_selling_price_bs_calculated = 0;
                        if ($bs > 0) { // Asegurarse de que $bs sea un valor válido para evitar divisiones por cero o cálculos erróneos
                            $final_selling_price_bs_calculated = $final_selling_price_usd * $bs;
                        }

                        // 6. Formatear el precio final en Bolívares
                        $final_selling_price_bs_formatted = number_format($final_selling_price_bs_calculated, 2, ',', '.');

                        // 7. Retornar los precios formateados
                        return 'USD: ' . $final_selling_price_usd_formatted .
                            '<br> BS: ' . $final_selling_price_bs_formatted;
                    }

                @endphp
            </div>
            <div class="">
                @if (session('alert-success'))
                    <div class="alert alert-success">
                        {{ session('alert-success') }}
                    </div>
                @endif
                <section class='table'>
                    <table class='dataTable'>
                        <thead>
                            <tr>
                                <td>Proveedor</td>
                                <th>Código de Producto (SKU)</th>
                                <th>Nombre del producto</th>
                                <th>Categoria</th>
                                <th>Marca</th>
                                <th>Precio de Costo ($) </th>
                                <th> Margen de Ganancia (%) </th>
                                <th> Descuento </th>
                                <td>Precio de Venta</td>


                                <th>Descripcion</th>
                                <th>Estado</th>
                                @if (Auth::user()->rol_id == 1)
                                    <th>
                                        Última modificación por
                                    </th>
                                @endif
                                <td>
                                    Fecha de Registro
                                </td>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->items() == [])
                                @if (isset($inputSearch))
                                    <br>
                                    <p>No hay productos registrados que coincidan con tu búsqueda.</p>
                                    <ul>
                                        <li>Revisa la ortografía de la palabra.</li>
                                        <li>Utiliza palabras más genéricas o menos palabras.</li>
                                    </ul>
                                @else
                                    <br>
                                    <p>No hay productos registrados por los momentos.</p>
                                @endif

                            @else
                                @foreach ($products->items() as $value)
                                    <tr class='show'>
                                        <td>{{ $value->supplier->name ?? " N/A "}}</td>
                                        <td>{{ $value->code }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->category->name ?? "No hay ninguna categoria asociada" }}</td>
                                        <td>{{ $value->brand->name ?? "No hay ninguna marca asociada"}}</td>
                                        <td>{{ number_format($value->price_dollar, 2, '.', ',') }}</td>
                                        <td>{{$value->sale_profit_percentage}}%</td>
                                        <td>
                                            {{ $value->discount_only_dollar ?? 0}}%
                                        </td>
                                        <td>
                                            @php
                                                echo generate_cost_sale(
                                                    $value->price_dollar,
                                                    $value->sale_profit_percentage,
                                                    $value->discount_only_dollar,
                                                    $bs->in_bs
                                                );
                                            @endphp
                                        </td>
                                        <td>
                                            {{ $value->description }}
                                        </td>
                                        <td>
                                            {{ $value->state }}
                                        </td>
                                        @if (Auth::user()->rol_id == 1)
                                            <td>
                                                @if ($value->user_id != null)
                                                    @if ($value->user->employee == [])
                                                        {{ 'Administrador(a)' }}
                                                    @else
                                                        @php
                                                            if (str_contains($value->user->rol->name, ')')) {
                                                                echo $value->user->employee->name . ' ' . $value->user->employee->lastname . ' ' . $value->user->rol->name . '';
                                                            } else {
                                                                echo $value->user->employee->name . ' ' . $value->user->employee->lastname . ' (' . $value->user->rol->name . ')';
                                                            }
                                                        @endphp
                                                        <details>
                                                            <summary>Nombre de usuario</summary>
                                                            <p>{{$value->user->user}}</p>
                                                        </details>
                                                    @endif
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            @php
                                                if ($value->created_at != null) {
                                                    $created_at = substr($value->created_at, 0, 10);

                                                    $completion_date = explode('-', $created_at);

                                                    $writtenEveryMonth = array(
                                                        '01' => 'Enero',
                                                        '02' => 'Febrero',
                                                        '03' => 'Marzo',
                                                        '04' => 'Abril',
                                                        '05' => 'Mayo',
                                                        '06' => 'Junio',
                                                        '07' => 'Julio',
                                                        '08' => 'Agosto',
                                                        '09' => 'Septiembre',
                                                        '10' => 'Octubre',
                                                        '11' => 'Noviembre',
                                                        '12' => 'Diciembre'
                                                    );

                                                    $monthWritten = $writtenEveryMonth[$completion_date[1]];

                                                    echo $completion_date[2] . ' de ' . $monthWritten . ' de ' . $completion_date[0];


                                                }

                                            @endphp
                                        </td>
                                        <td class='table__operations'>
                                            <a href="{{ route('product.delete', $value->slug)}}">
                                                <button type="button" class="button button--color-red ">
                                                    <i class='bi bi-trash''></i>
                                                                                                                                                </button>
                                                                                                                                            </a>
                                                                                                                                            <a href="{{ route('product.edit', $value->slug)}}">
                                                                                                                                                <button class="button button--color-orange">
                                                                                                                                                    <i class="bi bi-pencil-square"></i>
                                                                                                                                                </button>
                                                                                                                                            </a>
                                                                                                                                        </td>
                                                                                                                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </section>
                <div>
                </div>
                <div class="flex-full__justify-content-between">
                    <div>
                        <p>
                            Mostrando {{ $products->count() == 1 ? 'registro' : 'registros' }} 1 -
                            {{ $products->count() }}
                            de un total de {{ $products->total() }}
                        </p>
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </article>
    </main>


    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>