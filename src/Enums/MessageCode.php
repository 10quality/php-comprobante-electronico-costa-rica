<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Message code enumerators/catalog.
 * XML: Mensaje | Codigo del mensaje de respuesta.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class MessageCode extends Enum
{
    /**
     * Aceptado
     * @since 1.0.0
     * 
     * @var string
     */
    const ACCEPTED = 1;
    /**
     * Aceptado Parcialmente
     * @since 1.0.0
     * 
     * @var string
     */
    const ACCEPTED_PARTIALLY = 2;
    /**
     * Rechazado
     * @since 1.0.0
     * 
     * @var string
     */
    const REJECTED = 3;
    /**
     * List of constant codes and descriptions.
     * @since 1.0.0
     *
     * @var array 
     */
    protected $constants = [
        1   => 'Accepted',
        2   => 'Partially Accepted',
        3   => 'Rejected',
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