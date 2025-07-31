<head>
    <style>
        .dataTable th {
            text-align: left;
            background: rgb(97, 112, 223) !important;
            border-bottom: 1px dashed #aaa;
        }

        thead>tr {
            background: rgb(97, 112, 223) !important;
            color: white;
        }

        .dataTable tr:nth-child(odd) {
            background: rgba(0, 0, 0, 0.07);
        }

        .dataTable td,
        .dataTable th {
            padding: 0.625em;
            line-height: 1.5em;
            border-bottom: 1px dashed #ccc;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border-color: inherit;
            border-style: solid;
            border-width: 0;
        }

        .flex-full__justify-content-between {
            display: flex;
            width: 100%;
            justify-content: space-between;

            padding: 10px;

        }

        :root {
            --color-blue: rgb(28, 103, 181);
            --color-red: rgb(229, 55, 43);
            --color-grey: #5b5b5b;
            --color-grey-two: #979797;
            --color-light-red: rgb(255, 187, 182);
            --color-orange: rgb(229, 95, 43);
            --color-pink: rgb(255, 137, 156);
            --color-yellow: rgb(236, 236, 94);
            --color-vinotinto: #b41c38;
            --color-blue: rgb(98, 113, 224);
            --color-black: rgb(47, 47, 47);
            --color-red: rgb(203, 43, 37);
        }

        .critical-stock {
            border-radius: 0.5rem;
            padding: 0.4rem 0.7rem;
            background-color: var(--color-yellow);
        }

        .out-stock {
            border-radius: 0.5rem;
            color: white;
            padding: 0.4rem 0.7rem;
            background-color: var(--color-black);
        }

        .low-stock {
            border-radius: 0.5rem;
            padding: 0.4rem 0.7rem;
            color: white;
            background-color: var(--color-red);
        }
    </style>
</head>
<div class="flex-full__justify-content-between p-0">
    <div>
        <span><b>{{ $title }}</b></span>
    </div>
    <div>
        {{-- Formato de fecha más legible. Carbon es ideal aquí si lo usas en el controlador. --}}
        <span>Fecha de Generación:
            @php
                $dateCurrenty = Date('Y-m-d');
                $created_at = substr($dateCurrenty, 0, 10);
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
            @endphp </span>
    </div>
</div>

<div class="">
    <section class='table'>
        <table class='dataTable'>
            <thead>
                <tr>
                    <th>Código de Producto (SKU)</th>
                    <th>Nombre del Producto</th>
                    <th>Precio de Venta</th>
                    <th>Ubicación del Producto</th>
                    <th>Stock Actual</th>
                    @if ($state == true)
                        <th>Estado</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                {{-- Verifica si la colección de productos está vacía o es null --}}
                @forelse ($products as $value)
                    <tr class='show'>
                        <td>{{ $value->code ?? 'N/A' }}</td> {{-- Mejor "N/A" que "2" si el código no existe --}}
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
                        <td>{{ $value->location->name ?? 'No hay ninguna ubicación asociada' }}</td> {{-- Considera si
                        location podría ser null
                        --}}
                        <td>{{ $value->stock_available ?? 0 }}</td>
                        @if ($state == true)
                            <td>
                                @if ($value->stock_available == 0)
                                    <span class="out-stock">Agotado</span>
                                @elseif ($value->stock_available >= 4 && $value->stock_available <= 8)
                                    <span class="critical-stock">Crítico</span>
                                @elseif ($value->stock_available > 0 && $value->stock_available < 4)
                                    <span class="low-stock">Bajo</span>
                                @else
                                    {{-- Opcional: un estado para stock "normal" si $value->stock_available > 8 --}}
                                    <span class="normal-stock">Normal</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        {{-- colspan para que el mensaje ocupe toda la fila de la tabla --}}
                        <td colspan="6" style="text-align: center;">No hay productos solicitados en este momento.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>