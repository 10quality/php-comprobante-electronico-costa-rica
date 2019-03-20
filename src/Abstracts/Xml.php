<?php

namespace ComprobanteElectronico\Abstracts;

use Exception;
use SimpleXMLElement;
use TenQuality\Data\Model;
use ComprobanteElectronico\Interfaces\XmlCastable;
use ComprobanteElectronico\Enums\SaleType;
use ComprobanteElectronico\Enums\PaymentType;
use ComprobanteElectronico\Traits\XmlWithItemsTrait;

/**
 * Invoice XML model.
 * 
 * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/FacturaElectronica_V4.2.pdf
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
abstract class Xml extends Model implements XmlCastable
{
    /**
     * Indicates the root element.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $element = '';
    /**
     * Indicates the schema used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schema = '';
    /**
     * Indicates the schema location used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schemaLocation = '';
    /**
     * Indicates the version used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $version = '';
    /**
     * Returns flag indicating if model is valid for casting.
     * @since 1.0.0
     * 
     * @throws Exception
     *
     * @return bool
     */
    public function isValid()
    {
        if (method_exists($this, 'areItemsValid'))
            $this->areItemsValid();
        return true;
    }
    /**
     * Returns model as its expected XML string.
     * @since 1.0.0
     * 
     * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/FacturaElectronica_V.4.2.xsd
     *
     * @return SimpleXMLElement
     */
    public function toXml()
    {
        $this->isValid();
        $xml = new SimpleXMLElement('<'.$this->element.'></'.$this->element.'>');
        $xml->addAttribute('xmlns', $this->schema);
        $xml->addAttribute('xsi:schemaLocation', $this->schemaLocation);
        $xml->addAttribute('targetNamespace', $this->schema);
        $xml->addAttribute('version', $this->version);
        $xml->addAttribute('xmlns:xs', 'http://www.w3.org/2001/XMLSchema');
        $xml->addAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $xml->addAttribute('xmlns:vc', 'http://www.w3.org/2007/XMLSchema-versioning');
        $xml->addAttribute('xmlns:ds', 'http://www.w3.org/2000/09/xmldsig#');
        return $xml;
    }
}