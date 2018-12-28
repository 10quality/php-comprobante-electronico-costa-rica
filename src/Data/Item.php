<?php

namespace ComprobanteElectronico\Data;

use TenQuality\Data\Model;
use ComprobanteElectronico\Enums\CodeType;
use ComprobanteElectronico\Enums\TaxType;

/**
 * Invoice item data model.
 * 
 * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/FacturaElectronica_V4.2.pdf
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class Item extends Model
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
    protected function isValid()
    {
        if (!CodeType::exists($this->codeType))
            throw new Exception(sprintf('Unknown code type \'%s\'.', $this->codeType));
        if (!is_numeric($this->quantity))
            throw new Exception('Quantity is not numeric.');
        if (strlen($this->quantity) > 16)
            throw new Exception('Quantity can not have more than 16 digits.');
        if (strlen($this->comercialMeasureUnit) > 20)
            throw new Exception('Comercial measurement unit can not have more than 20 characters.');
        if (!is_numeric($this->price))
            throw new Exception('Price is not numeric.');
        if ($this->price > 9999999999999.99999)
            throw new Exception('Price should be lower than 9999999999999.99999.');
        if (!is_numeric($this->totalPrice))
            throw new Exception('Total price is not numeric.');
        if ($this->totalPrice > 9999999999999.99999)
            throw new Exception('Total price should be lower than 9999999999999.99999.');
        if (!is_numeric($this->total))
            throw new Exception('Total is not numeric.');
        if ($this->total > 9999999999999.99999)
            throw new Exception('Total should be lower than 9999999999999.99999.');
        if ($this->discount && !is_numeric($this->discount))
            throw new Exception('Discount is not numeric.');
        if ($this->discount && $this->discount > 9999999999999.99999)
            throw new Exception('Discount should be lower than 9999999999999.99999.');
        if ($this->discountDescription && strlen($this->discountDescription) > 80)
            throw new Exception('Discount description can not have more than 80 characters.');
        if ($this->taxType && !TaxType::exists($this->taxType))
            throw new Exception(sprintf('Unknown tax type \'%s\'.', $this->taxType));
        return true;
    }
}