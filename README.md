# Comprobante Electronico (PHP)

Librería en PHP que actúa como cliente para generar y enviar los comprobantes electrónicos requeridos por el [Ministerio de Hacienda de Costa Rica](http://www.hacienda.go.cr/).

**English**: PHP client used to generate and send online invoices to Costa Rica's "Ministerio de Hacienda" (which is an entity similar to the IRS, but in Costa Rica).

Contenido:

* [Alcance](#alcance)
* [Documentación](https://github.com/10quality/php-comprobante-electronico-costa-rica/wiki)
* [Requisitos](#requisitos)
* [Enlaces](#enlaces)
* [Licencia](#licencia)
* [Open Source](#open-source)

## Alcance

* Generación de archivos XML (Estructura version 4.3).
    * Factura electrónica
    * Mensaje de respuesta (receptor)
    * Nota de débito
    * Nota de crédito
    * Tiquete electrónico
* Encriptacion de archivo XML
* Envío a hacienda.

## Documentación

Ver la [wiki](https://github.com/10quality/php-comprobante-electronico-costa-rica/wiki) del proyecto.

## Requisitos

* PHP >= 5.5
* Llave criptográfica (PIN). Generar desde [ATV](https://www.hacienda.go.cr/ATV/ComprobanteElectronico/frmGenerarPIN_pruebas.aspx).
* Contraseña OAuth (Token OAuth). Generar desde [ATV](https://www.hacienda.go.cr/ATV/ComprobanteElectronico/frmGenerarToken_pruebas.aspx).

## Enlaces

Lista de enlaces a la documentación proporcionada por hacienda:

* Guia [Comprobante electrónico](http://www.hacienda.go.cr/docs/5a6f9e6abb19f_Guia%20Comprobantes%20Electronicos.pdf).
* [Documentación oficial](http://www.hacienda.go.cr/contenido/14350-factura-electronica) del Hacienda.
* [Documentación programación](https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/comprobantes-electronicos-api.html).
* [Estructura XML](https://tribunet.hacienda.go.cr/FormatosYEstructurasXML.jsp)

### Registro de cambios

* [v4.3](https://www.hacienda.go.cr/ATV/ComprobanteElectronico/docs/esquemas/2016/v4.3/ANEXOS%20Y%20ESTRUCTURAS_V4.3.pdf)

## Desarrollo y contribución

Cualquier aporte debe seguir los lineamientos o estándares establecidos en [PSR-2](https://www.php-fig.org/psr/psr-2/).

Para realizar pruebas (Unit testing) con Phpunit, deberas copiar una "llave criptográfica" de pruebas en la carpeta "tests", esta llave debera tener pin "1234".

## Licencia

Licencia MIT. [Detalles](https://es.wikipedia.org/wiki/Licencia_MIT)

## Open Source

Este paquete es open source (codigo abierto) y es actualmente mantenido y administrado por [10 Quality](https://www.10quality.com/).