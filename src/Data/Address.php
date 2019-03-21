<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Interfaces\XmlAppendable;

/**
 * Address data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Address extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'province',
        'canton',
        'district',
        'neighborhood',
        'other',
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
        if ($this->province === null || strlen($this->province) === 0)
            throw new Exception(__i18n('Province is missing.'));
        if (!preg_match('/^[0-9]$/', $this->province))
            throw new Exception(__i18n('Province code must contain 1 digit.'));
        if ($this->canton === null || strlen($this->canton) === 0)
            throw new Exception(__i18n('Canton is missing.'));
        if (!preg_match('/^[0-9][0-9]$/', $this->canton))
            throw new Exception(__i18n('Canton code must contain 2 digits.'));
        if ($this->district === null || strlen($this->district) === 0)
            throw new Exception(__i18n('District is missing.'));
        if (!preg_match('/^[0-9][0-9]$/', $this->district))
            throw new Exception(__i18n('District code must contain 2 digits.'));
        if ($this->neighborhood !== null && !preg_match('/^[0-9][0-9]$/', $this->neighborhood))
            throw new Exception(__i18n('Neighborhood code must contain 2 digits.'));
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
        $xmlChild->addChild('Provincia', $this->province);
        $xmlChild->addChild('Canton', $this->canton);
        $xmlChild->addChild('Distrito', $this->district);
        if ($this->neighborhood)
            $xmlChild->addChild('Barrio', $this->neighborhood);
        if ($this->other)
            $xmlChild->addChild(
                'OtrasSenas',
                strlen($this->other) > 160 ? substr($this->other, 0, 160) : $this->other
            );
    }
}