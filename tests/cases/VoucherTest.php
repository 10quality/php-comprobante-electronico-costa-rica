<?php

use ComprobanteElectronico\Data\Entity;
use ComprobanteElectronico\Data\Voucher;
use ComprobanteElectronico\Enums\EntityType;

/**
 * Test voucher model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class VoucherTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $voucher = new Voucher;
        $voucher->time = 1;
        $voucher->issuer = 2;
        $voucher->receiver = 3;
        // Assert
        $this->assertEquals('{"time":1,"issuer":2,"receiver":3}', (string)$voucher);
    }
    /**
     * Test addEntity method.
     * @since 1.0.0
     */
    public function testAddEntityWithModel()
    {
        // Prepare
        $voucher = new Voucher;
        $entity = new Entity;
        $entity->id = '1-1212-0030';
        $entity->type = EntityType::INDIVIDUAL;
        // Execute
        $voucher->addEntity('issuer', $entity);
        // Assert
        $this->assertInternalType('object', $voucher->issuer);
        $this->assertEquals(112120030, $voucher->issuer->id);
        $this->assertEquals('01', $voucher->issuer->type);
    }
    /**
     * Test addEntity method.
     * @since 1.0.0
     */
    public function testAddEntityWithData()
    {
        // Prepare
        $voucher = new Voucher;
        // Execute
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL, '1-1212-0030');
        // Assert
        $this->assertEquals(112120030, $voucher->issuer->id);
        $this->assertEquals('01', $voucher->issuer->type);
    }
    /**
     * Test addEntity method exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Expecting object parameter to be an instance of 'ComprobanteElectronico\Data\Entity'.
     */
    public function testAddEntityExceptionModel()
    {
        // Prepare
        $voucher = new Voucher;
        $entity = new stdClass;
        $entity->id = '1-1212-0030';
        $entity->type = EntityType::INDIVIDUAL;
        // Execute
        $voucher->addEntity('issuer', $entity);
    }
    /**
     * Test addEntity method exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Entity's type is missing.
     */
    public function testAddEntityExceptionDataType()
    {
        // Prepare
        $voucher = new Voucher;
        // Execute
        $voucher->addEntity('issuer', '');
    }
    /**
     * Test addEntity method exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Entity's ID is missing.
     */
    public function testAddEntityExceptionDataIdMissing()
    {
        // Prepare
        $voucher = new Voucher;
        // Execute
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL);
    }
    /**
     * Test addEntity method exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Entity's ID is missing.
     */
    public function testAddEntityExceptionDataIdNull()
    {
        // Prepare
        $voucher = new Voucher;
        // Execute
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL, '');
    }
    /**
     * Test addEntity method with spanish entity names.
     * @since 1.0.0
     */
    public function testAddEntitySpanish()
    {
        // Prepare
        $voucher = new Voucher;
        // Execute
        $voucher->addEntity('emisor', EntityType::INDIVIDUAL, 123456);
        $voucher->addEntity('receptor', EntityType::FOREIGNER, 654321);
        // Assert
        $this->assertInternalType('object', $voucher->issuer);
        $this->assertInternalType('object', $voucher->receiver);
        $this->assertEquals(123456, $voucher->issuer->id);
        $this->assertEquals('01', $voucher->issuer->type);
        $this->assertEquals(654321, $voucher->receiver->id);
        $this->assertEquals('02', $voucher->receiver->type);
    }
}