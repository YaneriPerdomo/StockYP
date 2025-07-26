<!doctype html>
<html lang="es" class="height-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Nueva Mercancía | <x-systen-name></x-systen-name></title>
    <link rel="stylesheet" href="../../../css/utilities.css">
    <link rel="stylesheet" href="../../../css/layouts/_base.css">
    <link rel="stylesheet" href="../../../css/components/_button.css">
    <link rel="stylesheet" href="../../../css/components/_footer.css">
    <link rel="stylesheet" href="../../../css/components/_form.css">
    <link rel="stylesheet" href="../../../css/components/_table.css">
    <link rel="stylesheet" href="../../../css/components/_header.css">
    <link rel="icon" type="image/x-icon" href="./../../../img/icono.ico">
    <link rel="stylesheet" href="../css/components/_selection-operations.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body class="h-100 d-flex flex-column">
     <x-header-admin relativePath='../'></x-header-admin>
    <x-selection-operations></x-selection-operations>
    <main class="flex__grow-2 flex-full__aligh-start">
        <form action="{{ route('good.store') }}" method="post" class="form w-adjustable">
            @csrf
            @method('POST')
            <legend class="form__title">
                <b>Registrar Nueva Mercancía</b>
            </legend>

            @if (session('alert-success'))
                <div class="alert alert-success">
                    {{ session('alert-success') }}
                </div>
            @endif

            @if (session('alert-danger'))
                <div class="alert alert-danger" role="alert">
                    {{ session('alert-danger') }}
                </div>
            @endif
            <div class="form__item">
                <label for="product" class="form__label form__label--required">Producto</label>
                <div class="input-group ">
                    <span class="form__icon input-group-text @error ('product_id') is-invalid--border @enderror"
                        id="basic-addon1">
                        <i class="bi bi-box-seam"></i> </span> {{-- Changed icon to bi-box-seam for product --}}
                    <select class="form-select" data-dollar={{ number_format($dollar_rate->in_bs, 2, ',', '.') }}
                        name="product_id" id="product" aria-label="Seleccione el producto">
                        <option selected readonly>Seleccione una opción</option>
                        @foreach ($products as $value)
                            <option value="{{ $value->product_id }}" data-priceDollar="{{ $value->price_dollar }}">{{$value->name . ' ' . $value->code}}</option>
                        @endforeach
                    </select>
                </div>
                @error('product_id') {{-- Changed error check to product_id --}}
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form__item">
                <label for="description" class="form__label">Motivo de la Entrada</label>
                <div class="input-group">
                    <span class="form__icon input-group-text @error('description') is-invalid--border @enderror"
                        id="description-addon"><i class="bi bi-text-paragraph"></i></span>
                    <textarea name="description" id="description" rows="3"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Breve descripción de la mercancía..." {{-- Changed placeholder text --}}
                        aria-label="Descripción de la mercancía">{{ old('description') }}</textarea> {{-- Changed
                    aria-label text --}}
                </div>
                @error('description') <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            <section class='table' data-count='0'>
                <table class='dataTable'>
                    <thead>
                        <tr>
                            <th>Nombre del producto</th>
                            <th>Cantidad</th>

                            <th>Operación</th>
                        </tr>
                    </thead>
                    <tbody class="table-insert">
                    </tbody>
                </table>
            </section>
            <div class="form__button w-100 my-3">
                <button class="button button--color-blue w-100" type="submit">
                    Guardar cambios
                </button>
            </div>
        </form>
    </main>
    <x-footer></x-footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>

    <script>


        let itemSelect = document.querySelector("#product");
        let itemTableBody = document.querySelector('.table-insert');
        let ItemTable = document.querySelector('.table');
        itemSelect.addEventListener('change', async e => {

            let selectedOptionText = e.target.selectedOptions[0].textContent;
            let selectedOption = e.target.selectedOptions[0];
            if (selectedOptionText.disabled) {
                return;
            }
            let newRow = document.createElement('tr');

            let rowCount = parseInt(ItemTable.getAttribute('data-count')) + 1;
            /*
            ItemTable.setAttribute('data-count', rowCount);
           newRow.setAttribute('data-id', rowCount)*/


            selectedOption.disabled = true;

            newRow.innerHTML = `
                    <td>
                        <div class="input-group ">
                            <span class="form__icon input-group-text" id="basic-addon1">
                                <i class="bi bi-box"></i>
                            </span>
                            <input 
                                type="hidden" 
                                id="id" 
                                name="id" 
                                value="${e.target.value}"
                            >
                            <input 
                                type="text" 
                                readonly 
                                id = "name"
                                name="" 
                                class="form-control"
                                placeholder="Ej: 32" 
                                aria-label="name" 
                                aria-describedby="basic-addon1" 
                                value="${selectedOptionText}">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="form__icon input-group-text" id = "basic-addon1">
                            <i class="bi bi-hash"></i> 
                        </span>
                        <input 
                            type="number" 
                            name="" 
                            id="quantity"
                            class="form-control" 
                            placeholder="Ej: 1"
                            value="1"
                            aria-label="quantify"
                            aria-describedby="basic-addon1">
                        </div>
                    </td>                    
                    <td>
                        <button class="btn btn-danger remove-item-btn" data-id=${rowCount} 
                        data-optionValue = ${e.target.value}
                        type="button">Eliminar</button>
                    </td>`;
            await itemTableBody.appendChild(newRow);

            let InputNameTotal = 0;
            document.querySelectorAll('#name').forEach(element => {
                InputNameTotal++;
            });
            let inputName = document.querySelectorAll('#name');
            let inputQuantity = document.querySelectorAll('#quantity');
            let inputId = document.querySelectorAll('#id');
            let sequentialIndex = 1
            for (let i = 0; i <= InputNameTotal; i++) {
                if (!inputName[i]) {
                    break;
                }
                inputName[i].setAttribute('name', `name_${sequentialIndex}`)
                inputQuantity[i].setAttribute('name', `quantity_${sequentialIndex}`)
                inputId[i].setAttribute('name', `id_${sequentialIndex}`)
                sequentialIndex++;
            }
            e.target.value = '';
        })


        document.addEventListener('click', async e => {
            if (e.target.matches('.remove-item-btn')) {
                const optionValueToEnable = e.target.getAttribute('data-optionValue');
                const optionToEnable = itemSelect.querySelector(`option[value="${optionValueToEnable}"]`);
                if (optionToEnable) {
                    optionToEnable.disabled = false;
                }
                e.target.closest('tr').remove();
                e.target.value = '';
                let InputNameTotal = 0;
                document.querySelectorAll('#name').forEach(element => {
                    InputNameTotal++;
                });
                let inputName = document.querySelectorAll('#name');
                let inputQuantity = document.querySelectorAll('#quantity');
                let inputId = document.querySelectorAll('#id');
                let sequentialIndex = 1
                for (let i = 0; i <= InputNameTotal; i++) {
                    if (!inputName[i]) {
                        break;
                    }
                    inputId[i].setAttribute('name', `id_${sequentialIndex}`)
                    inputName[i].setAttribute('name', `name_${sequentialIndex}`)
                    inputQuantity[i].setAttribute('name', `quantity_${sequentialIndex}`)
                    sequentialIndex++;
                }

            }
        })
    </script>
</body>

</html>