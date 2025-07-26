<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial de Ventas General | Sistema Web DJ</title>
    <link rel="stylesheet" href="../../../../../css/utilities.css">
    <link rel="stylesheet" href="../css/layouts/_base.css">
    <link rel="stylesheet" href="../css/components/_button.css">
    <link rel="stylesheet" href="../css/components/_footer.css">
    <link rel="stylesheet" href="../css/components/_form.css">
    <link rel="stylesheet" href="../../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../../css/components/_header.css">
    <link rel="stylesheet" href="../css/components/_search.css">
    <link rel="stylesheet" href="../css/components/_multiple-steps.css">

    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">
     <x-header-admin relativePath='../../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <article class="form w-adjustable  ">
            <div class="flex-full__justify-content-between p-0">
                <div>
                    <legend class="mb-2"><b>Historial de Ventas General</b></legend>
                    <div class="search">
                        <div>
                            <label for="">Fecha Inicial</label>
                            <div class="input-group  search__seeker">
                                <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                    <i class="bi bi-calendar search__icon"></i>
                                </span>
                                <input type="date" name="product_name" id="product_name"
                                    class="search__input search__input--date form-control" placeholder=""
                                    aria-label="Nombre del producto" autofocus value="">
                            </div>
                        </div>
                        <div>
                            <label for="">Fecha Final</label>
                            <div class="input-group  search__seeker">
                                <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                    <i class="bi bi-calendar search__icon"></i>
                                </span>
                                <input type="date" name="product_name" id="product_name"
                                    class="search__input search__input--date form-control" placeholder=""
                                    aria-label="Nombre del producto" autofocus value="">
                            </div>
                        </div>
                        <div>
                            <label for="">Cliente</label>
                            <div class="input-group  search__seeker">
                                <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                    <i class="bi bi-person-badge"></i>

                                </span>
                                <input type="number" name="product_name" id="product_name"
                                    class="search__input search__input--text form-control" placeholder=""
                                    aria-label="Nombre del producto" autofocus value="">
                            </div>
                        </div>

                        <div class="search__action search__action--content-items ">
                            <button class="button search__button button--color-blue button--search" type="button">
                                <i class="bi bi-search search__icon"></i>
                                Buscar Venta
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
                                <td>Codigo de Venta</td>
                                <th>Fecha de la Venta</th>
                                <th>Cliente</th>
                                <th>Total de la venta <br> en divisas </th>
                                <td>Metodo de Pago</td>
                                <th>Estado de la venta</th>
                                <th>Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($sales->items() == [])
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
                                @foreach ($sales->items() as $value)
                                    <tr class='show'>
                                        <td>{{ $value->sale->sale_code ?? "No hay ningun proveedor asociado"}}</td>
                                        <td>{{ substr($value->sale->created_at, 0, 10) }}</td>
                                        <td>{{ $value->sale->customer->name }} {{$value->sale->customer->lastname}}</td>
                                        <td>{{number_format($value->sale->total_price_dollars, 2, ',', '.') . '$' ?? "No hay ninguna categoria asociada" }}
                                        </td>
                                        <td>{{$value->sale->paymentType->name}}</td>
                                        <td>{{$value->sale->status}}</td>
                                        <td class='table__operations'>
                                            <a href="{{ route('sale.see-details', $value->sale->slug ?? 0) }}">
                                                <button class="button button--color-black">
                                                    <i class="bi bi-journals"></i>
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
                            Mostrando {{ $sales->count() == 1 ? 'registro' : 'registros' }} 1 -
                            {{ $sales->count() }}
                            de un total de {{ $sales->total() }}
                        </p>
                    </div>
                    <div>
                        {{ $sales->links() }}
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