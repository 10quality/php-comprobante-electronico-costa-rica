<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Interfaces\XmlAppendable;

/**
 * Phone data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Phone extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'country',
        'number',
    ];
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
        if ($this->country === null || strlen($this->country) === 0)
            throw new Exception(__i18n('Country code is missing.'));
        if ($this->number === null || strlen($this->number) === 0)
            throw new Exception(__i18n('Number is missing.'));
        if (strlen($this->country) > 3)
            throw new Exception(__i18n('Country code is greater than 3 digits.'));
        if (strlen($this->number) > 20)
            throw new Exception(__i18n('Number is greater than 20 digits.'));
        return true;
    }
    /**
     * Appends their data to an xml structure.
     * @since 1.0.0
     * 
     * @param string            $element Element to append as.
     * @param \SimpleXMLElement &$xml    XML structure to append to.
     */
    public function appendXml($element, &$xml)
    {
        $this->isValid();
        $xmlChild = $xml->addChild($element);
        // Name
        $xmlChild->addChild('CodigoPais', $this->country);
        $xmlChild->addChild('NumTelefono', $this->number);
    }
}