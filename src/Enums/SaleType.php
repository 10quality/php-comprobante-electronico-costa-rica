<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Sale types enumerators/catalog.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class SaleType extends Enum
{
    /**
     * Sale type. Condicion de venta. CONTADO.
     * @since 1.0.0
     * 
     * @var string
     */
    const CASH = '01';
    /**
     * Sale type. Condicion de venta. CREDITO.
     * @since 1.0.0
     * 
     * @var string
     */
    const CREDIT = '02';
    /**
     * Sale type. Condicion de venta. CONSIGNACION.
     * @since 1.0.0
     * 
     * @var string
     */
    const CONSIG = '03';
    /**
     * Sale type. Condicion de venta. APARTADO.
     * @since 1.0.0
     * 
     * @var string
     */
    const APART = '04';
    /**
     * Sale type. Condicion de venta. ARRENDAMIENTO OPCION COMPRA.
     * @since 1.0.0
     * 
     * @var string
     */
    const PURCHASE_LEASE = '05';
    /**
     * Sale type. Condicion de venta. ARRENDAMIENTO EN FUNCION FINANCIERA.
     * @since 1.0.0
     * 
     * @var string
     */
    const FINANCE_LEASE = '06';
    /**
     * Sale type. Condicion de venta. OTRO.
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
        '02'    => 'Credit',
        '03'    => 'Consignment',
        '04'    => 'Apart',
        '05'    => 'Purchase lease',
        '06'    => 'Finance lease',
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