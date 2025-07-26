<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Historial de Ventas General | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/utilities.css">
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/layouts/_base.css">
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/components/_button.css">
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/components/_footer.css">
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/components/_form.css">
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/components/_table.css">
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/components/_header.css">
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/components/_search.css">
    <link rel="icon" type="image/x-icon" href="../{{$dateRange == true ? '../../../' : ''}}img/icono.ico">
    <link rel="stylesheet" href="../{{$dateRange == true ? '../../../' : ''}}css/components/_selection-operations.css">
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

    .search__action--content-items {
        align-self: end;
    }
</style>

<body class="h-100 d-flex flex-column">
    
    <x-header-admin relativePath='../../../../' search='{{ $search }}'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <article class="form w-100 ">
            <div class="flex-full__justify-content-between p-0">
                <legend class="mb-2"><b>Historial de Ventas General</b></legend>
                <div class="search">
                    <div>
                        <label for="">Fecha Inicial</label>
                        <div class="input-group  search__seeker">
                            <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                <i class="bi bi-calendar search__icon"></i>
                            </span>
                            <input type="date" name="start_date" id="start_date"
                                class="search__input search__input--date form-control" placeholder=""
                                aria-label="Nombre del producto" value="{{ $startDate ?? ''}}">
                        </div>
                        @error('start_date')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label for="">Fecha Final</label>
                        <div class="input-group  search__seeker">
                            <span class="search__icon-wrapper input-group-text" id="product-name-addon">
                                <i class="bi bi-calendar search__icon"></i>
                            </span>
                            <input type="date" name="end_date" id="end_date"
                                class="search__input search__input--date form-control" placeholder=""
                                aria-label="Nombre del producto" value="{{ $endDate ?? ''}}">
                        </div>
                    </div>
                    @error('end_date')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="search__action " style="  align-self: end;">
                        <button class="button search__button button--color-blue button--search" type="button">
                            <i class="bi bi-search search__icon"></i>
                            Buscar Venta
                        </button>
                    </div>
                </div>
                <script>
                    let ItemButttonSearh = document.querySelector('.button--search');
                    let ItemFomSearch = document.querySelector('form');
                    let ItemInputStartDate = document.querySelector('#start_date');
                    let ItemInputEndDate = document.querySelector('#end_date');

                    function slugify(text) {
                        const lowercase = text.toLowerCase();
                        const slug = lowercase.replace(/[^a-z0-9]+/g, '-');
                        const trimmedSlug = slug.replace(/^-+|-+$/g, '');
                        return trimmedSlug;
                    }
                    ItemButttonSearh.addEventListener('click', async e => {
                        e.preventDefault();
                        let inputValueEndDate = slugify(ItemInputEndDate.value);
                        let inputValueStartDate = slugify(ItemInputStartDate.value);

                        if (inputValueEndDate != "" && inputValueStartDate != "") {

                            return window.location.href = '../../../../historial-de-ventas-general/del/' + inputValueStartDate.trim() + '-al/' + inputValueEndDate.trim() + '/buscar';
                        } else {
                            return window.location.href = '../../../../historial-de-ventas-general';
                        }
                    })
                </script>
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
                                <td>Vendedor(a)</td>
                                <th>Total de la venta <br> en bs </th>
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
                                        <td>{{ $value->sale_code ?? "No hay ningun proveedor asociado"}}</td>
                                        <td> @php
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



                                        @endphp</td>
                                        <td>{{ $value->customer->name }} {{$value->customer->lastname}}</td>
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
                                        <td>{{number_format($value->total_price_dollars, 2, ',', '.') ?? "N/A" }}
                                        </td>
                                        <td>{{$value->paymentType->name}}</td>
                                        <td>{{$value->status}}</td>
                                        <td class='table__operations'>
                                            <a href="{{ route('sale.see-details', $value->slug ?? 0) }}">
                                                <button class="button button--color-orange">
                                                    <i class="bi bi-journals"></i>
                                                </button>
                                            </a>

                                            <form action="{{ route('sale.pdf', $value->sale_id ?? 0) }}" method="post">
                                                @csrf
                                                @method('POST')
                                                <button class="button button--color-grey">
                                                    <i class="bi bi-filetype-pdf"></i>
                                                </button>
                                            </form>

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