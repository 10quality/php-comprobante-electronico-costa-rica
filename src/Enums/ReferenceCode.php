<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Document or reference action codes enumerators/catalog.
 * XML: InformacionReferencia>Codigo | Codigo de referencia.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ReferenceCode extends Enum
{
    /**
     * Anula documento de referencia
     * @since 1.0.0
     * 
     * @var string
     */
    const CANCEL = '01';
    /**
     * Corrige texto de documento de referencia
     * @since 1.0.0
     * 
     * @var string
     */
    const UPDATE_TEXT = '02';
    /**
     * Corrige monto
     * @since 1.0.0
     * 
     * @var string
     */
    const UPDATE_AMOUNT = '03';
    /**
     * Referencia a otro documento
     * @since 1.0.0
     * 
     * @var string
     */
    const REFERENCE = '04';
    /**
     * Sustituye comprobante provisional por contigencia
     * @since 1.0.0
     * 
     * @var string
     */
    const REPLACE_CONTINGENCY = '05';
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
        '01'    => 'Cancel reference',
        '02'    => 'Update reference text',
        '03'    => 'Update reference amount',
        '04'    => 'Reference another document',
        '05'    => 'Replace temp voucer for contingency',
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