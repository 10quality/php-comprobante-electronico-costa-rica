<?php

namespace ComprobanteElectronico\Data\Xml;

use ComprobanteElectronico\Data\Xml\Invoice as Model;

/**
 * Export Invoice (Factura Electrónica de Exportación”) XML model.
 * 
 * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/NotaCreditoElectronica_4.2.pdf
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ExportInvoice extends Model
{
    /**
     * Indicates the root element.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $element = 'TiqueteElectronico';
    /**
     * Indicates the schema used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schema = 'https://tribunet.hacienda.go.cr/docs/esquemas/2017/v4.2/tiqueteElectronico';
    /**
     * Indicates the schema location used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schemaLocation = 'https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/TiqueteElectronico_V4.2.xsd';
    /**
     * Indicates the version used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $version = '4.3';
    /**
     * Returns the document type or code used to generate the sequential number.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $doctype = '09';
}