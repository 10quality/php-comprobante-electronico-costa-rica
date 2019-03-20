<?php

namespace ComprobanteElectronico\Data;

use Exception;
use TenQuality\Data\Model;
use ComprobanteElectronico\Enums\CodeType;
use ComprobanteElectronico\Enums\TaxType;
use ComprobanteElectronico\Enums\MeasureUnitType;
use ComprobanteElectronico\Interfaces\XmlAppendable;

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
        'codeType',
        'measureUnitType',
        'taxType',
        'comercialMeasureUnit',
        'description',
        'price',
        'totalPrice',
        'discount',
        'discountDescription',
        'subtotal',
        'total',
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
            ? (strlen($this->description) > 160 ? trim(substr($this->description, 0, 157)).'...' : $this->description)
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
     * Returns flag indicating if model is valid for casting.
     * @since 1.0.0
     * 
     * @throws Exception
     *
     * @return bool
     */
    public function isValid()
    {
        if (!CodeType::exists($this->codeType))
            throw new Exception(sprintf(__i18n('Unknown code type \'%s\'.'), $this->codeType));
        if (!is_numeric($this->quantity))
            throw new Exception(__i18n('Quantity is not numeric.'));
        if (strlen($this->quantity) > 16)
            throw new Exception(__i18n('Quantity can not have more than 16 digits.'));
        if (strlen($this->comercialMeasureUnit) > 20)
            throw new Exception(__i18n('Commercial measurement unit cannot have more than 20 characters.'));
        if (!is_numeric($this->price))
            throw new Exception(__i18n('Price is not numeric.'));
        if ($this->price > 9999999999999.99999)
            throw new Exception(__i18n('Price should be lower than 9999999999999.99999.'));
        if (!is_numeric($this->totalPrice))
            throw new Exception(__i18n('Total price is not numeric.'));
        if ($this->totalPrice > 9999999999999.99999)
            throw new Exception(__i18n('Total price should be lower than 9999999999999.99999.'));
        if (!is_numeric($this->total))
            throw new Exception(__i18n('Total is not numeric.'));
        if ($this->total > 9999999999999.99999)
            throw new Exception(__i18n('Total should be lower than 9999999999999.99999.'));
        if ($this->discount && !is_numeric($this->discount))
            throw new Exception(__i18n('Discount is not numeric.'));
        if ($this->discount && $this->discount > 9999999999999.99999)
            throw new Exception(__i18n('Discount should be lower than 9999999999999.99999.'));
        if ($this->discountDescription && strlen($this->discountDescription) > 80)
            throw new Exception(__i18n('Discount description can not have more than 80 characters.'));
        if ($this->taxType && !TaxType::exists($this->taxType))
            throw new Exception(sprintf(__i18n('Unknown tax type \'%s\'.'), $this->taxType));
        if ($this->measureUnitType && !MeasureUnitType::exists($this->measureUnitType))
            throw new Exception(sprintf(__i18n('Unknown measure unit type \'%s\'.'), $this->measureUnitType));
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
        // CodigoType
        $xml->addChild('Codigo', $this->codeType);
        // Cantidad
        $xml->addChild('Cantidad', $this->quantity);
        // UnidadMedida
        $xml->addChild('UnidadMedida', $this->measureUnitType);
        // UnidadMedidaComercial
        if ($this->comercialMeasureUnit)
            $xml->addChild('UnidadMedidaComercial', $this->comercialMeasureUnit);
        // Detalle
        if ($this->description)
            $xml->addChild('Detalle', $this->details);
        // PrecioUnitario
        $xml->addChild('PrecioUnitario', $this->price);
        // MontoTotal
        $xml->addChild('MontoTotal', $this->totalPrice);
        // MontoDescuento
        if ($this->discount)
            $xml->addChild('MontoDescuento', $this->discount);
        // NaturalezaDescuento
        if ($this->discountDescription)
            $xml->addChild('NaturalezaDescuento', $this->discountDescription);
        // SubTotal
        if ($this->subtotal)
            $xml->addChild('SubTotal', $this->subtotal);
        // Impuesto
        if ($this->taxType)
            $xml->addChild('Impuesto', $this->taxType);
        // Total
        $xml->addChild('MontoTotalLinea', $this->total);
    }
}