<?php

use ComprobanteElectronico\Data\Address;

/**
 * Test address model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class AddressTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $model = new Address;
        $model->province = 1;
        $model->canton = 2;
        $model->district = 3;
        $model->neighborhood = 4;
        $model->other = 5;
        // Assert
        $this->assertEquals('{"province":1,"canton":2,"district":3,"neighborhood":4,"other":5}', (string)$model);
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Province is missing.
     */
    public function testIsValidMissingProvinceException()
    {
        // Prepare
        $model = new Address;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Province code must contain 1 digit.
     */
    public function testIsValidInvalidProvinceException()
    {
        // Prepare
        $model = new Address;
        $model->province = 123;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Canton is missing.
     */
    public function testIsValidMissingCantonException()
    {
        // Prepare
        $model = new Address;
        $model->province = 1;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Canton code must contain 2 digits.
     */
    public function testIsValidInvalidCantonException()
    {
        // Prepare
        $model = new Address;
        $model->province = 1;
        $model->canton = 123;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage District is missing.
     */
    public function testIsValidMissingDistrictException()
    {
        // Prepare
        $model = new Address;
        $model->province = 1;
        $model->canton = '01';
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage District code must contain 2 digits.
     */
    public function testIsValidInvalidDistrictException()
    {
        // Prepare
        $model = new Address;
        $model->province = 1;
        $model->canton = '01';
        $model->district = 123;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Neighborhood code must contain 2 digits.
     */
    public function testIsValidInvalidNeighborhoodException()
    {
        // Prepare
        $model = new Address;
        $model->province = 1;
        $model->canton = '01';
        $model->district = '01';
        $model->neighborhood = 123;
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
        $model = new Address;
        $model->province = 1;
        $model->canton = '01';
        $model->district = '01';
        $model->neighborhood = '01';
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
        $model = new Address;
        $model->province = 7;
        $model->canton = '01';
        $model->district = '02';
        $model->neighborhood = '03';
        $model->other = 'Test';
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $model->appendXml('address', $xml);
        $xml = $xml->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<Provincia>7</Provincia>') !== false);
        $this->assertTrue(strpos($xml, '<Canton>01</Canton>') !== false);
        $this->assertTrue(strpos($xml, '<Distrito>02</Distrito>') !== false);
        $this->assertTrue(strpos($xml, '<Barrio>03</Barrio>') !== false);
        $this->assertTrue(strpos($xml, '<OtrasSenas>Test</OtrasSenas>') !== false);
    }
}