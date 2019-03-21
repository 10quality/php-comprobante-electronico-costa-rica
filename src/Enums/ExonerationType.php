<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Exoneration type enumerators/catalog.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ExonerationType extends Enum
{
    /**
     * Compras Autorizadas
     * @since 1.0.0
     * 
     * @var string
     */
    const AUTHORIZED_PURCHASES = '01';
    /**
     * Ventas exentas a diplomáticos
     * @since 1.0.0
     * 
     * @var string
     */
    const DIPLOMATIC_EXEMPT_SALES = '02';
    /**
     * Orden de compra (instituciones publicas y otros organismos)
     * @since 1.0.0
     * 
     * @var string
     */
    const GOV_ORDER = '03';
    /**
     * Exenciones Direccion General de Hacienda
     * @since 1.0.0
     * 
     * @var string
     */
    const HACIENDA_EXEMPTS = '04';
    /**
     * Zonas Francas
     * @since 1.0.0
     * 
     * @var string
     */
    const FREE_TRADE_ZONES = '05';
    /**
     * Otro.
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
        '01'    => 'Authorized Purchases',
        '02'    => 'Diplomatic Exempt Sales',
        '03'    => 'Order (Goverment entities and other orgs)',
        '04'    => 'Hacienda Exempts',
        '05'    => 'Free Trade Zones',
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