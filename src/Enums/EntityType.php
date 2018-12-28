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
     * Type that identifies a foreigner.
     * @since 1.0.0
     *
     * @var string
     */
    const FOREIGNER = '02';
    /**
     * Type that identifies a business.
     * @since 1.0.0
     *
     * @var string
     */
    const BUSINESS = '03';
    /**
     * List of constant codes and descriptions.
     * @since 1.0.0
     *
     * @var array 
     */
    protected $constants = [
        '01'    => 'Individual Person',
        '02'    => 'Foreigner Person',
        '03'    => 'Business Entity',
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