import { csrfToken, customerSearchForm } from "../consts/consts.js"; 
import {
    InputClientName,
    InputClientLastName,
    InputClientePhone,
    TextTareaClienteAddress,
    InputClienteIdCustomer,
    DivRegisterClient,
} from "../variables.js";

export function customerSearch() {
    if (!customerSearchForm) {
        console.warn("El formulario de búsqueda de cliente no fue encontrado. Asegúrate de que 'customerSearchForm' esté correctamente seleccionado en 'consts.js'.");
        return; 
    }

    customerSearchForm.addEventListener("submit", async (event) => {
        event.preventDefault(); 

        const cardCustomerInput = customerSearchForm.querySelector('[name="card_customer"]');
        const customerNumberSearchValue = cardCustomerInput ? cardCustomerInput.value.trim() : ''; 

        if (!customerNumberSearchValue) {
            alert('Por favor, ingrese el número de identificación del cliente.');
            cardCustomerInput.focus(); 
            return;
        }

        try {
            const url = customerSearchForm.action || "venta/buscar-cliente";
            const method = customerSearchForm.method || "POST";
            const response = await fetch(url, {
                method: method,
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,  
                },
                body: JSON.stringify({
                    supplier_id_search: customerNumberSearchValue,
                }),
            });

            if (!response.ok) {
                const errorText = await response.text();
                let errorMessage = `Error HTTP: ${response.status}`;
                try {
                    const errorJson = JSON.parse(errorText);
                    errorMessage = errorJson.message || errorText; // Usar el mensaje del JSON o el texto crudo
                } catch (e) {
                    errorMessage = errorText || "Error desconocido en el servidor."; // Si no es JSON, usa el texto
                }
                throw new Error(errorMessage); //Crear un nuevo error.
            }

            const data = await response.json(); // Esperar a que la respuesta se parseé como JSON
            
            handleCustomerResponse(data); // Llama a una función para manejar la respuesta
            
        } catch (error) {
            console.error("Error en la búsqueda de cliente:", error);
            alert(`No se pudo buscar el cliente: ${error.message || 'Ocurrió un error inesperado.'}`);
        }
    });
}

 
function handleCustomerResponse(data) {
    if (data.customer === false || !data.name) { 
        console.info("Cliente no encontrado o no válido. Limpiando campos.");
        InputClientName.value = "";
        InputClientLastName.value = "";
        InputClientePhone.value = "";
        TextTareaClienteAddress.value = "";
        InputClienteIdCustomer.value = "";
        DivRegisterClient.style.removeProperty("display");
        return;
    }

    console.log("Cliente encontrado:", data);
    InputClientName.value = data.name || ''; 
    InputClientLastName.value = data.lastname || '';
    InputClientePhone.value = data.phone || '';
    TextTareaClienteAddress.value = data.address || '';
    InputClienteIdCustomer.value = data.customer_id || '';
    DivRegisterClient.style.display = "none"; 
}
 