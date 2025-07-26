import {
    displayProductsSale,
    dollarExchangeRate,
    ivaRate,
    paymentMethod,
    subTotalAllProducts,
    summaryCalculationSpan,
} from "../consts/consts.js";
import { dataSummaryCleaning } from "../functions/dataSummaryCleaning.js";
import { quantityColumnTable } from "../functions/quantityColumnTable.js";
import { setIndexEachProduct } from "../functions/setIndexEachProduct.js";
import { summarySale } from "../functions/summarySale.js";

export function deleteProduct() {
    document.addEventListener("click", async (e) => {
        if (e.target.matches(".remove-item-btn")) {
            const optionValueToEnable =
                e.target.getAttribute("data-optionValue");
            const optionToEnable = displayProductsSale.querySelector(
                `option[value="${optionValueToEnable}"]`
            );
            if (optionToEnable) {
                optionToEnable.disabled = false;
            }
            e.target.closest("tr").remove();
            e.target.value = "";

            let selectedProductColumns =
                document.querySelectorAll("#selected-product");

            let totalColumn = quantityColumnTable(selectedProductColumns);

            let inputName = document.querySelectorAll("#selected-product");
            let inputSalePrice = document.querySelectorAll("#sale_price_usd");
            let inputTotalParcial =
                document.querySelectorAll("#total_parcial_usd");
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

            if (
                salePriceInput == null &&
                totalNetoInput == null &&
                discountInput == null &&
                quantityInput == null
            ) {
                return dataSummaryCleaning();
            }
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
        }
    });
}
