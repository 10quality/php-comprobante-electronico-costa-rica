<?php

namespace ComprobanteElectronico\Enums;

use ComprobanteElectronico\Core\Enum;

/**
 * Document or reference code types enumerators/catalog.
 * XML: TipoDoc | Tipo de documento de referencia.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class DocType extends Enum
{
    /**
     * Factura electrónica
     * @since 1.0.0
     * 
     * @var string
     */
    const INVOICE = '01';
    /**
     * Nota de débito electrónica
     * @since 1.0.0
     * 
     * @var string
     */
    const DEBIT_NOTE = '02';
    /**
     * Nota de crédito electrónica
     * @since 1.0.0
     * 
     * @var string
     */
    const CREDIT_NOTA = '03';
    /**
     * Tiquete electrónico
     * @since 1.0.0
     * 
     * @var string
     */
    const TICKET = '04';
    /**
     * Nota de despacho
     * @since 1.0.0
     * 
     * @var string
     */
    const DISPATCH_NOTE = '05';
    /**
     * Contrato
     * @since 1.0.0
     * 
     * @var string
     */
    const CONTRACT = '06';
    /**
     * Procedimiento
     * @since 1.0.0
     * 
     * @var string
     */
    const PROCEDURE = '07';
    /**
     * Comprobante emitido en contigencia
     * @since 1.0.0
     * 
     * @var string
     */
    const CONTINGENCY_PROOF = '08';
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
        '01'    => 'Invoice',
        '02'    => 'Debit note',
        '03'    => 'Credit note',
        '04'    => 'Ticket',
        '05'    => 'Dispatch note',
        '06'    => 'Contract',
        '07'    => 'Procedure',
        '08'    => 'Proof issued in contingency',
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