<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Interfaces\XmlAppendable;

/**
 * Discount data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Discount extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'amount',
        'description',
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
        if ($this->amount && !is_numeric($this->amount))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Amount')));
        if ($this->amount && $this->amount > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Amount'), 9999999999999.99999));
        if ($this->description && strlen($this->description) > 80)
            throw new Exception(sprintf(__i18n('%s can not have more than %d characters.'), __i18n('Description'), 80));
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
        $xmlChild->addChild('MontoDescuento', number_format($this->amount, 5, '.', ''));
        $xmlChild->addChild('NaturalezaDescuento', $this->description);
    }
}