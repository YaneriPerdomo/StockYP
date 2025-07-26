<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado de Productos y Stock | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/utilities.css">
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/layouts/_base.css">
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/components/_button.css">
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/components/_footer.css">
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/components/_form.css">
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/components/_table.css">
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/components/_header.css">
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/components/_search.css">
        <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../{{ isset($productSearch) ? '../' : ''}}css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
     <x-header-admin relativePath='../' search="allStock"></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <article class="form w-adjustable  ">
            <div class="flex-full__justify-content-between p-0">
                <div>
                    <legend class="mb-2"><b>Listado de Productos y Stock</b></legend>
                    <div class="search">
                        <div class="input-group  search__seeker">
                            <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                <i class="bi bi-search search__icon"></i>
                            </span>
                            <input type="text" name="product_name" id="product_name"
                                class="search__input search__input--text form-control"
                                placeholder="Ej: Llanta de repuesto" aria-label="Nombre del producto" autofocus
                                value="{{ isset($productSearch) ? str_replace('-', ' ', $productSearch) : '' }}">
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
                                return window.location.href = '../../todos-los-productos-y-stock/' + inputValue.trim() + '/buscar';
                            } else {
                                return window.location.href = '../../todos-los-productos-y-stock';
                            }
                        })
                    </script>
                </div>

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
                                <th>Código de Producto (SKU)</th>
                                <th>Nombre del producto</th>
                                <th> Precio en Venta </th>
                                <th> Ubicación del producto </th>
                                <th> Stock actual </th>

                               
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->items() == [])
                                @if (isset($productSearch))
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
                                        <td>{{ $value->code }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>
                                            @php
                                                $value->price_dollar;
                                                $value->sale_profit_percentage;
                                                $porcentaje_ganancia_decimal = $value->sale_profit_percentage / 100;


                                                $monto_ganancia_dolares = $value->price_dollar * $porcentaje_ganancia_decimal;


                                                $precio_venta_inicial = $value->price_dollar + $monto_ganancia_dolares;


                                                if ($value->discount_only_dollar) {


                                                    $porcentaje_descuento_decimal = $value->discount_only_dollar / 100;

                                                    $monto_descuento_dolares = $precio_venta_inicial * $porcentaje_descuento_decimal;

                                                    $precio_final_dolares_calculado = $precio_venta_inicial - $monto_descuento_dolares;

                                                    $precio_final_dolares_formateado = number_format($precio_final_dolares_calculado, 2, ',', '.');

                                                    $precio_final_bolivares_calculado = $precio_final_dolares_calculado * $bs->in_bs;
                                                    $precio_final_bolivares_formateado = number_format($precio_final_bolivares_calculado, 2, ',', '.');


                                                    echo 'USD ' . $precio_final_dolares_formateado .
                                                        ' <br> BS: ' . $precio_final_bolivares_formateado;

                                                } else {
                                                    // Si no hay un porcentaje de descuento específico

                                                    // --- Formateo para la visualización en USD (el precio de venta inicial) ---
                                                    $precio_venta_dolares_formateado = number_format($precio_venta_inicial, 2, ',', '.');

                                                    // --- Cálculo y Formateo para la visualización en Bolívares (BS) ---
                                                    // Multiplicamos el precio de venta inicial (numérico) por la tasa de cambio
                                                    $precio_venta_bolivares_calculado = $precio_venta_inicial * $bs->in_bs;
                                                    $precio_venta_bolivares_formateado = number_format($precio_venta_bolivares_calculado, 2, ',', '.');

                                                    // Muestra los precios en USD y BS sin descuento
                                                    echo 'USD: ' . $precio_venta_dolares_formateado .
                                                        ' <br> BS: ' . $precio_venta_bolivares_formateado;
                                                }


                                            @endphp
                                        </td>
                                        <td>{{ $value->location->name ?? 'No hay ninguna ubicación asociada'}}</td>
                                        <td>
                                            {{ $value->stock_available }}
                                        </td>
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