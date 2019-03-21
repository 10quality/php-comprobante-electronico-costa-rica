<?php

use ComprobanteElectronico\Data\Exoneration;
use ComprobanteElectronico\Enums\ExonerationType;

/**
 * Test exoneration model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ExonerationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
        $model->entityName = 'Hacienda';
        $model->date = 't';
        $model->amount = 7;
        $model->percentage = 5;
        // Assert
        $this->assertEquals('{"type":"99","number":12345,"entityName":"Hacienda","date":"t","amount":7,"percentage":5}', (string)$model);
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
        $model = new Exoneration;
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
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Name is missing.
     */
    public function testIsValidMissingNameException()
    {
        // Prepare
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
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
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
        $model->entityName = 'Hacienda';
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
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
        $model->entityName = 'Hacienda';
        $model->date = 't';
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
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
        $model->entityName = 'Hacienda';
        $model->date = 't';
        $model->amount = 99999999999991;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Percentage is not an integer.
     */
    public function testIsValidNoIntPercentageException()
    {
        // Prepare
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
        $model->entityName = 'Hacienda';
        $model->date = 't';
        $model->amount = 9;
        $model->percentage = 0.75;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Percentage is not an integer.
     */
    public function testIsValidMissingPercentageException()
    {
        // Prepare
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
        $model->entityName = 'Hacienda';
        $model->date = 't';
        $model->amount = 9;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Percentage can not have more than 3 digits.
     */
    public function testIsValidInvalidPercentageException()
    {
        // Prepare
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
        $model->entityName = 'Hacienda';
        $model->date = 't';
        $model->amount = 9;
        $model->percentage = 1455;
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
        $model = new Exoneration;
        $model->type = ExonerationType::OTHER;
        $model->number = 12345;
        $model->entityName = 'Hacienda';
        $model->date = 1522252244;
        $model->amount = 9;
        $model->percentage = 25;
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $model->appendXml('model', $xml);
        $xml = $xml->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<TipoDocumento>99</TipoDocumento>') !== false);
        $this->assertTrue(strpos($xml, '<NumeroDocumento>12345</NumeroDocumento>') !== false);
        $this->assertTrue(strpos($xml, '<NombreInstitucion>Hacienda</NombreInstitucion>') !== false);
        $this->assertTrue(strpos($xml, '<MontoImpuesto>9</MontoImpuesto>') !== false);
        $this->assertTrue(strpos($xml, '<PorcentajeCompra>25</PorcentajeCompra>') !== false);
        $this->assertTrue(strpos($xml, '<FechaEmision>2018-03-28T15:50:44Z</FechaEmision>') !== false);
    }
}