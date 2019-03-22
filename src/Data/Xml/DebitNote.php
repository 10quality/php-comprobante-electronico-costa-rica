<?php

namespace ComprobanteElectronico\Data\Xml;

use ComprobanteElectronico\Data\Xml\Invoice as Model;

/**
 * Debit note (Nota de debit) XML model.
 * 
 * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/NotaDebitoElectronica_V4.2.xsd.pdf
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class DebitNote extends Model
{
    /**
     * Indicates the root element.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $element = 'NotaDebitoElectronica';
    /**
     * Indicates the schema used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schema = 'https://tribunet.hacienda.go.cr/docs/esquemas/2017/v4.2/notaDebitoElectronica';
    /**
     * Indicates the schema location used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schemaLocation = 'https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/NotaDebitoElectronica.xsd';
    /**
     * Indicates the version used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $version = '4.2';
}