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
        $this->assertEquals('{"time":1,"issuer":2,"receiver":3,"hasEncryption":false}', (string)$voucher);
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
        $voucher->addEntity('receptor', EntityType::JURIDICAL, 654321);
        // Assert
        $this->assertInternalType('object', $voucher->issuer);
        $this->assertInternalType('object', $voucher->receiver);
        $this->assertEquals(123456, $voucher->issuer->id);
        $this->assertEquals('01', $voucher->issuer->type);
        $this->assertEquals(654321, $voucher->receiver->id);
        $this->assertEquals('02', $voucher->receiver->type);
    }
    /**
     * Test p12 encryption.
     * @since 1.0.0
     */
    public function testEncryption()
    {
        // Prepare
        $filename = __DIR__.'/../key.p12';
        $pin = '1234';
        $voucher = new Voucher($filename, $pin);
        $voucher->xml = new SimpleXMLElement('<xml>test</xml>');
        // Exec
        $crypted = $voucher->encryptedXml;
        // Assert
        $this->assertTrue($voucher->hasEncryption);
        $this->assertNotEmpty($crypted);
        $this->assertNotEquals('<xml>test</xml>', $crypted);
    }
    /**
     * Test no encryption due to missing key.
     * @since 1.0.0
     */
    public function testMissingEncryptionKey()
    {
        // Prepare
        $pin = '1234';
        $voucher = new Voucher(null, $pin);
        $voucher->xml = new SimpleXMLElement('<xml>test</xml>');
        // Assert
        $this->assertFalse($voucher->hasEncryption);
        $this->assertNull($voucher->encryptedXml);
    }
    /**
     * Test no encryption due to missing key.
     * @since 1.0.0
     */
    public function testMissingEncryptionPin()
    {
        // Prepare
        $filename = __DIR__.'/../key.p12';
        $voucher = new Voucher($filename, null);
        $voucher->xml = new SimpleXMLElement('<xml>test</xml>');
        // Assert
        $this->assertFalse($voucher->hasEncryption);
        $this->assertNull($voucher->encryptedXml);
    }
    /**
     * Test exception
     * @since 1.0.0
     * 
     * @expectedException        Exception
     * @expectedExceptionMessage Failed to encrypt XML.
     */
    public function testFailedEncryptionException()
    {
        // Prepare
        $filename = __DIR__.'/../key.p12';
        $pin = '9999';
        $voucher = new Voucher($filename, $pin);
        $voucher->xml = new SimpleXMLElement('<xml>test</xml>');
        // Exec
        $crypted = $voucher->encryptedXml;
    }
    /**
     * Test exception
     * @since 1.0.0
     * 
     * @expectedException        Exception
     * @expectedExceptionMessage Xml must be an instance of class SimpleXMLElement.
     */
    public function testInvalidXMLException()
    {
        // Prepare
        $filename = __DIR__.'/../key.p12';
        $pin = '1234';
        $voucher = new Voucher($filename, $pin);
        $voucher->xml = '<xml>test</xml>';
        // Exec
        $crypted = $voucher->encryptedXml;
    }
    /**
     * Test reception casting.
     * @since 1.0.0
     */
    public function testValidReceptionCasting()
    {
        // Prepare
        $voucher = new Voucher;
        $voucher->key = 1;
        $voucher->time = 1522252244;
        $voucher->xml = new SimpleXMLElement('<xml>test</xml>');
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL, 123456);
        // Exec
        $array = $voucher->toReceptionArray();
        // Assert
        $this->assertInternalType('array', $array);
        $this->assertArrayHasKey('clave', $array);
        $this->assertEquals(1, $array['clave']);
        $this->assertArrayHasKey('fecha', $array);
        $this->assertEquals('2018-03-28T15:50:44Z', $array['fecha']);
        $this->assertArrayHasKey('emisor', $array);
        $this->assertInternalType('array', $array['emisor']);
        $this->assertArrayHasKey('comprobanteXml', $array);
        $this->assertInternalType('string', $array['comprobanteXml']);
    }
    /**
     * Test exception
     * @since 1.0.0
     * 
     * @expectedException        Exception
     * @expectedExceptionMessage Issuer is missing.
     */
    public function testReceptionMissingIssuerException()
    {
        // Prepare
        $voucher = new Voucher;
        // Exec
        $array = $voucher->toReceptionArray();
    }
    /**
     * Test exception
     * @since 1.0.0
     * 
     * @expectedException        Exception
     * @expectedExceptionMessage Issuer must be an instance of class Entity.
     */
    public function testReceptionInvalidIssuerException()
    {
        // Prepare
        $voucher = new Voucher;
        $voucher->issuer = 12345;
        // Exec
        $array = $voucher->toReceptionArray();
    }
    /**
     * Test exception
     * @since 1.0.0
     * 
     * @expectedException        Exception
     * @expectedExceptionMessage XML string is missing.
     */
    public function testReceptionMissingXmlException()
    {
        // Prepare
        $voucher = new Voucher;
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL, 123456);
        // Exec
        $array = $voucher->toReceptionArray();
    }
    /**
     * Test exception
     * @since 1.0.0
     * 
     * @expectedException        Exception
     * @expectedExceptionMessage Xml must be an instance of class SimpleXMLElement.
     */
    public function testReceptionInvalidXmlException()
    {
        // Prepare
        $voucher = new Voucher;
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL, 123456);
        $voucher->xml = '<xml>test</xml>';
        // Exec
        $array = $voucher->toReceptionArray();
    }
    /**
     * Test exception
     * @since 1.0.0
     * 
     * @expectedException        Exception
     * @expectedExceptionMessage Key is missing.
     */
    public function testReceptionMissingKeyException()
    {
        // Prepare
        $voucher = new Voucher;
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL, 123456);
        $voucher->xml = new SimpleXMLElement('<xml>test</xml>');
        // Exec
        $array = $voucher->toReceptionArray();
    }
    /**
     * Test exception
     * @since 1.0.0
     * 
     * @expectedException        Exception
     * @expectedExceptionMessage Key is greater than 50 characters.
     */
    public function testReceptionKeyTooBigException()
    {
        // Prepare
        $voucher = new Voucher;
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL, 123456);
        $voucher->xml = new SimpleXMLElement('<xml>test</xml>');
        $voucher->key = '123456789101234567891012345678910'
            .'123456789101234567891012345678910';
        // Exec
        $array = $voucher->toReceptionArray();
    }
    /**
     * Test reception casting.
     * @since 1.0.0
     */
    public function testValidReceptionCastingExtraFields()
    {
        // Prepare
        $voucher = new Voucher;
        $voucher->key = 1;
        $voucher->time = 1522252244;
        $voucher->xml = new SimpleXMLElement('<xml>test</xml>');
        $voucher->addEntity('issuer', EntityType::INDIVIDUAL, 123456);
        $voucher->addEntity('receiver', EntityType::INDIVIDUAL, 789101);
        $voucher->callback = 'http://test.com';
        $voucher->receiverSerial = 101;
        // Exec
        $array = $voucher->toReceptionArray();
        // Assert
        $this->assertArrayHasKey('callbackUrl', $array);
        $this->assertEquals('http://test.com', $array['callbackUrl']);
        $this->assertArrayHasKey('consecutivoReceptor', $array);
        $this->assertEquals(101, $array['consecutivoReceptor']);
        $this->assertArrayHasKey('receptor', $array);
        $this->assertInternalType('array', $array['receptor']);
    }
}