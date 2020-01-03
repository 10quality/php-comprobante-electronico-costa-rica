<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Enums\TaxType;
use ComprobanteElectronico\Enums\TaxRateType;
use ComprobanteElectronico\Interfaces\XmlAppendable;
use ComprobanteElectronico\Data\Exoneration;

/**
 * Phone data model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Tax extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'type',
        'rate',
        'rateType',
        'amount',
        'exportAmount',
        'exoneration',
        'ivaFactor',
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
        if (!is_numeric($this->rate))
            throw new Exception(__i18n('Rate is not numeric.'));
        if (!is_numeric($this->amount))
            throw new Exception(__i18n('Amount is not numeric.'));
        if (!is_numeric($this->exportAmount))
            throw new Exception(__i18n('Export amount is not numeric.'));
        if ($this->amount > 9999999999999.99999)
            throw new Exception(__i18n('Amount should be lower than 9999999999999.99999.'));
        if ($this->exportAmount > 9999999999999.99999)
            throw new Exception(__i18n('Export amount should be lower than 9999999999999.99999.'));
        if ($this->type && !TaxType::exists($this->type))
            throw new Exception(sprintf(__i18n('Unknown tax type \'%s\'.'), $this->type));
        if ($this->exoneration && !is_a($this->exoneration, Exoneration::class))
            throw new Exception(__i18n('Exoneration must be an instance of class \'Exoneration\'.'));
        if ($this->rateType && !TaxRateType::exists($this->rateType))
            throw new Exception(sprintf(__i18n('Unknown tax rate type \'%s\'.'), $this->rateType));
        if ($this->ivaFactor && !is_numeric($this->ivaFactor))
            throw new Exception(__i18n('IVA Factor is not numeric.'));
        if ($this->ivaFactor && $this->ivaFactor > 9.9999)
            throw new Exception(__i18n('IVA Factor should be lower than 9.9999.'));
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
        $xmlChild->addChild('Codigo', $this->type);
        $xmlChild->addChild('Tarifa', $this->rate);
        $xmlChild->addChild('Monto', $this->amount);
        if ($this->rateType)
            $xmlChild->addChild('CodigoTarifa', $this->rateType);
        if ($this->ivaFactor)
            $xmlChild->addChild('FactorIVA', $this->ivaFactor);
        if ($this->exoneration)
            $this->exoneration->appendXml('Exoneracion', $xmlChild);
    }
}