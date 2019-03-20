<?php

/**
 * Tests functions.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class FunctionsTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test date function.
     * @since 1.0.0
     */
    public function testDate()
    {
        // Prepare
        $date = '2018-03-28 17:50:44';
        // Exec
        $value = __cecrDate($date);
        // Assert
        $this->assertEquals('2018-03-28T17:50:44Z', $value);
    }
    /**
     * Test date function.
     * @since 1.0.0
     */
    public function testTime()
    {
        // Prepare
        $time = 1522252244;
        // Exec
        $value = __cecrDate($time);
        // Assert
        $this->assertEquals('2018-03-28T15:50:44Z', $value);
    }
}