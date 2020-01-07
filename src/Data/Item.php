<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Enums\TaxType;
use ComprobanteElectronico\Enums\MeasureUnitType;
use ComprobanteElectronico\Interfaces\XmlAppendable;
use ComprobanteElectronico\Data\ItemCode;
use ComprobanteElectronico\Data\Tax;

/**
 * Invoice item data model.
 * The item is used to describe the items purchased in an order.
 * 
 * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/FacturaElectronica_V4.2.pdf
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Item extends Model implements XmlAppendable
{
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'quantity',
        'code',
        'comercialCode',
        'taxes',
        'taxableBase',
        'netTax',
        'measureUnitType',
        'comercialMeasureUnit',
        'description',
        'price',
        'totalPrice',
        'discounts',
        'subtotal',
        'total',
        'tariff',
    ];
    /**
     * Returns the ID value based on the rawId property.
     * @since 1.0.0
     *
     * @return int
     */
    protected function getDetailsAlias()
    {
        return $this->description
            ? (strlen($this->description) > 200 ? trim(substr($this->description, 0, 197)).'...' : $this->description)
            : null;
    }
    /**
     * Sets the ID alias property.
     * @since 1.0.0
     *
     * @param mixed|int|string $value Value to set to ID property.
     */
    protected function setDetailsAlias($value)
    {
        $this->description = $value;
    }
    /**
     * Adds a discount to the item.
     * @since 1.0.0
     * 
     * @param \ComprobanteElectronico\Data\Discount $discount
     * 
     * @return ComprobanteElectronico\Data\Item this for chaining.
     */
    public function discount(Discount $discount)
    {
        if ($this->discounts === null || !is_array($this->discounts))
            $this->discounts = [];
        if (count($this->discounts) > 5)
            throw new Exception(sprintf(__i18n('Cannot add more than %d discounts.'), 5));
        $this->discounts[] = $discount;
        return $this;
    }
    /**
     * Adds a tax to the item.
     * @since 1.0.0
     * 
     * @param \ComprobanteElectronico\Data\Tax $tax
     * 
     * @return ComprobanteElectronico\Data\Item this for chaining.
     */
    public function tax(Tax $tax)
    {
        if ($this->taxes === null || !is_array($this->taxes))
            $this->taxes = [];
        $this->taxes[] = $tax;
        return $this;
    }
    /**
     * Returns flag indicating if there is a certain tax type associated with the item.
     * @since 1.0.0
     * 
     * @param string $type
     * 
     * @return bool
     */
    public function hasTax($type)
    {
        for ($i = 0; $i < count($this->taxes); ++$i) {
            if ($this->taxes[$i]->type === TaxType::SERVICES)
                return true;
        }
        return false;
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
        if ($this->comercialCode && !is_a($this->comercialCode, ItemCode::class))
            throw new Exception(sprintf(__i18n('%s must be an instance of class \'%s\'.'), __i18n('Comercial code'), ItemCode::class));
        if (!is_numeric($this->quantity))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Quantity')));
        if ($this->quantity > 9999999999999.999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Quantity'), 9999999999999.999));
        if (strlen($this->code) > 13)
            throw new Exception(sprintf(__i18n('%s can not have more than %d characters.'), __i18n('Code'), 13));
        if (strlen($this->comercialMeasureUnit) > 20)
            throw new Exception(sprintf(__i18n('%s can not have more than %d characters.'), __i18n('Commercial measurement unit'), 20));
        if (!is_numeric($this->price))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Price')));
        if ($this->price > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Price'), 9999999999999.99999));
        if (!is_numeric($this->totalPrice))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total price')));
        if ($this->totalPrice > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total price'), 9999999999999.99999));
        if (!is_numeric($this->total))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Total')));
        if ($this->total > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Total'), 9999999999999.99999));
        if ($this->measureUnitType && !MeasureUnitType::exists($this->measureUnitType))
            throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Measure unit type'), $this->measureUnitType));
        if ($this->tariff && strlen($this->tariff) > 12)
            throw new Exception(sprintf(__i18n('%s can not have more than %d characters.'), __i18n('Tariff'), 12));
        if (!is_numeric($this->netTax))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Net tax')));
        if ($this->netTax && $this->netTax > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Net tax'), 9999999999999.99999));
        if ($this->hasTax(TaxType::SERVICES) && ($this->taxableBase === null || strlen($this->taxableBase) === 0))
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Taxable Base')));
        if ($this->taxableBase && !is_numeric($this->taxableBase))
            throw new Exception(sprintf(__i18n('%s is not numeric.'), __i18n('Taxable Base')));
        if ($this->taxableBase && $this->taxableBase > 9999999999999.99999)
            throw new Exception(sprintf(__i18n('%s should be lower than %s.'), __i18n('Taxable Base'), 9999999999999.99999));
        if ($this->discounts)
            for ($i = 0; $i < count($this->discounts); ++$i) {
                if (!is_a($this->discounts[$i], Discount::class))
                    throw new Exception(sprintf(__i18n('%s must be an instance of class \'%s\'.'), __i18n('Discount'), Discount::class));
            }
        if ($this->taxes)
            for ($i = 0; $i < count($this->taxes); ++$i) {
                if (!is_a($this->taxes[$i], Tax::class))
                    throw new Exception(sprintf(__i18n('%s must be an instance of class \'%s\'.'), __i18n('Tax'), Tax::class));
            }
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
        // The Item is handled differently when appended to xml because the parent needs to create
        // A sequencial number to identify the item line. There for $element will no be used.
        // -------------
        // Codigo
        if ($this->code)
            $xml->addChild('Codigo', $this->code);
        if ($this->comercialCode)
            $this->comercialCode->appendXml('CodigoComercial', $xml);
        // Cantidad
        $xml->addChild('Cantidad', number_format($this->quantity, 3, '.', ''));
        // UnidadMedida
        $xml->addChild('UnidadMedida', $this->measureUnitType);
        // UnidadMedidaComercial
        if ($this->comercialMeasureUnit)
            $xml->addChild('UnidadMedidaComercial', $this->comercialMeasureUnit);
        // Detalle
        if ($this->description)
            $xml->addChild(
                'Detalle',
                strlen($this->details) > 200 ? substr($this->details, 0, 197).'...' : $this->details
            );
        // PrecioUnitario
        $xml->addChild('PrecioUnitario', number_format($this->price, 5, '.', ''));
        // MontoTotal
        $xml->addChild('MontoTotal', number_format($this->totalPrice, 5, '.', ''));
        // MontoDescuento
        if ($this->discounts)
            foreach ($this->discounts as $discount) {
                $discount->appendXml('Descuento', $xml);
            }
        // SubTotal
        if ($this->subtotal)
            $xml->addChild('SubTotal', number_format($this->subtotal, 5, '.', ''));
        // Impuesto
        if ($this->taxes)
            foreach ($this->taxes as $tax) {
                $tax->appendXml('Impuesto', $xml);
            }
        if ($this->taxableBase)
            $xml->addChild('BaseImponible', number_format($this->taxableBase, 5, '.', ''));
        if ($this->netTax)
            $xml->addChild('ImpuestoNeto', number_format($this->netTax, 5, '.', ''));
        // Total
        $xml->addChild('MontoTotalLinea', number_format($this->total, 5, '.', ''));
    }
    /**
     * Appends their data to an xml structure.
     * @since 1.0.0
     * 
     * @param string            $element Element to append as.
     * @param \SimpleXMLElement &$xml    XML structure to append to.
     * @param arrat             $args    Additional arguments.
     */
    public function appendXmlWithArgs($element, &$xml, $args)
    {
        // Required field for Export invoice.
        if (array_key_exists('doctype', $args)
            && $args['doctype'] === '09'
            && $this->tariff
        )
            $this->tax->appendXml('PartidaArancelaria', $this->tariff);

        $this->appendXml($element, $xml);
    }
}