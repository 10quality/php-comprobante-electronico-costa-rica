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
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Type')));
        if (!is_numeric($this->rate))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Rate')));
        if (!is_numeric($this->amount))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Amount')));
        if ($this->amount > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Amount'), 9999999999999.99999));
        if ($this->exportAmount && !is_numeric($this->exportAmount))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Export amount')));
        if ($this->exportAmount && $this->exportAmount > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Export amount'), 9999999999999.99999));
        if ($this->type && !TaxType::exists($this->type))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Type'), $this->type));
        if ($this->rateType && !TaxRateType::exists($this->rateType))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Rate Type'), $this->rateType));
        if ($this->ivaFactor && !is_numeric($this->ivaFactor))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('IVA Factor')));
        if ($this->ivaFactor && $this->ivaFactor > 9.9999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('IVA Factor'), 9.9999));
        if ($this->exoneration && !is_a($this->exoneration, Exoneration::class))
            throw new Exception(sprintf(__i18n('%s must be an instance of class \'%s\'.'), __i18n('Exoneration'), Exoneration::class));
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