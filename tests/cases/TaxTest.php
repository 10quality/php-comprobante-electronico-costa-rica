<?php

use ComprobanteElectronico\Data\Tax;
use ComprobanteElectronico\Enums\TaxType;

/**
 * Test exoneration model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class TaxTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $model = new Tax;
        $model->type = TaxType::OTHER;
        $model->rate = 0.52;
        $model->amount = 1.25;
        // Assert
        $this->assertEquals('{"type":"99","rate":0.52,"amount":1.25}', (string)$model);
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
        $model = new Tax;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Rate is not numeric.
     */
    public function testIsValidMissingRateException()
    {
        // Prepare
        $model = new Tax;
        $model->type = TaxType::OTHER;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Amount is not numeric.
     */
    public function testIsValidMissingAmountException()
    {
        // Prepare
        $model = new Tax;
        $model->type = TaxType::OTHER;
        $model->rate = 0.52;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Amount should be lower than 9999999999999.99999.
     */
    public function testIsValidInvalidAmountException()
    {
        // Prepare
        $model = new Tax;
        $model->type = TaxType::OTHER;
        $model->rate = 0.52;
        $model->amount = 99999999999991;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown tax type 'C12'.
     */
    public function testIsValidInvalidTypeException()
    {
        // Prepare
        $model = new Tax;
        $model->type = 'C12';
        $model->rate = 0.52;
        $model->amount = 1.25;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Exoneration must be an instance of class 'Exoneration'.
     */
    public function testIsValidInvalidExonerationException()
    {
        // Prepare
        $model = new Tax;
        $model->type = TaxType::OTHER;
        $model->rate = 0.52;
        $model->amount = 1.25;
        $model->exoneration = 5;
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
        $model = new Tax;
        $model->type = TaxType::OTHER;
        $model->rate = 0.52;
        $model->amount = 1.25;
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $model->appendXml('model', $xml);
        $xml = $xml->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<Codigo>99</Codigo>') !== false);
        $this->assertTrue(strpos($xml, '<Tarifa>0.52</Tarifa>') !== false);
        $this->assertTrue(strpos($xml, '<Monto>1.25</Monto>') !== false);
    }
}