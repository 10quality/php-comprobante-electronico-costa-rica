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
            throw new Exception(__i18n('Type is missing.'));
        if ($this->code === null || strlen($this->code) === 0)
            throw new Exception(__i18n('Code is missing.'));
        if (!CodeType::exists($this->type))
            throw new Exception(sprintf(__i18n('Unknown code type \'%s\'.'), $this->type));
        if (strlen($this->code) > 20)
            throw new Exception(__i18n('Code is greater than 20 characters.'));
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