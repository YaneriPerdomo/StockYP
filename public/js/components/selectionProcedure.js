import {
    dollarExchangeRate,
    ivaRate,
    paymentMethod,
    subTotalAllProducts,
    summaryCalculationSpan,
    ItemTable,
    itemTableBody,
    displayProductsSale,
} from "../consts/consts.js";
import { formatted, generateCostSale } from "../functions/formatted.js";
import { quantityColumnTable } from "../functions/quantityColumnTable.js";
import { setIndexEachProduct } from "../functions/setIndexEachProduct.js";
import { summarySale } from "../functions/summarySale.js";

export function insertColumnProduct() {
    displayProductsSale.addEventListener("change", async (e) => {
        let selectedOptionText = e.target.selectedOptions[0].textContent;
        let selectedOption = e.target.selectedOptions[0];
        if (selectedOptionText === 'Seleccione un producto') {
            console.clear();
            console.info('no tiene que selecciona esa option')
            return;
        }
        
        let newRow = document.createElement("tr");

        let rowCount = parseInt(ItemTable.getAttribute("data-count")) + 1;

        selectedOption.disabled = true;

        let dolar_actual = parseInt(
            Math.round(displayProductsSale.getAttribute("data-bs"))
        );
        let precio_venta = parseInt(
            Math.round(selectedOption.getAttribute("data-price-dollar"))
        );
        let precio_unitario_bs = generateCostSale(
            precio_venta,
            parseInt(selectedOption.getAttribute("data-profit-margin")),
            parseInt(selectedOption.getAttribute("discount")),
            dolar_actual,
            "BS"
        );
        let coste_sale_USD = generateCostSale(
            precio_venta,
            parseInt(selectedOption.getAttribute("data-profit-margin")),
            parseInt(selectedOption.getAttribute("discount")),
            dolar_actual,
            "USD",
            false
        );
        let total_neta_usd = generateCostSale(
            precio_venta,
            parseInt(selectedOption.getAttribute("data-profit-margin")),
            parseInt(selectedOption.getAttribute("discount")),
            dolar_actual,
            "USD",
            true
        );

        let total_neta_bs = generateCostSale(
            precio_venta,
            parseInt(selectedOption.getAttribute("data-profit-margin")),
            parseInt(selectedOption.getAttribute("discount")),
            dolar_actual,
            "BS",
            true
        );

        let coste_sale_BS = generateCostSale(
            precio_venta,
            parseInt(selectedOption.getAttribute("data-profit-margin")),
            parseInt(selectedOption.getAttribute("discount")),
            dolar_actual,
            "BS"
        );

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
                                id = "selected-product"
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
                        <div class="input-group">
                            <span class="form__icon input-group-text" id = "basic-addon1">
                            <i class="bi bi-currency-dollar"></i>
                        </span>
                        <input 
                            type="text" 
                            name="" 
                            id="sale_price_usd"
                            class="form-control" 
                            placeholder="Ej: 1"
                            value="${formatted(coste_sale_USD, true)}"
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
                            name="" 
                            id="discount"
                            class="form-control" 
                            placeholder="Ej: 1"
                            value="${
                                selectedOption.getAttribute("discount") != ""
                                    ? selectedOption.getAttribute("discount")
                                    : 0
                            }%"
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
                            name="" 
                            id="total_parcial_usd"
                            class="form-control" 
                            placeholder="Ej: 1"
                            value="${formatted(total_neta_usd, true)}"
                            aria-label="quantify"
                            aria-describedby="basic-addon1">
                        </div>
                    </td>        
                                 
                    <td>
                        <button class="btn btn-danger remove-item-btn" data-id=${rowCount} 
                        data-optionValue = ${e.target.value}
                        type="button"><i class="bi bi-trash"></i></button>
                    </td>`;
        await itemTableBody.appendChild(newRow);

        let selectedProductColumns =
            document.querySelectorAll("#selected-product");

        let totalColumn = quantityColumnTable(selectedProductColumns);

        let inputName = document.querySelectorAll("#selected-product");
        let inputSalePrice = document.querySelectorAll("#sale_price_usd");
        let inputTotalParcial = document.querySelectorAll("#total_parcial_usd");
        let inputQuantity = document.querySelectorAll("#quantity");
        let inputId = document.querySelectorAll("#id");
        let inputDiscount = document.querySelectorAll("#discount");

        //Establecer Indice Cada Producto
        setIndexEachProduct([
            inputQuantity,
            inputDiscount,
            inputName,
            inputId,
            inputSalePrice,
            inputTotalParcial,
            totalColumn,
        ]);

        e.target.value = "";

        ///////////////////////////////////
        const salePriceInput = document.querySelector(
            `[name="sale_price_usd_${totalColumn}"]`
        );
        const totalNetoInput = document.querySelector(
            `[name="total_parcial_usd_${totalColumn}"]`
        );
        const discountInput = document.querySelector(
            `[name="discount_${totalColumn}"]`
        );
        const quantityInput = document.querySelector(
            `[name="quantity_${totalColumn}"]`
        );

   
        summarySale(
            dollarExchangeRate,
            ivaRate,
            salePriceInput,
            totalNetoInput,
            discountInput,
            quantityInput,
            subTotalAllProducts,
            summaryCalculationSpan,
            paymentMethod
        );
    });
}
