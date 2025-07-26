import {
    csrfToken,
    msg_registration_found_product,
    productsSearchForm,
    displayProductsSale,
} from "../consts/consts.js";

export function productsSearch() {
    if (!productsSearchForm) {
        console.warn(
            "El formulario de búsqueda de productos no fue encontrado. Asegúrate de que 'customerSearchForm' esté correctamente seleccionado en 'consts.js'."
        );
        return;
    }
    productsSearchForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const FormDataSearch = new FormData(productsSearchForm);
        console.info(FormDataSearch.get("products-search__name"));
        try {
            const url = productsSearchForm.action;
            const method = productsSearchForm.method;
            console.info();
            const response = await fetch(url, {
                method: method,
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    name_product: FormDataSearch.get("products-search__name"),
                }),
            });
            if (!response.ok) {
                const errorText = await response.text();
                let errorMessage = `Error HTTP: ${response.status}`;
                try {
                    const errorJson = JSON.parse(errorText);
                    errorMessage = errorJson.message || errorText; // Usar el mensaje del JSON o el texto crudo
                } catch (e) {
                    errorMessage =
                        errorText || "Error desconocido en el servidor."; // Si no es JSON, usa el texto
                }
                throw new Error(errorMessage);
            }
            const data = await response.json();
            if (data["customer"] == false) {
                msg_registration_found_product.removeAttribute("style");
                displayProductsSale.innerHTML = "";
                return;
            }
            msg_registration_found_product.style.display = "none";
            return handleCustomerResponse(data);
        } catch (error) {
            console.error("Error en la búsqueda de cliente:", error);
            alert(
                `No se pudo buscar el cliente: ${error.message || "Ocurrió un error inesperado."
                }`
            );
        }
    });
}

function handleCustomerResponse(data) {
    let cantidadProducts = data["length"];
    displayProductsSale.setAttribute("size", cantidadProducts);
    displayProductsSale.innerHTML = "<option value='' readonly >Seleccione un producto </option>";
    let selectedProducts = document.querySelectorAll("#selected-product");
    data.forEach((value) => {
        let option = document.createElement("option");
        option.textContent = value["name"];
        console.info(option.textContent);
        option.value = value["product_id"];
        option.setAttribute("data-price-dollar", value["price_dollar"]);
        option.setAttribute(
            "data-profit-margin",
            value["sale_profit_percentage"]
        );
        option.setAttribute("discount", value["discount_only_dollar"] ?? "");
        if (!selectedProducts.length == 0) {
            selectedProducts.forEach((product) => {
                if (product.value == value["name"]) {
                    option.disabled = true;
                }
            });
        }
        displayProductsSale.appendChild(option, displayProductsSale.lastChild);
    });

}
