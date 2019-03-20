<?php

use ComprobanteElectronico\Enums\CodeType;

/**
 * Tests localication.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ZI18NTest extends PHPUnit_Framework_TestCase
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
        $output = __i18n($test);
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
        __i18nInit('es', __DIR__.'/../cache/');
        $string = 'Currency is missing.';
        // Exec
        $output = __i18n($string);
        // Assert
        $this->assertEquals('Falta el tipo de moneda (currency).', $output);
    }
    /**
     * Test spanish translations for enums.
     * @since 1.0.0
     */
    public function testCharacterEscaping()
    {
        // Prepare
        __i18nInit('es', __DIR__.'/../cache/');
        $string = 'Unknown entity type \'%s\'.';
        // Exec
        $output = __i18n($string);
        // Assert
        $this->assertEquals('Tipo de entidad \'%s\' desconocido.', $output);
    }
    /**
     * Test spanish translations for enums.
     * @since 1.0.0
     */
    public function testEnumDescription()
    {
        // Prepare
        __i18nInit('es', __DIR__.'/../cache/');
        $enum = new CodeType;
        // Assert
        $this->assertEquals('Código del vendedor', $enum->getDescription(CodeType::VENDOR));
    }
    /**
     * Test spanish translations for enums.
     * @since 1.0.0
     */
    public function testEnumCasting()
    {
        // Prepare
        __i18nInit('es', __DIR__.'/../cache/');
        $enum = new CodeType;
        $expected = [
            '01'    => 'Código del vendedor',
            '02'    => 'Código del comprador',
            '03'    => 'Código asignado por la industria',
            '04'    => 'Código de uso interno',
            '99'    => 'Otro',
        ];
        // Assert
        $this->assertEquals($expected, $enum->getConstants());
    }
}