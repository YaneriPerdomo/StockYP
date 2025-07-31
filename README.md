# Sistema web para el control de ventas e inventarios.
>>> Nota importante: Este sistema web fue desarrollado e implementado para una empresa de autopartes.
---

## 1. Introducción

Este sistema web está diseñado para pequeñas empresas que buscan un control detallado de sus productos y ventas. Les permite **gestionar con precisión la entrada y salida de mercancías**, así como la facturación de las ventas al contado para una pequeña empresa de autopartes. Si bien actualmente **se centra en el seguimiento de ventas y el cálculo de las ventas brutas**, la arquitectura del sistema permite futuras ventas a crédito, incluyendo el seguimiento de pagos y la planificación de contingencias. Gestioné todo el desarrollo e implementación del proyecto. _Aunque el cliente no lo solicitó inicialmente_, **los cálculos de ventas netas** se pueden integrar fácilmente para proporcionar una visión financiera más completa.


## 2. Requisitos funcionales del sistema web

Actores del sistema web:

-   **Administrador(a)**
    -   Es el usuario principal con permisos para gestionar todos los módulos del sistema, incluyendo usuarios, productos, categorías, proveedores, compras, ventas, facturación y reportes.
-   **Vendedor(a)**
    -   Responsable de registrar y gestionar las ventas, la facturación, seguimiento de garantias de los clientes y la emisión de recibos.
-   **Especialista de Almacen**
    -   Encargado de la gestión de inventario, incluyendo la entrada y salida de productos, actualización de stock y organización del almacén.
-   **Especialista de finanzas/compras**
    -   Dedicado a administrar los datos financieros de la empresa, también será responsable de determinar el volumen de ventas de los productos, fijar la tasa personalizada para el cambio de bolívares, así como las tasas de interés del IVA y del crédito, solicitar informes de ventas e inventarios e historial de ventas.

A continuación se muestra un diagrama de casos de uso de las funcionalidades con sus actores de forma visual para hacerlo más comprensible:

![Diagrama de casos de uso del sistema web](/public/doc/Diagrama%20de%20casos%20de%20uso.png) 

¡Cualquier cosa si tienes problemas para visualizar bien la imagen puedes abrir la carpeta que se llama public y luego de ahí ir a una carpeta que se llama doc que significa documentación y por último la imagen se llama diagrama de casos de uso en formato png!.

## 3. Tecnologías
Se recuerda que las tecnologías son una herramienta proyectual que permite la creación los sistemas web.

| Interfaz de usuario  | Lógica de negocios | Base de datos |
| --------------------   | --------- | ----- | 
| HTML                    | Laravel (PHP)        | MySQL
| CSS               |          |
| JavaScript                       |          |         |
| Bootstrap

## 4. Pasos para su instalacion

- Localmente, necesitará un programa para ejecutarlo. Puede ser Laragon o Xaamp, usted decide. 
_Tomando en cuenta estos comando_:
    - **Para la creacion de la base de datos**: php artisan migrate 
    - **Para la ejecuccion**: php artisan serve
    - Luego de ejecutar esos dos comandos desde la raíz del proyecto tendrás que ingresar al proyecto a primera vista puedes pegar esto en la url del navegador http://127.0.0.1:8000/iniciar-sesion nota que depende del puerto que estés usando pero casi siempre es http://127.0.0.1:8000/
---
---
---
_2025_ 
_Venezuela_