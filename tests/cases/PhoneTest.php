<?php

use ComprobanteElectronico\Data\Phone;

/**
 * Test phone model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class PhoneTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $model = new Phone;
        $model->country = 506;
        $model->number = 123456789;
        // Assert
        $this->assertEquals('{"country":506,"number":123456789}', (string)$model);
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Country code is missing.
     */
    public function testIsValidMissingCountryException()
    {
        // Prepare
        $model = new Phone;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Number is missing.
     */
    public function testIsValidMissingNumberException()
    {
        // Prepare
        $model = new Phone;
        $model->country = 123;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Country code is greater than 3 digits.
     */
    public function testIsValidInvalidCountryException()
    {
        // Prepare
        $model = new Phone;
        $model->country = 1234;
        $model->number = 123456789;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Number is greater than 20 digits.
     */
    public function testIsValidInvalidNumberException()
    {
        // Prepare
        $model = new Phone;
        $model->country = 123;
        $model->number = '12345678901234567890123';
        // Execute
        $model->isValid();
    }
    /**
     * Test method.
     * @since 1.0.0
     */
    public function testIsValid()
    {
        // Prepare
        $model = new Phone;
        $model->country = 506;
        $model->number = 123456789;
        // Assert
        $this->assertTrue($model->isValid());
    }
    /**
     * Test method.
     * @since 1.0.0
     */
    public function testXmlAppend()
    {
        // Prepare
        $model = new Phone;
        $model->country = 506;
        $model->number = 123456789;
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $model->appendXml('model', $xml);
        $xml = $xml->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<CodigoPais>506</CodigoPais>') !== false);
        $this->assertTrue(strpos($xml, '<NumTelefono>123456789</NumTelefono>') !== false);
    }
}