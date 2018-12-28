<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Product code types enumerators/catalog.
 * XML: CodigoType | Tipo de codigo de producto o servicio
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class CodeType extends Enum
{
    /**
     * Product code type. CODIGO DEL VENDEDOR.
     * @since 1.0.0
     * 
     * @var string
     */
    const VENDOR = '01';
    /**
     * Product code type. CODIGO DEL COMPRADOR.
     * @since 1.0.0
     * 
     * @var string
     */
    const CUSTOMER = '02';
    /**
     * Product code type. CODIGO ASIGNADO POR LA INDUSTRIA.
     * @since 1.0.0
     * 
     * @var string
     */
    const INDUSTRY = '03';
    /**
     * Product code type. CODIGO DE USO INTERNO.
     * @since 1.0.0
     * 
     * @var string
     */
    const INTERNAL = '04';
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
        '01'    => 'Vendor code',
        '02'    => 'Customer code',
        '03'    => 'Industry code',
        '04'    => 'Internal usage code',
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