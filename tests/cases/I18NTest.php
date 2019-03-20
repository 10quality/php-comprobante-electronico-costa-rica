<?php

/**
 * Tests localication.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class I18NTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test with no init.
     * @since 1.0.0
     */
    public function testNoInit()
    {
        // Prepare
        $test = 'No translation';
        // Exec
        $output = __cecr_i18n($test);
        // Assert
        $this->assertEquals('No translation', $output);
    }
    /**
     * Test spanish translations.
     * @since 1.0.0
     */
    public function testToEs()
    {
        // Prepare
        $string = 'Currency is missing.';
        // Exec
        __cecr_i18n_init('es', __DIR__.'/../cache/');
        $output = __cecr_i18n($string);
        // Assert
        $this->assertEquals('Falta el tipo de moneda (currency).', $output);
    }
}