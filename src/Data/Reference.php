<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Enums\DocType;
use ComprobanteElectronico\Enums\ReferenceCode;
use ComprobanteElectronico\Interfaces\XmlAppendable;

/**
 * Document reference data model.
 * "InformacionReferencia"
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Reference extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'type',
        'number',
        'date',
        'code',
        'reason',
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
        if ($this->reason === null || strlen($this->reason) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Reason')));
        if ($this->date === null || strlen($this->date) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Date')));
        if (!DocType::exists($this->type))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Type'), $this->type));
        if (!ReferenceCode::exists($this->code))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Code'), $this->code));
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
        $xmlChild->addChild('TipoDoc', $this->type);
        $xmlChild->addChild('Numero', $this->number);
        $xmlChild->addChild('FechaEmision', __cecrDate($this->date));
        $xmlChild->addChild('Codigo', $this->code);
        $xmlChild->addChild(
            'Razon',
            strlen($this->reason) > 180 ? substr($this->reason, 0, 180) : $this->reason
        );
    }
}