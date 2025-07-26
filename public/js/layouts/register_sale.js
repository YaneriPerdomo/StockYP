import { customerSearch } from "../components/customerSearch.js";
import { deleteProduct } from "../components/deleteProduct.js";
import { UpdatePaymentMethod } from "../components/UpdatePaymentMethod.js";
import { productsSearch } from "../components/productsSearch.js";
import { insertColumnProduct } from "../components/selectionProcedure.js";
import { generarCadenaAleatoria } from "../utilities.js";
import {receiptNumber} from "../variables.js";
import { productQuantityUpdateSummary } from "../components/productQuantityUpdateSummary.js";

document.addEventListener("DOMContentLoaded", function () {
    const saleRegisterForm = document.querySelector(".form__sale-register");

    if (saleRegisterForm) {
        saleRegisterForm.addEventListener("submit", async (e) => {
            e.preventDefault();

            const baseImponibleInput = document.querySelector(
                '[name="base_imponible"]'
            );
            const ivaInput = document.querySelector('[name="iva"]');
            const tasaCreditoInput = document.querySelector(
                '[name="tasa_credito"]'
            );
            const totalPagarInput = document.querySelector(
                '[name="total_a_pagar"]'
            );
            const clientIdInput = document.querySelector(
                '[name="id_customer"]'
            );
            const clienteIdHiddenInput = document.querySelector(
                '[name="cliente_id"]'
            );
            const paymentMethodSelect = document.querySelector(
                '[name="payment-method"]'
            );
            const metodoPagoHiddenInput = document.querySelector(
                '[name="metodo_pago"]'
            );
            const observationsInput = document.querySelector(
                '[name="observations"]'
            );
            const observacionesHiddenInput = document.querySelector(
                '[name="observaciones"]'
            );
            const expirationDateInput = document.querySelector(
                '[name="expiration_date"]'
            );
            const fechaVencimientoHiddenInput = document.querySelector(
                '[name="fecha_vencimiento"]'
            );
            const productsDollarValueElement =
                document.querySelector('[name="display-products-sale"]'); 
            const valorBsHiddenInput = document.querySelector('[name="bs"]');
            const receiptNumberInput = document.querySelector(
                '[name="receipt_number"]'
            );
            const numeroComprobanteHiddenInput = document.querySelector(
                '[name="numero_comprobante"]'
            );
            const generateInvoiceCheckbox = document.querySelector(
                '[name="generate_invoice"]'
            );
            const generarComprobantePdfHiddenInput = document.querySelector(
                '[name="generar_comprobante_pdf"]'
            );

            const currentCreditRate = document.querySelector(
                ".summary__calculation--credit-rate"
            );
            const currentCreditRateInput = document.querySelector(
                '[name="tasa_credito_actual"]'
            );

            const currentIva = document.querySelector(".summary__calculation--iva");
            const CurrentIvaInput = document.querySelector(
                '[name="iva_actual"]'
            );
            const summaryCalculationSpans = document.querySelectorAll(
                ".summary__calculation > span"
            );

            if (summaryCalculationSpans.length >= 8) {
                baseImponibleInput.value =
                summaryCalculationSpans[1].textContent;
                ivaInput.value = summaryCalculationSpans[3].textContent ?? "0"; // Use '0' string for consistency
                tasaCreditoInput.value = summaryCalculationSpans[5].textContent;
                totalPagarInput.value = summaryCalculationSpans[7].textContent;
            } else {
                console.warn(
                    "Warning: Not enough summary calculation spans found. Check HTML structure."
                );
            }

            CurrentIvaInput.value =
                parseFloat(currentIva.getAttribute("data-iva")) * 100;

            currentCreditRateInput.value =
                parseFloat(currentCreditRate.getAttribute("data-credit-rate")) *
                100;

            clienteIdHiddenInput.value = clientIdInput.value ?? "0"; // Use '0' string for consistency
            metodoPagoHiddenInput.value = paymentMethodSelect.value;
            observacionesHiddenInput.value = observationsInput.value;
            fechaVencimientoHiddenInput.value = expirationDateInput.value;
            valorBsHiddenInput.value = productsDollarValueElement.getAttribute("data-bs");
            numeroComprobanteHiddenInput.value = receiptNumberInput.value;
            generarComprobantePdfHiddenInput.value =
                generateInvoiceCheckbox.getAttribute("checkbox") != null
                    ? " Generar Venta y Descargar comprobante"
                    : " Solo Generar Venta"; // Assign the value from the generate_invoice element

            console.clear();

            console.info(generarComprobantePdfHiddenInput.value);

            e.target.submit();
        });
    } else {
        console.error(
            'Error: Sale registration form not found. Check the selector ".form__sale-register".'
        );
    }

    receiptNumber.value = generarCadenaAleatoria(8);

    customerSearch();
    productsSearch();
    insertColumnProduct()    
    deleteProduct();
    UpdatePaymentMethod();
    productQuantityUpdateSummary();

});
