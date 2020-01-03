<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Tax rate type enumerators/catalog.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class TaxRateType extends Enum
{
    /**
     * Tarifa 0% (Exento)
     * @since 1.0.0
     * 
     * @var string
     */
    const EXEMPT = '01';
    /**
     * Tarifa reducida 1%
     * @since 1.0.0
     * 
     * @var string
     */
    const REDUCED1 = '02';
    /**
     * Tarifa reducida 2%
     * @since 1.0.0
     * 
     * @var string
     */
    const REDUCED2 = '03';
    /**
     * Tarifa reducida 4%
     * @since 1.0.0
     * 
     * @var string
     */
    const REDUCED4 = '04';
    /**
     * Transitorio 0%
     * @since 1.0.0
     * 
     * @var string
     */
    const TRANSIENT0 = '05';
    /**
     * Transitorio 4%
     * @since 1.0.0
     * 
     * @var string
     */
    const TRANSIENT4 = '06';
    /**
     * Transitorio 8%
     * @since 1.0.0
     * 
     * @var string
     */
    const TRANSIENT8 = '07';
    /**
     * Tarifa general 13%
     * @since 1.0.0
     * 
     * @var string
     */
    const GENERAL = '08';
    /**
     * List of constant codes and descriptions.
     * @since 1.0.0
     *
     * @var array 
     */
    protected $constants = [
        '01'    => '0% (Exempt)',
        '02'    => 'Reduced Rate 1%',
        '03'    => 'Reduced Rate 2%',
        '04'    => 'Reduced Rate 4%',
        '05'    => 'Transitorio 0%',
        '06'    => 'Transitorio 4%',
        '07'    => 'Transitorio 8%',
        '08'    => 'General 13%',
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