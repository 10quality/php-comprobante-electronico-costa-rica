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
class Normative extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'number',
        'date',
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
        if ($this->number === null || strlen($this->number) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Number')));
        if ($this->date === null || strlen($this->date) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Date')));
        if (strlen($this->number) > 13)
            throw new Exception(sprintf(__i18n('%s is greater than %d characters.'), __i18n('Number'), 13));
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
        $xmlChild->addChild('NumeroResolucion', $this->number);
        $xmlChild->addChild(
            'FechaResolucion',
            date('d-m-Y H:i:s', is_string($this->date) ? strtotime($this->date) : $this->date)
        );
    }
}
