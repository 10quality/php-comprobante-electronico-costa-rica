<?php

use ComprobanteElectronico\Enums\EntityType;

/**
 * Enum tests.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class EnumTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test method.
     * @since 1.0.0
     */
    public function testGetConstants()
    {
        // Prepare
        $enum = new EntityType;
        $expected = [
            '01'    => 'Individual Identification',
            '02'    => 'Juridical Identification',
            '03'    => 'DIMEX',
            '04'    => 'NITE',
        ];
        // Assert
        $this->assertEquals($expected, $enum->getConstants());
    }
    /**
     * Test casting.
     * @since 1.0.0
     */
    public function testArrayCasting()
    {
        // Prepare
        $enum = new EntityType;
        $expected = [
            '01'    => 'Individual Identification',
            '02'    => 'Juridical Identification',
            '03'    => 'DIMEX',
            '04'    => 'NITE',
        ];
        // Assert
        $this->assertEquals($expected, $enum->toArray());
    }
    /**
     * Test casting.
     * @since 1.0.0
     */
    public function testStringCasting()
    {
        // Prepare
        $enum = new EntityType;
        $expected = '{"01":"Individual Identification","02":"Juridical Identification","03":"DIMEX","04":"NITE"}';
        // Assert
        $this->assertEquals($expected, (string)$enum);
    }
    /**
     * Test method.
     * @since 1.0.0
     */
    public function testExistsMethod()
    {
        // Assert
        $this->assertTrue(EntityType::exists(EntityType::INDIVIDUAL));
        $this->assertFalse(EntityType::exists('900999'));
    }
    /**
     * Test method.
     * @since 1.0.0
     */
    public function testGetDescription()
    {
        // Prepare
        $enum = new EntityType;
        // Assert
        $this->assertEquals('Individual Identification', $enum->getDescription(EntityType::INDIVIDUAL));
    }
}