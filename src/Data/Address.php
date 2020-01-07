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
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Province code')));
        if (!preg_match('/^[0-9]$/', $this->province))
            throw new Exception(sprintf(__i18n('%s must contain %d digit.'), __i18n('Province code'), 1));
        if ($this->canton === null || strlen($this->canton) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Canton'));
        if (!preg_match('/^[0-9][0-9]$/', $this->canton))
            throw new Exception(sprintf(__i18n('%s must contain %d digits.'), __i18n('Canton'), 2));
        if ($this->district === null || strlen($this->district) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('District'));
        if (!preg_match('/^[0-9][0-9]$/', $this->district))
            throw new Exception(sprintf(__i18n('%s must contain %d digits.'), __i18n('District'), 2));
        if ($this->neighborhood !== null && !preg_match('/^[0-9][0-9]$/', $this->neighborhood))
            throw new Exception(sprintf(__i18n('%s must contain %d digits.'), __i18n('Neighborhood code'), 2));
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
        $xmlChild->addChild('Provincia', $this->province);
        $xmlChild->addChild('Canton', $this->canton);
        $xmlChild->addChild('Distrito', $this->district);
        if ($this->neighborhood)
            $xmlChild->addChild('Barrio', $this->neighborhood);
        if ($this->other)
            $xmlChild->addChild(
                'OtrasSenas',
                strlen($this->other) > 250 ? substr($this->other, 0, 250) : $this->other
            );
    }
}