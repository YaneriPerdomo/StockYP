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
    <div style="margin-bottom: 20px; text-align: center;">
        @if ($business_data[0]['name'])
            <h1 style="padding: 0; margin: 0; color: #000080;"><b>{{ $business_data[0]['name'] }}</b></h1>
        @endif
        @if ($business_data[0]['rif'])
            <small>
                Rif: {{ $business_data[0]['identityCard']['letter']  }}-{{ $business_data[0]['rif'] }}
            </small><br>
        @endif
        @if ($business_data[0]['phone'])
            <span><b>Teléfono:</b> </span><span>{{ $business_data[0]['phone'] }}</span><br>
        @endif
        @if ($business_data[0]['email'])
            <span><b>Correo Electrónico:</b></span><span>{{ $business_data[0]['email'] }}</span><br>
        @endif
        @if ($business_data[0]['address'])
            <span><b>Dirección:</b> </span> <span>{!! $business_data[0]['address'] !!}</span><br>
        @endif
    </div>

    {{-- Client and Invoice Data Table --}}
    <section style="margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background: none; color: black; text-align: left; padding: 5px 0;">
                        <b style="color: #000080;">Datos del cliente:</b>
                    </th>
                    <th style="background: none; color: black; text-align: right; padding: 5px 0;">
                        <b style="color: #000080;">Datos de la venta:</b>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="text-align: left; padding: 5px 0; vertical-align: top;">
                        @if ($sale['customer']['name'] && $sale['customer']['lastname'])
                            <span><b>Nombre: </b>{{ $sale['customer']['name'] }} {{ $sale['customer']['lastname'] }}</span>
                            <br>
                        @endif
                        @if ($sale['customer']['phone'])
                            <span><b>Teléfono:</b> {{ $sale['customer']['phone'] }}</span><br>
                        @endif
                        @if ($sale['customer']['card'])
                            <span>Número de identificación:
                               
                                {{ $sale['customer']['identityCard']['letter'] }}-{{ $sale['customer']['card'] }}
                            </span><br>
                        @endif
                        @if ($sale['customer']['address'])
                            <span>Dirección: {!! $sale['customer']['address'] !!}</span><br>
                        @endif
                    </td>
                    <td style="text-align: right; padding: 5px 0; vertical-align: top;">
                        @if ($sale['sale_code'])
                            <span>Código de venta:
                                {{ $sale['sale_code'] }}</span> <br>
                        @endif
                        <span>Fecha de generación: {{ Date('d-m-Y') }}</span><br>


                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <h2 style="padding: 0; margin: 0; color: #000080;"><b>
            Detalles del Proceso de Reparación:
        </b></h2>
    <section style="margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                        Descripción de la falla/problema</th>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                        Técnico Responsable</th>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                        Fecha de Finalización </th>
                    <th style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                        ¿Se logro?</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                        {{ $sale_repair->comments ?? ''}}
                    </td>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                        {{ $sale_repair->technical_manager ?? '' }}
                    </td>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">
                        @php
                            $completion_date = explode('-', $sale_repair->estimated_completion_date);
                            echo $completion_date[2] . ' de ' . mes_escrito($completion_date[1]) . ' de ' . $completion_date[0];

                            function mes_escrito($month)
                            {
                                $monthWritten = array(
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
                                
                                return $monthWritten[$month];
                                
                            }

                        @endphp
                    </td>
                    <td style="padding: 8px; text-align: left; border: 1px solid #ddd;">

                    </td>

                </tr>
            </tbody>
        </table>
    </section>

</div>