<?php

namespace ComprobanteElectronico\Data;

use Exception;
use SimpleXMLElement;
use TenQuality\Data\Model;
use TenQuality\Data\Collection;
use ComprobanteElectronico\Interfaces\XmlCastable;
use ComprobanteElectronico\Enums\SaleType;
use ComprobanteElectronico\Enums\PaymentType;

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
class Invoice extends Model implements XmlCastable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'key',
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
    ];
    /**
     * Init invoice model.
     * @since 1.0.0
     * 
     * @param array $attributes Invoice attributes.
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->items = new Collection;
    }
    /**
     * Adds an item to invoice.
     * @since 1.0.0
     * 
     * @param \ComprobanteElectronico\Data\Item $item Item to add.
     * 
     * @return this for chaining
     */
    public function add(Item $item)
    {
        $this->items[] = $item;
        return $this;
    }
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
        if ($this->currency === null || strlen($this->currency) === 0)
            throw new Exception('Currency is missing.');
        if ($this->saleType === null || strlen($this->saleType) === 0)
            throw new Exception('Sale type is missing.');
        if (!SaleType::exists($this->saleType))
            throw new Exception(sprintf('Unknown sale type \'%s\'.', $this->saleType));
        if ($this->saleType === SaleType::CREDIT
            && ($this->creditTerms === null || strlen($this->creditTerms) === 0)
        )
            throw new Exception('Credit terms is required if sale type is set for \'CREDIT\'.');
        if ($this->saleType === SaleType::CREDIT && strlen($this->creditTerms) > 10)
            throw new Exception('Credit terms has more than 10 characters.');
        if ($this->paymentType === null || strlen($this->paymentType) === 0)
            throw new Exception('Payment type is missing.');
        if (!PaymentType::exists($this->paymentType))
            throw new Exception(sprintf('Unknown payment type \'%s\'.', $this->paymentType));
        if ($this->exchangeRate && !is_numeric($this->exchangeRate))
            throw new Exception('Exchange rate is not numeric.');
        if ($this->exchangeRate && $this->exchangeRate > 9999999999999.99999)
            throw new Exception('Exchange rate should be lower than 9999999999999.99999.');
        if ($this->totalTaxedServices && !is_numeric($this->totalTaxedServices))
            throw new Exception('Total taxed services is not numeric.');
        if ($this->totalTaxedServices && $this->totalTaxedServices > 9999999999999.99999)
            throw new Exception('Total taxed services should be lower than 9999999999999.99999.');
        if ($this->totalExemptServices && !is_numeric($this->totalExemptServices))
            throw new Exception('Total exempt services is not numeric.');
        if ($this->totalExemptServices && $this->totalExemptServices > 9999999999999.99999)
            throw new Exception('Total exempt services should be lower than 9999999999999.99999.');
        if ($this->totalTaxedGoods && !is_numeric($this->totalTaxedGoods))
            throw new Exception('Total taxed goods is not numeric.');
        if ($this->totalTaxedGoods && $this->totalTaxedGoods > 9999999999999.99999)
            throw new Exception('Total taxed goods should be lower than 9999999999999.99999.');
        if ($this->totalExemptGoods && !is_numeric($this->totalExemptGoods))
            throw new Exception('Total exempt goods is not numeric.');
        if ($this->totalExemptGoods && $this->totalExemptGoods > 9999999999999.99999)
            throw new Exception('Total exempt goods should be lower than 9999999999999.99999.');
        if ($this->totalTaxed && !is_numeric($this->totalTaxed))
            throw new Exception('Total taxed is not numeric.');
        if ($this->totalTaxed && $this->totalTaxed > 9999999999999.99999)
            throw new Exception('Total taxed should be lower than 9999999999999.99999.');
        if ($this->totalExempt && !is_numeric($this->totalExempt))
            throw new Exception('Total exempt is not numeric.');
        if ($this->totalExempt && $this->totalExempt > 9999999999999.99999)
            throw new Exception('Total exempt should be lower than 9999999999999.99999.');
        if ($this->totalSales && !is_numeric($this->totalSales))
            throw new Exception('Total sales is not numeric.');
        if ($this->totalSales && $this->totalSales > 9999999999999.99999)
            throw new Exception('Total sales should be lower than 9999999999999.99999.');
        if ($this->totalDiscount && !is_numeric($this->totalDiscount))
            throw new Exception('Total discount is not numeric.');
        if ($this->totalDiscount && $this->totalDiscount > 9999999999999.99999)
            throw new Exception('Total discount should be lower than 9999999999999.99999.');
        if ($this->totalNetSales && !is_numeric($this->totalNetSales))
            throw new Exception('Total net sales is not numeric.');
        if ($this->totalNetSales && $this->totalNetSales > 9999999999999.99999)
            throw new Exception('Total net sales should be lower than 9999999999999.99999.');
        if ($this->totalTaxes && !is_numeric($this->totalTaxes))
            throw new Exception('Total in taxes is not numeric.');
        if ($this->totalTaxes && $this->totalTaxes > 9999999999999.99999)
            throw new Exception('Total in taxes should be lower than 9999999999999.99999.');
        // Validate items
        if ($this->items)
            for ($i = 0; $i < count($this->items); ++$i) {
                $this->items[$i]->isValid();
            }
        return true;
    }
    /**
     * Returns model as its expected XML string.
     * @since 1.0.0
     * 
     * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/FacturaElectronica_V.4.2.xsd
     *
     * @return string
     */
    public function toXml()
    {
        $this->isValid();
        $xml = new SimpleXMLElement('<FacturaElectronica></FacturaElectronica>');
        // Clave
        $xmlChild = $xml->addChild('Clave', $this->key);
        // Id
        $xmlChild = $xml->addChild('NumeroConsecutivo', $this->id);
        // Fecha Emision
        $xmlChild = $xml->addChild('FechaEmision', $this->date);
        // Emisor
        if ($this->issuer)
            $xmlChild = $xml->addChild('Emisor', $this->issuer->id);
        // Receptor
        if ($this->receiver)
            $xmlChild = $xml->addChild('Receptor', $this->receiver->id);
        // Sale type
        $xmlChild = $xml->addChild('CondicionVenta', $this->saleType);
        // Credit
        if ($this->creditTerms)
            $xmlChild = $xml->addChild('PlazoCredito', $this->creditTerms);
        // Payment type
        $xmlChild = $xml->addChild('MedioPago', $this->paymentType);
        // Details
        if ($this->items && is_array($this->items)) {
            $xmlDetails = $xml->addChild('DetalleServicio');
            for ($i = 0; $i < count($this->items); ++$i) {
                $this->items[$i]->isValid();
                $xmlItemLine = $xmlDetails->addChild('LineaDetalle');
                // Line number
                $xmlChild = $xmlItemLine->addChild('NumeroLinea', $i + 1);
                // CodigoType
                $xmlChild = $xmlItemLine->addChild('Codigo', $this->items[$i]->codeType);
                // Cantidad
                $xmlChild = $xmlItemLine->addChild('Cantidad', $this->items[$i]->quantity);
                // UnidadMedida
                $xmlChild = $xmlItemLine->addChild('UnidadMedida', $this->items[$i]->measureUnitType);
                // UnidadMedidaComercial
                if ($this->items[$i]->comercialMeasureUnit)
                    $xmlChild = $xmlItemLine->addChild('UnidadMedidaComercial', $this->items[$i]->comercialMeasureUnit);
                // Detalle
                if ($this->items[$i]->description)
                    $xmlChild = $xmlItemLine->addChild('Detalle', $this->items[$i]->details);
                // PrecioUnitario
                $xmlChild = $xmlItemLine->addChild('PrecioUnitario', $this->items[$i]->price);
                // MontoTotal
                $xmlChild = $xmlItemLine->addChild('MontoTotal', $this->items[$i]->totalPrice);
                // MontoDescuento
                if ($this->items[$i]->discount)
                    $xmlChild = $xmlItemLine->addChild('MontoDescuento', $this->items[$i]->discount);
                // NaturalezaDescuento
                if ($this->items[$i]->discountDescription)
                    $xmlChild = $xmlItemLine->addChild('NaturalezaDescuento', $this->items[$i]->discountDescription);
                // SubTotal
                $xmlChild = $xmlItemLine->addChild('SubTotal', $this->items[$i]->subtotal);
                // Impuesto
                if ($this->items[$i]->taxType)
                    $xmlChild = $xmlItemLine->addChild('Impuesto', $this->items[$i]->taxType);
                // Total
                $xmlChild = $xmlItemLine->addChild('MontoTotalLinea', $this->items[$i]->total);
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
        return $xml;
    }
}