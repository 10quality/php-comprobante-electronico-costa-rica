<?php

use ComprobanteElectronico\Data\Entity;
use ComprobanteElectronico\Enums\EntityType;

/**
 * Test entity model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class EntityTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test constants.
     * @since 1.0.0
     */
    public function testConstants()
    {
        $this->assertEquals('01', EntityType::INDIVIDUAL);
        $this->assertEquals('02', EntityType::JURIDICAL);
        $this->assertEquals('03', EntityType::DIMEX);
        $this->assertEquals('04', EntityType::NITE);
    }
    /**
     * Test entity properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        $entity = new Entity;
        $entity->id = 123456;
        $entity->type = EntityType::INDIVIDUAL;
        // Assert
        $this->assertEquals('{"id":123456,"type":"01"}', (string)$entity);
    }
    /**
     * Test entity ID alias and formatting.
     * @since 1.0.0
     */
    public function testIdAlias()
    {
        // Prepare
        $entity = new Entity;
        $entity->id = '1-1212-0030';
        // Assert
        $this->assertEquals('1-1212-0030', $entity->rawId);
        $this->assertEquals(112120030, $entity->id);
    }
    /**
     * Test model conversion for reception call.
     * @since 1.0.0
     */
    public function testReceptionConversion()
    {
        // Prepare
        $entity = new Entity;
        $entity->id = '1-1212-0030';
        $entity->type = EntityType::INDIVIDUAL;
        // Execute
        $reception = $entity->toReceptionArray();
        // Assert
        $this->assertInternalType('array', $reception);
        $this->assertEquals(2, count($reception));
        $this->assertArrayHasKey('tipoIdentificacion', $reception);
        $this->assertArrayHasKey('numeroIdentificacion', $reception);
        $this->assertEquals('01', $reception['tipoIdentificacion']);
        $this->assertEquals(112120030, $reception['numeroIdentificacion']);
    }
    /**
     * Test model conversion for reception exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Entity's ID is missing.
     */
    public function testReceptionConversionExceptionId()
    {
        // Prepare
        $entity = new Entity;
        // Execute
        $reception = $entity->toReceptionArray();
    }
    /**
     * Test model conversion for reception exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Entity's type is missing.
     */
    public function testReceptionConversionExceptionType()
    {
        // Prepare
        $entity = new Entity;
        $entity->id = '1-1212-0030';
        // Execute
        $reception = $entity->toReceptionArray();
    }
    /**
     * Test model conversion for reception exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Entity's ID is greater than 12 digits.
     */
    public function testReceptionConversionExceptionIdLength()
    {
        // Prepare
        $entity = new Entity;
        $entity->id = '14-121502-00304';
        $entity->type = EntityType::INDIVIDUAL;
        // Execute
        $reception = $entity->toReceptionArray();
    }
    /**
     * Test model conversion for reception exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown entity type '99'.
     */
    public function testReceptionConversionExceptionTypeUnknown()
    {
        // Prepare
        $entity = new Entity;
        $entity->id = '1-1212-0030';
        $entity->type = '99';
        // Execute
        $reception = $entity->toReceptionArray();
    }
}