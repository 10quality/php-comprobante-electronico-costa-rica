<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Payment types enumerators/catalog.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class PaymentType extends Enum
{
    /**
     * Payment type. Metodo de pago. EFECTIVO.
     * @since 1.0.0
     * 
     * @var string
     */
    const CASH = '01';
    /**
     * Payment type. Metodo de pago. TARJETA.
     * @since 1.0.0
     * 
     * @var string
     */
    const CC = '02';
    /**
     * Payment type. Metodo de pago. CHEQUE.
     * @since 1.0.0
     * 
     * @var string
     */
    const CHECK = '03';
    /**
     * Payment type. Metodo de pago. DEPOSITO BANCARIO.
     * @since 1.0.0
     * 
     * @var string
     */
    const BANK = '04';
    /**
     * Payment type. Metodo de pago. RECAUDO 3ROS.
     * @since 1.0.0
     * 
     * @var string
     */
    const COLLECTION = '05';
    /**
     * Payment type. Metodo de pago. OTROS.
     * @since 1.0.0
     * 
     * @var string
     */
    const OTHER = '99';
    /**
     * List of constant codes and descriptions.
     * @since 1.0.0
     *
     * @var array 
     */
    protected $constants = [
        '01'    => 'Cash',
        '02'    => 'Credit Card',
        '03'    => 'Check',
        '04'    => 'Bank Deposit',
        '05'    => '3rd Party Collection',
        '99'    => 'Other',
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