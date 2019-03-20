<?php

use ComprobanteElectronico\Enums\CodeType;
use ComprobanteElectronico\Data\ItemCode;

/**
 * Test item code model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ItemCodeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $model = new ItemCode;
        $model->type = CodeType::VENDOR;
        $model->code = 123456789;
        // Assert
        $this->assertEquals('{"type":"01","code":123456789}', (string)$model);
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Type is missing.
     */
    public function testIsValidMissingTypeException()
    {
        // Prepare
        $model = new ItemCode;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Code is missing.
     */
    public function testIsValidMissingCodeException()
    {
        // Prepare
        $model = new ItemCode;
        $model->type = CodeType::VENDOR;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown code type '99999'.
     */
    public function testIsValidInvalidTypeException()
    {
        // Prepare
        $model = new ItemCode;
        $model->type = '99999';
        $model->code = 123456789;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Code is greater than 20 characters.
     */
    public function testIsValidInvalidCodeException()
    {
        // Prepare
        $model = new ItemCode;
        $model->type = CodeType::VENDOR;
        $model->code = '12345678901234567890123';
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
        $model = new ItemCode;
        $model->type = CodeType::VENDOR;
        $model->code = 123456789;
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
        $model = new ItemCode;
        $model->type = CodeType::VENDOR;
        $model->code = 123456789;
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $model->appendXml('model', $xml);
        $xml = $xml->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<Tipo>01</Tipo>') !== false);
        $this->assertTrue(strpos($xml, '<Codigo>123456789</Codigo>') !== false);
    }
}