<?php

use ComprobanteElectronico\Data\Normative;

/**
 * Test normative model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class NormativeTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $model = new Normative;
        $model->number = 123;
        $model->date = 't';
        // Assert
        $this->assertEquals('{"number":123,"date":"t"}', (string)$model);
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
        $model = new Normative;
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
        $model = new Normative;
        $model->number = 123;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Number is greater than 13 characters.
     */
    public function testIsValidInvalidNumberException()
    {
        // Prepare
        $model = new Normative;
        $model->number = 123456789012345;
        $model->date = 't';
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
        $model = new Normative;
        $model->number = 123;
        $model->date = 1522252244;
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $model->appendXml('model', $xml);
        $xml = $xml->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<NumeroResolucion>123</NumeroResolucion>') !== false);
        $this->assertTrue(strpos($xml, '<FechaResolucion>28-03-2018 15:50:44</FechaResolucion>') !== false);
    }
}