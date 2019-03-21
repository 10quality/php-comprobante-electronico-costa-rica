<?php

use ComprobanteElectronico\Data\Reference;
use ComprobanteElectronico\Enums\ReferenceCode;
use ComprobanteElectronico\Enums\DocType;

/**
 * Test reference model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ReferenceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $model = new Reference;
        $model->type = DocType::OTHER;
        $model->number = 123;
        $model->code = ReferenceCode::OTHER;
        $model->reason = 'o';
        $model->date = 't';
        // Assert
        $this->assertEquals('{"type":"99","number":123,"date":"t","code":"99","reason":"o"}', (string)$model);
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
        $model = new Reference;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Reason is missing.
     */
    public function testIsValidMissingReasonException()
    {
        // Prepare
        $model = new Reference;
        $model->number = 123;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Date is missing.
     */
    public function testIsValidMissingDateException()
    {
        // Prepare
        $model = new Reference;
        $model->number = 123;
        $model->reason = 'o';
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown doc type ''.
     */
    public function testIsValidMissingTypeException()
    {
        // Prepare
        $model = new Reference;
        $model->number = 123;
        $model->reason = 'o';
        $model->date = 't';
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown reference code ''.
     */
    public function testIsValidMissingCodeException()
    {
        // Prepare
        $model = new Reference;
        $model->number = 123;
        $model->reason = 'o';
        $model->date = 't';
        $model->type = DocType::OTHER;
        // Execute
        $model->isValid();
    }
    /**
     * Test method.
     * @since 1.0.0
     */
    public function testXmlAppend()
    {
        // Prepare
        $model = new Reference;
        $model->number = 123;
        $model->reason = 'os';
        $model->date = 1522252244;
        $model->type = DocType::INVOICE;
        $model->code = ReferenceCode::OTHER;
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $model->appendXml('model', $xml);
        $xml = $xml->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<TipoDoc>01</TipoDoc>') !== false);
        $this->assertTrue(strpos($xml, '<Numero>123</Numero>') !== false);
        $this->assertTrue(strpos($xml, '<FechaEmision>2018-03-28T15:50:44Z</FechaEmision>') !== false);
        $this->assertTrue(strpos($xml, '<Codigo>99</Codigo>') !== false);
        $this->assertTrue(strpos($xml, '<Razon>os</Razon>') !== false);
    }
}