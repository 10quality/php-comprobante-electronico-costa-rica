<?php

use ComprobanteElectronico\Data\Xml\ResponseMessage;

use ComprobanteElectronico\Data\Entity;
use ComprobanteElectronico\Enums\MessageCode;

/**
 * Test response message XML model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ResponseMessageTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $model = new ResponseMessage;
        $model->key = 1;
        $model->issuer = 2;
        $model->receiver = 3;
        $model->date = 4;
        $model->code = 5;
        $model->description = 6;
        $model->totalTaxes = 7;
        $model->total = 8;
        $model->number = 9;
        // Assert
        $this->assertEquals(
            '{"key":1,"issuer":2,"receiver":3,"date":4,"code":5,"description":6,"totalTaxes":7,'
                .'"total":8,"number":9}'
            , (string)$model
        );
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Key is missing.
     */
    public function testIsValidMissingKeyException()
    {
        // Prepare
        $model = new ResponseMessage;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown message code ''.
     */
    public function testIsValidMissingCodeException()
    {
        // Prepare
        $model = new ResponseMessage;
        $model->key = 1;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Issuer must be an instance of class 'Entity'.
     */
    public function testIsValidMissingIssuerException()
    {
        // Prepare
        $model = new ResponseMessage;
        $model->key = 1;
        $model->code = MessageCode::ACCEPTED;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Receiver must be an instance of class 'Entity'.
     */
    public function testIsValidMissingReceiverException()
    {
        // Prepare
        $model = new ResponseMessage;
        $model->key = 1;
        $model->code = MessageCode::ACCEPTED;
        $model->issuer = new Entity;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total is not numeric.
     */
    public function testIsValidMissingTotalException()
    {
        // Prepare
        $model = new ResponseMessage;
        $model->key = 1;
        $model->code = MessageCode::ACCEPTED;
        $model->issuer = new Entity;
        $model->receiver = new Entity;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total is not numeric.
     */
    public function testIsValidInvalidTotalException()
    {
        // Prepare
        $model = new ResponseMessage;
        $model->key = 1;
        $model->code = MessageCode::ACCEPTED;
        $model->issuer = new Entity;
        $model->receiver = new Entity;
        $model->total = 'c';
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
        $model = new ResponseMessage;
        $model->key = 1;
        $model->code = MessageCode::ACCEPTED;
        $model->issuer = new Entity;
        $model->receiver = new Entity;
        $model->total = 10;
        // Execute
        $model->isValid();
    }
    /**
     * Test exepction.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total in taxes is not numeric.
     */
    public function testIsValidInvalidTotalTaxesException()
    {
        // Prepare
        $model = new ResponseMessage;
        $model->key = 1;
        $model->code = MessageCode::ACCEPTED;
        $model->issuer = new Entity;
        $model->receiver = new Entity;
        $model->total = 10;
        $model->number = 2;
        $model->totalTaxes = 'c';
        // Execute
        $model->isValid();
    }
    /**
     * Test method.
     * @since 1.0.0
     */
    public function testXml()
    {
        // Prepare
        $model = new ResponseMessage;
        $model->key = 1;
        $model->code = MessageCode::ACCEPTED;
        $model->issuer = new Entity(['rawId' => '12345']);
        $model->receiver = new Entity(['rawId' => '67890']);
        $model->total = 10;
        $model->number = 2;
        $model->totalTaxes = 1;
        $model->date = 1522252244;
        $model->description = 'test';
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $xml = $model->toXml()->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<Clave>1</Clave>') !== false);
        $this->assertTrue(strpos($xml, '<FechaEmisionDoc>2018-03-28T15:50:44Z</FechaEmisionDoc>') !== false);
        $this->assertTrue(strpos($xml, '<NumeroCedulaEmisor>12345</NumeroCedulaEmisor>') !== false);
        $this->assertTrue(strpos($xml, '<Mensaje>1</Mensaje>') !== false);
        $this->assertTrue(strpos($xml, '<DetalleMensaje>test</DetalleMensaje>') !== false);
        $this->assertTrue(strpos($xml, '<MontoTotalImpuesto>1</MontoTotalImpuesto>') !== false);
        $this->assertTrue(strpos($xml, '<TotalFactura>10</TotalFactura>') !== false);
        $this->assertTrue(strpos($xml, '<NumeroCedulaReceptor>67890</NumeroCedulaReceptor>') !== false);
        $this->assertTrue(strpos($xml, '<NumeroConsecutivoReceptor>2</NumeroConsecutivoReceptor>') !== false);
    }
}