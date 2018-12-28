<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Tax type enumerators/catalog.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class TaxType extends Enum
{
    /**
     * Impuesto General sobre las ventas
     * @since 1.0.0
     * 
     * @var string
     */
    const IVA = '01';
    /**
     * Impuesto Selectivo de Consumo
     * @since 1.0.0
     * 
     * @var string
     */
    const SELECTIVE = '02';
    /**
     * Impuesto Unico a los combustivos
     * @since 1.0.0
     * 
     * @var string
     */
    const FUEL = '03';
    /**
     * Impuesto especifico de bebidas alcoholicas
     * @since 1.0.0
     * 
     * @var string
     */
    const ALCOHOLIC_BEVERAGES = '04';
    /**
     * impuesto especifico sobre las bebidas envasadas sin contenido alcoholico y jabones de tocador
     * @since 1.0.0
     * 
     * @var string
     */
    const PACKAGED = '05';
    /**
     * impuesto a los productos de tabaco
     * @since 1.0.0
     * 
     * @var string
     */
    const TOBACCO = '06';
    /**
     * servicios
     * @since 1.0.0
     * 
     * @var string
     */
    const SERVICES = '07';
    /**
     * Impuesto General a las Ventas Diplomaticos
     * @since 1.0.0
     * 
     * @var string
     */
    const DIPLOMATIC_SALES = '08';
    /**
     * Impuesto General sobre Ventas compras autorizadas
     * @since 1.0.0
     * 
     * @var string
     */
    const AUTH_PURCHASES = '09';
    /**
     * Impuesto General sobre las ventas instituciones publicas y otros organismos
     * @since 1.0.0
     * 
     * @var string
     */
    const ORGANIZATIONS = '10';
    /**
     * Impuesto Selectivo de consumo compras autorizadas
     * @since 1.0.0
     * 
     * @var string
     */
    const SELECTIVE_AUTH_PURCHASES = '11';
    /**
     * Impuesto Especifico al Cemento
     * @since 1.0.0
     * 
     * @var string
     */
    const CEMENT = '12';
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
        '01'    => 'Sales Tax',
        '02'    => 'Selective Uptake Tax',
        '03'    => 'Fuel Tax',
        '04'    => 'Alcoholic Beverages Tax',
        '05'    => 'Non Alcoholic Packaged Beverages and Healthcare Soaps',
        '06'    => 'Tobacco Products Tax',
        '07'    => 'Services Tax',
        '08'    => 'Diplomatic Sales Tax',
        '09'    => 'Authorized Purchases Sales Tax',
        '10'    => 'Goberment Entities and Other Organizations Sales Tax',
        '11'    => 'Selective Uptake on Authorized Purchases Tax',
        '12'    => 'Cement Tax',
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