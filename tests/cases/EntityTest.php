<?php

use ComprobanteElectronico\Data\Entity;
use ComprobanteElectronico\Data\Address;
use ComprobanteElectronico\Data\Phone;
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
        $entity->name = 'Juan';
        // Assert
        $this->assertEquals('{"id":123456,"type":"01","name":"Juan"}', (string)$entity);
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
     * @expectedExceptionMessage ID is missing.
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
     * @expectedExceptionMessage Type is missing.
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
     * @expectedExceptionMessage ID is greater than 12 digits.
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
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Name is missing.
     */
    public function testIsValidMissingNameException()
    {
        // Prepare
        $model = new Entity;
        // Execute
        $model->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage ID is missing.
     */
    public function testIsValidMissingIdException()
    {
        // Prepare
        $model = new Entity;
        $model->name = 'Juan';
        // Execute
        $model->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Type is missing.
     */
    public function testIsValidMissingTypeException()
    {
        // Prepare
        $model = new Entity;
        $model->name = 'Juan';
        $model->id = 123456;
        // Execute
        $model->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage ID is greater than 12 digits.
     */
    public function testIsValidInvalidIdException()
    {
        // Prepare
        $model = new Entity;
        $model->name = 'Juan';
        $model->id = '123456123456123';
        $model->type = EntityType::INDIVIDUAL;
        // Execute
        $model->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown entity type '99'.
     */
    public function testIsValidInvalidTypeException()
    {
        // Prepare
        $model = new Entity;
        $model->name = 'Juan';
        $model->id = 123456;
        $model->type = 99;
        // Execute
        $model->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Address must be an instance of class 'Address'.
     */
    public function testIsValidInvalidAddressException()
    {
        // Prepare
        $model = new Entity;
        $model->name = 'Juan';
        $model->id = 123456;
        $model->type = EntityType::INDIVIDUAL;
        $model->address = 1;
        // Execute
        $model->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Phone must be an instance of class 'Phone'.
     */
    public function testIsValidInvalidPhoneException()
    {
        // Prepare
        $model = new Entity;
        $model->name = 'Juan';
        $model->id = 123456;
        $model->type = EntityType::INDIVIDUAL;
        $model->address = new Address;
        $model->phone = 1;
        // Execute
        $model->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Fax must be an instance of class 'Phone'.
     */
    public function testIsValidInvalidFaxException()
    {
        // Prepare
        $model = new Entity;
        $model->name = 'Juan';
        $model->id = 123456;
        $model->type = EntityType::INDIVIDUAL;
        $model->address = new Address;
        $model->fax = 1;
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
        $model = new Entity;
        $model->name = 'Juan';
        $model->id = 123456;
        $model->type = EntityType::INDIVIDUAL;
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
        $model = new Entity;
        $model->name = 'Juan';
        $model->businessName = 'S.A.';
        $model->email = 'a@b.c';
        $model->id = 123456;
        $model->foreignerId = 6789123;
        $model->type = EntityType::INDIVIDUAL;
        $xml = new SimpleXMLElement('<test></test>');
        // Exec
        $model->appendXml('model', $xml);
        $xml = $xml->asXml();
        // Assert
        $this->assertTrue(strpos($xml, '<Nombre>Juan</Nombre>') !== false);
        $this->assertTrue(strpos($xml, '<Tipo>01</Tipo>') !== false);
        $this->assertTrue(strpos($xml, '<Numero>123456</Numero>') !== false);
        $this->assertTrue(strpos($xml, '<IdentificacionExtranjero>6789123</IdentificacionExtranjero>') !== false);
        $this->assertTrue(strpos($xml, '<NombreComercial>S.A.</NombreComercial>') !== false);
        $this->assertTrue(strpos($xml, '<CorreoElectronico>a@b.c</CorreoElectronico>') !== false);
    }
}