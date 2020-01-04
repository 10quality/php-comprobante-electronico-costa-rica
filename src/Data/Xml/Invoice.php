<?php

namespace ComprobanteElectronico\Data\Xml;

use Exception;
use ComprobanteElectronico\Data\Reference;
use ComprobanteElectronico\Data\Normative;
use ComprobanteElectronico\Abstracts\Xml as Model;
use ComprobanteElectronico\Enums\SaleType;
use ComprobanteElectronico\Enums\PaymentType;
use ComprobanteElectronico\Traits\XmlWithItemsTrait;

/**
 * Invoice XML model.
 * 
 * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/FacturaElectronica_V4.2.pdf
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Invoice extends Model
{
    use XmlWithItemsTrait;
    /**
     * Indicates the root element.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $element = 'FacturaElectronica';
    /**
     * Indicates the schema used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schema = 'https://tribunet.hacienda.go.cr/docs/esquemas/2017/v4.2/facturaElectronica';
    /**
     * Indicates the schema location used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schemaLocation = 'https://tribunet.hacienda.go.cr/docs/esquemas/2017/v4.2/FacturaElectronica_V.4.2.xsd';
    /**
     * Indicates the version used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $version = '4.3';
    /**
     * Returns the document type or code used to generate the sequential number.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $doctype = '01';
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'activityCode',
        'key',
        'number',
        'id',
        'date',
        'issuer',
        'receiver',
        'saleType',
        'paymentType',
        'creditTerms',
        'currency',
        'exchangeRate',
        'totalTaxedServices',
        'totalExemptServices',
        'totalTaxedGoods',
        'totalExemptGoods',
        'totalTaxed',
        'totalExempt',
        'totalSales',
        'totalDiscount',
        'totalNetSales',
        'totalTaxes',
        'total',
        'items',
        'reference',
        'normative',
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
        if ($this->activityCode === null || strlen($this->activityCode) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Activity code')));
        if ($this->key === null || strlen($this->key) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Key')));
        if ($this->currency === null || strlen($this->currency) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Currency')));
        if ($this->saleType === null || strlen($this->saleType) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Sale type')));
        if (!SaleType::exists($this->saleType))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Sale type'), $this->saleType));
        if ($this->saleType === SaleType::CREDIT
            && ($this->creditTerms === null || strlen($this->creditTerms) === 0)
        )
            throw new Exception(sprintf(__i18n('%s is required if %s is \'%s\'.'), __i18n('Credit terms'), __i18n('Sale type'), 'CREDIT'));
        if ($this->saleType === SaleType::CREDIT && strlen($this->creditTerms) > 10)
            throw new Exception(sprintf(__i18n('%s can not have more than %d characters.'), __i18n('Credit terms'), 10));
        if ($this->paymentType === null || strlen($this->paymentType) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Payment type')));
        if (!PaymentType::exists($this->paymentType))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Payment type'), $this->paymentType));
        if ($this->exchangeRate && !is_numeric($this->exchangeRate))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Exchange rate')));
        if ($this->exchangeRate && $this->exchangeRate > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Exchange rate'), 9999999999999.99999));
        if ($this->totalTaxedServices && !is_numeric($this->totalTaxedServices))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total taxed services')));
        if ($this->totalTaxedServices && $this->totalTaxedServices > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total taxed services'), 9999999999999.99999));
        if ($this->totalExemptServices && !is_numeric($this->totalExemptServices))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total exempt services')));
        if ($this->totalExemptServices && $this->totalExemptServices > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total exempt services'), 9999999999999.99999));
        if ($this->totalTaxedGoods && !is_numeric($this->totalTaxedGoods))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total taxed goods')));
        if ($this->totalTaxedGoods && $this->totalTaxedGoods > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total taxed goods'), 9999999999999.99999));
        if ($this->totalExemptGoods && !is_numeric($this->totalExemptGoods))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total exempt goods')));
        if ($this->totalExemptGoods && $this->totalExemptGoods > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total exempt goods'), 9999999999999.99999));
        if ($this->totalTaxed && !is_numeric($this->totalTaxed))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total taxed')));
        if ($this->totalTaxed && $this->totalTaxed > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total taxed'), 9999999999999.99999));
        if ($this->totalExempt && !is_numeric($this->totalExempt))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total exempt')));
        if ($this->totalExempt && $this->totalExempt > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total exempt'), 9999999999999.99999));
        if ($this->totalSales && !is_numeric($this->totalSales))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total sales')));
        if ($this->totalSales && $this->totalSales > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total sales'), 9999999999999.99999));
        if ($this->totalDiscount && !is_numeric($this->totalDiscount))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total discount')));
        if ($this->totalDiscount && $this->totalDiscount > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total discount'), 9999999999999.99999));
        if ($this->totalNetSales && !is_numeric($this->totalNetSales))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total net sales')));
        if ($this->totalNetSales && $this->totalNetSales > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total net sales'), 9999999999999.99999));
        if ($this->totalTaxes && !is_numeric($this->totalTaxes))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total in taxes')));
        if ($this->totalTaxes && $this->totalTaxes > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total in taxes'), 9999999999999.99999));
        if ($this->reference && !is_a($this->reference, Reference::class))
            throw new Exception(sprintf(__i18n('%s must be an instance of class \'%s\'.'), __i18n('Reference'), Reference::class));
        if ($this->normative === null || strlen($this->normative) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Normative')));
        if ($this->normative && !is_a($this->normative, Normative::class))
            throw new Exception(sprintf(__i18n('%s must be an instance of class \'%s\'.'), __i18n('Normative'), Normative::class));
        return parent::isValid();
    }
    /**
     * Returns model as its expected XML string.
     * @since 1.0.0
     * 
     * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/FacturaElectronica_V.4.2.xsd
     *
     * @return SimpleXMLElement
     */
    public function toXml()
    {
        $xml = parent::toXml();
        // Clave
        $xmlChild = $xml->addChild('CodigoActividad', $this->activityCode);
        // Clave
        $xmlChild = $xml->addChild('Clave', $this->key);
        // Id
        $xmlChild = $xml->addChild('NumeroConsecutivo', $this->id);
        // Fecha Emision
        $xmlChild = $xml->addChild('FechaEmision', __cecrDate($this->date));
        // Emisor
        if ($this->issuer)
            $xmlChild = $this->issuer->appendXml('Emisor', $xml);
        // Receptor
        if ($this->receiver)
            $xmlChild = $this->receiver->appendXml('Receptor', $xml);
        // Sale type
        $xmlChild = $xml->addChild('CondicionVenta', $this->saleType);
        // Credit
        if ($this->creditTerms)
            $xmlChild = $xml->addChild('PlazoCredito', $this->creditTerms);
        // Payment type
        $xmlChild = $xml->addChild('MedioPago', $this->paymentType);
        // Details
        if ($this->items && count($this->items) > 0) {
            $xmlDetails = $xml->addChild('DetalleServicio');
            for ($i = 0; $i < count($this->items); ++$i) {
                $xmlItemLine = $xmlDetails->addChild('LineaDetalle');
                // Line number
                $xmlChild = $xmlItemLine->addChild('NumeroLinea', $i + 1);
                // CodigoType
                $this->items[$i]->appendXmlWithArgs('item', $xmlItemLine, ['doctype' => $this->doctype]);
            }
            // Resumen
            $xmlSummary = $xml->addChild('ResumenFactura');
            // CodigoMoneda
            $xmlChild = $xmlSummary->addChild('CodigoMoneda', $this->currency);
            // Tipo de cambio
            if ($this->exchangeRate)
                $xmlChild = $xmlSummary->addChild('TipoCambio', $this->exchangeRate);
            // TotalServGravados
            if ($this->totalTaxedServices)
                $xmlChild = $xmlSummary->addChild('TotalServGravados', $this->totalTaxedServices);
            // TotalServExentos
            if ($this->totalExemptServices)
                $xmlChild = $xmlSummary->addChild('TotalServExentos', $this->totalExemptServices);
            // TotalMercanciasGravadas
            if ($this->totalTaxedGoods)
                $xmlChild = $xmlSummary->addChild('TotalMercanciasGravadas', $this->totalTaxedGoods);
            // TotalMercanciasExentas
            if ($this->totalExemptGoods)
                $xmlChild = $xmlSummary->addChild('TotalMercanciasExentas', $this->totalExemptGoods);
            // TotalGravado
            if ($this->totalTaxed)
                $xmlChild = $xmlSummary->addChild('TotalGravado', $this->totalTaxed);
            // TotalExento
            if ($this->totalExempt)
                $xmlChild = $xmlSummary->addChild('TotalExento', $this->totalExempt);
            // TotalVenta
            if ($this->totalSales)
                $xmlChild = $xmlSummary->addChild('TotalVenta', $this->totalSales);
            // TotalDescuentos
            if ($this->totalDiscount)
                $xmlChild = $xmlSummary->addChild('TotalDescuentos', $this->totalDiscount);
            // TotalVentaNeta
            if ($this->totalNetSales)
                $xmlChild = $xmlSummary->addChild('TotalVentaNeta', $this->totalNetSales);
            // TotalVentaNeta
            if ($this->totalTaxes)
                $xmlChild = $xmlSummary->addChild('TotalImpuesto', $this->totalTaxes);
            // TotalComprobante
            if ($this->total)
                $xmlChild = $xmlSummary->addChild('TotalComprobante', $this->total);
        }
        if ($this->reference)
            $this->reference->appendXml('InformacionReferencia', $xml);
        // Normative
        $this->normative->appendXml('Normativa', $xml);
        return $xml;
    }
}