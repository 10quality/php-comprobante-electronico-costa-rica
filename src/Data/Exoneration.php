<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Enums\ExonerationType;
use ComprobanteElectronico\Interfaces\XmlAppendable;

/**
 * Phone data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Exoneration extends Model implements XmlAppendable
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
        'entityName',
        'date',
        'amount',
        'percentage',
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
        if ($this->number === null || strlen($this->number) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Number')));
        if ($this->entityName === null || strlen($this->entityName) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Entity name')));
        if ($this->date === null || strlen($this->date) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Date')));
        if (!is_numeric($this->amount))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Amount')));
        if ($this->amount > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Amount'), 9999999999999.99999));
        if (!is_integer($this->percentage))
            throw new Exception(sprintf(__i18n('%s is not an integer.'), __i18n('Percentage')));
        if (strlen($this->percentage) > 3)
            throw new Exception(sprintf(__i18n('%s can not have more than %d digits.'), __i18n('Percentage'), 3));
        if ($this->type && !ExonerationType::exists($this->type))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Type'), $this->type));
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
        $xmlChild->addChild('TipoDocumento', $this->type);
        $xmlChild->addChild('NumeroDocumento', $this->number);
        $xmlChild->addChild(
            'NombreInstitucion',
            strlen($this->entityName) > 70 ? substr($this->entityName, 0, 70) : $this->entityName
        );
        $xmlChild->addChild('FechaEmision', __cecrDate($this->date));
        $xmlChild->addChild('MontoImpuesto', $this->amount);
        $xmlChild->addChild('PorcentajeCompra', $this->percentage);
    }
}