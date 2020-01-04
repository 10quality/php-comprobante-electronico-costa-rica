<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Enums\CodeType;
use ComprobanteElectronico\Interfaces\XmlAppendable;

/**
 * Item/Product code data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ItemCode extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'type',
        'code',
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
        if ($this->type === null || strlen($this->type) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Type')));
        if ($this->code === null || strlen($this->code) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Code')));
        if (!CodeType::exists($this->type))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Type'), $this->type));
        if (strlen($this->code) > 20)
            throw new Exception(sprintf(__i18n('%s can not have more than %d characters.'), __i18n('Code'), 20));
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
        $xmlChild->addChild('Tipo', $this->type);
        $xmlChild->addChild('Codigo', $this->code);
    }
}