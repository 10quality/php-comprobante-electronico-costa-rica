<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Entity types enumerators/catalog.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class EntityType extends Enum
{
    /**
     * Type that identifies an individual person.
     * @since 1.0.0
     *
     * @var string
     */
    const INDIVIDUAL = '01';
    /**
     * Type that identifies a business.
     * @since 1.0.0
     *
     * @var string
     */
    const JURIDICAL = '02';
    /**
     * Type that identifies a business.
     * @since 1.0.0
     *
     * @var string
     */
    const DIMEX = '03';
    /**
     * Type that identifies a business.
     * @since 1.0.0
     *
     * @var string
     */
    const NITE = '04';
    /**
     * List of constant codes and descriptions.
     * @since 1.0.0
     *
     * @var array 
     */
    protected $constants = [
        '01'    => 'Individual Identification',
        '02'    => 'Juridical Identification',
        '03'    => 'DIMEX',
        '04'    => 'NITE',
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