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
            '01'    => 'Individual Person',
            '02'    => 'Foreigner Person',
            '03'    => 'Business Entity',
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
            '01'    => 'Individual Person',
            '02'    => 'Foreigner Person',
            '03'    => 'Business Entity',
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
        $expected = '{"01":"Individual Person","02":"Foreigner Person","03":"Business Entity"}';
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
}