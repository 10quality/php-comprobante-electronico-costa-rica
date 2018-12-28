<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Measurement unit types enumerators/catalog.
 * XML: UnidadMedidaType | Unidades de Medida basadas en el estandar RTC 443:2010
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class MeasureUnitType extends Enum
{
    /**
     * Servicios Profesionales.
     * @since 1.0.0
     * 
     * @var string
     */
    const SERVICES = 'Sp';
    /**
     * Metro.
     * @since 1.0.0
     * 
     * @var string
     */
    const METER = 'm';
    /**
     * Kilogramo.
     * @since 1.0.0
     * 
     * @var string
     */
    const KILOGRAM = 'kg';
    /**
     * Segundo.
     * @since 1.0.0
     * 
     * @var string
     */
    const SECOND = 's';
    /**
     * Ampere | Ampererios.
     * @since 1.0.0
     * 
     * @var string
     */
    const AMPERE = 'A';
    /**
     * Kelvin.
     * @since 1.0.0
     * 
     * @var string
     */
    const KELVIN = 'K';
    /**
     * Mol.
     * @since 1.0.0
     * 
     * @var string
     */
    const MOL = 'mol';
    /**
     * Candela.
     * @since 1.0.0
     * 
     * @var string
     */
    const CD = 'cd';
    /**
     * Metro cuadrado.
     * @since 1.0.0
     * 
     * @var string
     */
    const SQUARE_METER = 'mÂ²';
    /**
     * Metro cubico.
     * @since 1.0.0
     * 
     * @var string
     */
    const CUBIC_METER = 'mÂ³';
    /**
     * Metro por segundo.
     * @since 1.0.0
     * 
     * @var string
     */
    const METER_PER_SECOND = 'm/s';
    /**
     * Metro por segundo cuadrado.
     * @since 1.0.0
     * 
     * @var string
     */
    const METER_PER_SQUARE_SECOND = 'm/sÂ²';
    /**
     * Uno por metro.
     * @since 1.0.0
     * 
     * @var string
     */
    const ONE_PER_METER = '1/m';
    /**
     * Kilogramo por metro cubico.
     * @since 1.0.0
     * 
     * @var string
     */
    const KILOGRAM_PER_CUBIC_METER = 'kg/mÂ³';
    /**
     * Ampere por metro.
     * @since 1.0.0
     * 
     * @var string
     */
    const AMPERE_PER_METER = 'A/m';
    /**
     * Mol por metro cubico.
     * @since 1.0.0
     * 
     * @var string
     */
    const MOL_PER_CUBIC_METER = 'mol/mÂ³';
    /**
     * candela por metro cuadrado.
     * @since 1.0.0
     * 
     * @var string
     */
    const CD_PER_SQUARE_METER = 'cd/mÂ²';
    /**
     * uno (indice de refraccion).
     * @since 1.0.0
     * 
     * @var string
     */
    const REFRACTION_INDEX = '1';
    /**
     * radio.
     * @since 1.0.0
     * 
     * @var string
     */
    const RADIUS = 'rad';
    /**
     * estereorradion.
     * @since 1.0.0
     * 
     * @var string
     */
    const STEREO = 'sr';
    /**
     * hertz.
     * @since 1.0.0
     * 
     * @var string
     */
    const HERTZ = 'hertz';
    /**
     * newton.
     * @since 1.0.0
     * 
     * @var string
     */
    const NEWTON = 'N';
    /**
     * pascal.
     * @since 1.0.0
     * 
     * @var string
     */
    const PASCAL = 'Pa';
    /**
     * Joule.
     * @since 1.0.0
     * 
     * @var string
     */
    const JOULE = 'J';
    /**
     * Watt.
     * @since 1.0.0
     * 
     * @var string
     */
    const WATT = 'W';
    /**
     * coulomb.
     * @since 1.0.0
     * 
     * @var string
     */
    const COULOMB = 'C';
    /**
     * volt | voltio.
     * @since 1.0.0
     * 
     * @var string
     */
    const VOLT = 'V';
    /**
     * farad.
     * @since 1.0.0
     * 
     * @var string
     */
    const FARAD = 'F';
    /**
     * ohm.
     * @since 1.0.0
     * 
     * @var string
     */
    const OHM = 'â„¦';
    /**
     * siemens.
     * @since 1.0.0
     * 
     * @var string
     */
    const SIEMENS = 'S';
    /**
     * weber.
     * @since 1.0.0
     * 
     * @var string
     */
    const WEBER = 'Wb';
    /**
     * tesla.
     * @since 1.0.0
     * 
     * @var string
     */
    const TESLA = 'T';
    /**
     * henry.
     * @since 1.0.0
     * 
     * @var string
     */
    const HENRY = 'H';
    /**
     * Celsius.
     * @since 1.0.0
     * 
     * @var string
     */
    const CELSIUS = 'Â°C';
    /**
     * lumen.
     * @since 1.0.0
     * 
     * @var string
     */
    const LUMEN = 'lm';
    /**
     * lux.
     * @since 1.0.0
     * 
     * @var string
     */
    const LUX = 'lx';
    /**
     * Becquerel.
     * @since 1.0.0
     * 
     * @var string
     */
    const BECQUEREL = 'Bq';
    /**
     * gray.
     * @since 1.0.0
     * 
     * @var string
     */
    const GRAY = 'Gy';
    /**
     * sievert.
     * @since 1.0.0
     * 
     * @var string
     */
    const SIEVERT = 'Sv';
    /**
     * katal.
     * @since 1.0.0
     * 
     * @var string
     */
    const KATAL = 'kat';
    /**
     * pascal segundo.
     * @since 1.0.0
     * 
     * @var string
     */
    const PASCAL_SECOND = 'PaÂ·s';
    /**
     * newton metro.
     * @since 1.0.0
     * 
     * @var string
     */
    const NEWTON_METER = 'NÂ·m';
    /**
     * newton por metro.
     * @since 1.0.0
     * 
     * @var string
     */
    const NEWTON_PER_METER = 'N/m';
    /**
     * radio por segundo
     * @since 1.0.0
     * 
     * @var string
     */
    const RADIUS_PER_SECOND = 'rad/s';
    /**
     * radio por segundo cuadrado
     * @since 1.0.0
     * 
     * @var string
     */
    const RADIUS_PER_SQUARE_SECOND = 'rad/sÂ²';
    /**
     * watt por metro cuadrado
     * @since 1.0.0
     * 
     * @var string
     */
    const WATT_PER_SQUARE_METER = 'W/mÂ²';
    /**
     * joule por kelvin
     * @since 1.0.0
     * 
     * @var string
     */
    const JOULE_PER_KELVIN = 'J/K';
    /**
     * gramo
     * @since 1.0.0
     * 
     * @var string
     */
    const GRAM = 'g';
    /**
     * kilometro
     * @since 1.0.0
     * 
     * @var string
     */
    const KILOMETER = 'Km';
    /**
     * Pulgada
     * @since 1.0.0
     * 
     * @var string
     */
    const INCH = 'ln';
    /**
     * centimetro
     * @since 1.0.0
     * 
     * @var string
     */
    const CENTIMETER = 'cm';
    /**
     * litro
     * @since 1.0.0
     * 
     * @var string
     */
    const LITER = 'L';
    /**
     * tonelada
     * @since 1.0.0
     * 
     * @var string
     */
    const TON = 't';
    /**
     * mililitro
     * @since 1.0.0
     * 
     * @var string
     */
    const MILILITER = 'mL';
    /**
     * milimetro
     * @since 1.0.0
     * 
     * @var string
     */
    const MILIMETER = 'mm';
    /**
     * onzas
     * @since 1.0.0
     * 
     * @var string
     */
    const OUNCE = 'Oz';
    /**
     * unidad
     * @since 1.0.0
     * 
     * @var string
     */
    const UNITY = 'Unid';
    /**
     * List of constant codes and descriptions.
     * @since 1.0.0
     *
     * @var array 
     */
    protected $constants = [
        'Sp'        => 'Professional Services',
        'Unid'      => 'Unity',
        's'         => 'Second',
        'mm'        => 'Milimeter',
        'm'         => 'Meter',
        'cm'        => 'Centimeter',
        'Km'        => 'Kilometer',
        'mÂ²'       => 'Square Meter',
        'mÂ³'       => 'Cubic Meter',
        'm/s'       => 'Meter per Second',
        'm/sÂ²'     => 'Meter per Square Second',
        'ln'        => 'Inch',
        'g'         => 'Gram',
        'kg'        => 'Kilogram',
        'kg/mÂ³'    => 'Kilogram per Cubic Meter',
        't'         => 'Ton',
        'Oz'        => 'Ounce',
        'mL'        => 'Mililiter',
        'L'         => 'Liter',
        'A'         => 'Ampere',
        'A/m'       => 'Ampere per Meter',
        'K'         => 'Kelvin',
        'mol'       => 'Mol',
        'mol/mÂ³'   => 'Mol per Cubic Meter',
        'cd'        => 'Candela',
        'cd/mÂ²'    => 'Candela per Square Meter',
        '1'         => 'One (Refraction Index)',
        '1/m'       => 'One per Meter',
        'rad'       => 'Radius',
        'rad/s'     => 'Radius per Second',
        'rad/sÂ²'   => 'Radius per Square Second',
        'sr'        => 'Estereorradio',
        'hertz'     => 'Hertz',
        'N'         => 'Newton',
        'NÂ·m'      => 'Newton Meter',
        'N/m'       => 'Newton per Meter',
        'Pa'        => 'Pascal',
        'PaÂ·s'     => 'Pascal Second',
        'J'         => 'Joule',
        'J/K'       => 'Joule per Kelvin',
        'W'         => 'Watt',
        'W/mÂ²'     => 'Watt per Square Meter',
        'C'         => 'Coulomb',
        'V'         => 'Volt',
        'F'         => 'Farad',
        'â„¦'       => 'Ohm',
        'S'         => 'Siemens',
        'Wb'        => 'Weber',
        'T'         => 'Tesla',
        'H'         => 'Henry',
        'Â°C'       => 'Celsius',
        'lm'        => 'Lumen',
        'lx'        => 'Lux',
        'Bq'        => 'Becquerel',
        'Gy'        => 'Gray',
        'Sv'        => 'Sievert',
        'kat'       => 'Katal',
    ];
    /**
     * Returns all constants available in class.
     * @since 1.0.0
     * 
     * @return array
     */
    protected static function __getConstants($class = null)
    {
        return parent::__getConstants(__CLASS__);
    }
}