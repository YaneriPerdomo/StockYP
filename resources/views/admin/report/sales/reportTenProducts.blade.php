<head>

    <style>
        * {
            font-family: "Lato", sans-serif;
            font-weight: 100;
            font-style: normal;
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
            --color-blue: rgb(16, 59, 200);
            --color-black: rgb(47, 47, 47);
            --color-red: rgb(203, 43, 37);
        }

        .dataTable th {
            text-align: left;
            background: rgb(16, 59, 200) !important;
            border-bottom: 1px dashed #aaa;
        }

        thead>tr {
            background: rgb(16, 59, 200) !important;
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



        .text-blue {
            color: var(--color-blue);
            font-weight: bold;
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

        .total-price {
            background-color: var(--color-blue);
            color: white;
            padding: 0.5rem;
            margin-top: 1rem;
        }

        .resumen>span {
            padding: 0.5rem;
            margin: 1rem !important;
            border: solid 1px black;
        }

        .border {
            border: solid 1px black;
        }
    </style>
</head>
<div style="font-family: Arial, sans-serif; font-size: 10pt; line-height: 1.4;">
    {{-- Business Data Section --}}
    <div style="margin-bottom: 0px;">
        @if (!empty($business_data['name']))
            <span
                style="padding: 0; margin: 0; color: #004080; font-size: 1.0em; font-weight: bold;">{{ $business_data['name'] }}</span>
        @endif
    </div>
    @if ( $business_data->rif != null && $business_data->identity_card_id != null)
        <span>
            Rif: {{ $business_data->identityCard->letter ?? ''  }}-{{ $business_data->rif ?? ''}}
        </span>
    @endif
    <div style="margin-bottom: 20px; border-bottom: 2px solid #000080; padding-bottom: 10px;">
        <h1 style="padding: 0; margin: 0; color: #000080; font-size: 1.8em;"><b>Los 10 productos más vendidos del 
            @if ($tenProductsDateRange == true)
                {{ $start_date_VZL }} al {{ $end_date_VZL }}
            @else
                Dia de Hoy
            @endif
        </h1>
     
        <i style="">Fecha de Generación: {{ Date('d-m-Y') }}</i>
    </div>
 

    <section style="margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                     <th
                        style="padding: 8px; text-align: left; border: 1px solid #ddd; background-color: #004080; color: white;">
                        <b>Código de Producto</b>
                    </th>
                    <th
                        style="padding: 8px; text-align: left; border: 1px solid #ddd; background-color: #004080; color: white;">
                        <b>Descripción del Producto</b>
                    </th>
                    <th
                        style="padding: 8px; text-align: left; border: 1px solid #ddd; background-color: #004080; color: white;">
                        <b>Cantidad Vendido
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ben_products as $value)
                    <tr>
                        <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                            {{ $value->products->code ?? '' }}
                        </td>
                        <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                            {{ $value->products->name ?? '' }}
                        </td>
                        <td style="padding: 8px; text-align: center; border: 1px solid #ddd;">
                            {{ $value->cantidad_total ?? '' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="padding: 8px; text-align: center; border: 1px solid #ddd;">
                            No se encontraron productos vendidos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>