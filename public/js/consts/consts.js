export const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
export const customerSearchForm = document.querySelector(".customer-search-form");
export const productsSearchForm = document.querySelector(".products-search-form");

export let displayProductsSale = document.querySelector('.products-search-form__show');
export let msg_registration_found_product = document.querySelector(
    ".message-registration-found--product"
);

export const dollarExchangeRate = parseFloat(displayProductsSale.getAttribute('data-bs').replace(',', '.'));
export const ivaRate = parseFloat(document.querySelector('.summary__calculation--iva').getAttribute('data-iva')).toFixed(2);
export const creditRate = parseFloat(document.querySelector(".summary__calculation--credit-rate").getAttribute("data-credit-rate")).toFixed(2);
export const subTotalAllProducts = document.querySelector('.product__total-sale > span');
export const summaryCalculationSpan = document.querySelectorAll('.summary__calculation > span')
export const paymentMethod = document.querySelector('#payment-method');

export const itemTableBody = document.querySelector(".table-insert");
export const ItemTable = document.querySelector(".table");