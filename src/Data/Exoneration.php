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
            throw new Exception(__i18n('Type is missing.'));
        if ($this->number === null || strlen($this->number) === 0)
            throw new Exception(__i18n('Number is missing.'));
        if ($this->entityName === null || strlen($this->entityName) === 0)
            throw new Exception(__i18n('Name is missing.'));
        if ($this->date === null || strlen($this->date) === 0)
            throw new Exception(__i18n('Date is missing.'));
        if (!is_numeric($this->amount))
            throw new Exception(__i18n('Amount is not numeric.'));
        if ($this->amount > 9999999999999.99999)
            throw new Exception(__i18n('Amount should be lower than 9999999999999.99999.'));
        if (!is_integer($this->percentage))
            throw new Exception(__i18n('Percentage is not an integer.'));
        if (strlen($this->percentage) > 3)
            throw new Exception(__i18n('Percentage can not have more than 3 digits.'));
        if ($this->type && !ExonerationType::exists($this->type))
            throw new Exception(sprintf(__i18n('Unknown exoneration type \'%s\'.'), $this->type));
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