<?php

use ComprobanteElectronico\Data\Item;
use ComprobanteElectronico\Enums\CodeType;
use ComprobanteElectronico\Enums\MeasureUnitType;
use ComprobanteElectronico\Enums\TaxType;

/**
 * Test item model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ItemTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test item properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $item = new Item;
        $item->quantity = 2;
        $item->codeType = CodeType::VENDOR;
        $item->measureUnitType = MeasureUnitType::KILOGRAM;
        $item->taxType = TaxType::IVA;
        $item->comercialMeasureUnit = 'kg';
        $item->description = 'This a test item.';
        $item->price = 9.5;
        $item->totalPrice = 19.0;
        $item->discount = 0.0;
        $item->discountDescription = 'None';
        $item->subtotal = 19.0;
        $item->total = 19.0;
        $expected = '{"quantity":2,"codeType":"01","measureUnitType":"kg",'
            .'"taxType":"01","comercialMeasureUnit":"kg","description":"This a test item.",'
            .'"price":9.5,"totalPrice":19,"discount":0,"discountDescription":"None","subtotal":19,"total":19}';
        // Assert

        $this->assertEquals($expected, (string)$item);
    }
    /**
     * Test alias.
     * @since 1.0.0
     */
    public function testDetailsAlias()
    {
        // Prepare
        $item = new Item;
        $item->details = 'This a test item.';
        $expected = 'This a test item.';
        // Assert

        $this->assertEquals($expected, $item->description);
        $this->assertEquals($expected, $item->details);
    }
    /**
     * Test alias.
     * @since 1.0.0
     */
    public function testDetailsAliasEllipsis()
    {
        // Prepare
        $description = 'This is a test item that needs to have more than 1 houndred and '
            .'sixty characters. This is an expected restriction and the model should be '
            .'capable of handling and only sending the expected length';
        $shorten = 'This is a test item that needs to have more than 1 houndred and '
            .'sixty characters. This is an expected restriction and the model should be '
            .'capable of handling...';
        $item = new Item;
        $item->details = $description;
        // Assert
        $this->assertEquals($description, $item->description);
        $this->assertEquals($shorten, $item->details);
        $this->assertEquals(160, strlen($item->details));
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown code type '99999'.
     */
    public function testInvalidCodeException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = '99999';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Quantity is not numeric.
     */
    public function testQuantityDataTypeException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 'six';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Quantity can not have more than 16 digits.
     */
    public function testQuantityLengthException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 1234567891234567789564;
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Comercial measurement unit can not have more than 20 characters.
     */
    public function testComercialMeasurementLengthException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'morethan20charactersNoPermited';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Price is not numeric.
     */
    public function testPriceDataTypeException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 'six';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Price should be lower than 9999999999999.99999.
     */
    public function testPriceMaxValueException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 19999999999999.99999;
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total price is not numeric.
     */
    public function testTotalPriceDataTypeException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 'six';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total price should be lower than 9999999999999.99999.
     */
    public function testTotalPriceMaxValueException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 19999999999999.99999;
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total is not numeric.
     */
    public function testTotalDataTypeException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 11.98;
        $item->total = 'six';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total should be lower than 9999999999999.99999.
     */
    public function testTotalMaxValueException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 11.98;
        $item->total = 19999999999999.99999;
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Discount is not numeric.
     */
    public function testDiscountDataTypeException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 11.98;
        $item->total = 10.98;
        $item->discount = 'six';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Discount should be lower than 9999999999999.99999.
     */
    public function testDiscountMaxValueException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 11.98;
        $item->total = 10.98;
        $item->discount = 19999999999999.99999;
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Discount description can not have more than 80 characters.
     */
    public function testDiscountDescriptionException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 11.98;
        $item->total = 10.98;
        $item->discount = 1.00;
        $item->discountDescription = 'This should not have more than 80 charactes according to '
            .'the specifications described in apis documentation';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown tax type 'FRE'.
     */
    public function testInvalidTaxException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 11.98;
        $item->total = 10.98;
        $item->discount = 1.00;
        $item->taxType = 'FRE';
        // Assert
        $item->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown measure unit type 'A9999'.
     */
    public function testInvalidMeasureUnitException()
    {
        // Prepare
        $item = new Item;
        $item->codeType = CodeType::VENDOR;
        $item->quantity = 2;
        $item->comercialMeasureUnit = 'kg';
        $item->price = 5.99;
        $item->totalPrice = 11.98;
        $item->total = 10.98;
        $item->discount = 1.00;
        $item->measureUnitType = 'A9999';
        // Assert
        $item->isValid();
    }
}