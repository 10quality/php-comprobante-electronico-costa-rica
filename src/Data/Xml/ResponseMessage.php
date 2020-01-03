<?php

namespace ComprobanteElectronico\Data\Xml;

use Exception;
use ComprobanteElectronico\Data\Entity;
use ComprobanteElectronico\Abstracts\Xml as Model;
use ComprobanteElectronico\Enums\MessageCode;
use ComprobanteElectronico\Traits\XmlWithItemsTrait;

/**
 * ResponseMessage (Mensaje Receptor) XML model.
 * 
 * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/MensajeReceptor_V4.2.pdf
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class ResponseMessage extends Model
{
    use XmlWithItemsTrait;
    /**
     * Indicates the root element.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $element = 'MensajeHacienda';
    /**
     * Indicates the schema used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schema = 'https://tribunet.hacienda.go.cr/docs/esquemas/2017/v4.2/mensajeReceptor';
    /**
     * Indicates the schema location used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $schemaLocation = 'https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/MensajeReceptor_4.2.xsd';
    /**
     * Indicates the version used.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $version = '4.2';
    /**
     * Model properties.
     * @since 1.0.0
     *
     * @var array
     */
    protected $properties = [
        'key',
        'issuer',
        'receiver',
        'date',
        'code',
        'description',
        'totalTaxes',
        'total',
        'number',
    ];
    /**
     * Returns flag indicating if model is valid for casting.
     * @since 1.0.0
     * 
     * @throws Exception
     *
     * @return bool
     */
    public function isValid()
    {
        if ($this->key === null || strlen($this->key) === 0)
            throw new Exception(__i18n('Key is missing.'));
        if (!MessageCode::exists($this->code))
            throw new Exception(sprintf(__i18n('Unknown message code \'%s\'.'), $this->code));
        if ($this->issuer === null || !is_a($this->issuer, Entity::class))
            throw new Exception(__i18n('Issuer must be an instance of class \'Entity\'.'));
        if ($this->receiver === null || !is_a($this->receiver, Entity::class))
            throw new Exception(__i18n('Receiver must be an instance of class \'Entity\'.'));
        if ($this->totalTaxes && !is_numeric($this->totalTaxes))
            throw new Exception(__i18n('Total in taxes is not numeric.'));
        if (!is_numeric($this->total))
            throw new Exception(__i18n('Total is not numeric.'));
        if ($this->number === null || strlen($this->number) === 0)
            throw new Exception(__i18n('Number is missing.'));
        return parent::isValid();
    }
    /**
     * Returns model as its expected XML string.
     * @since 1.0.0
     * 
     * @link https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.2/FacturaElectronica_V.4.2.xsd
     *
     * @return SimpleXMLElement
     */
    public function toXml()
    {
        $xml = parent::toXml();
        $xml->addChild('Clave', $this->key);
        $xml->addChild('NumeroCedulaEmisor', $this->issuer->id);
        $xml->addChild('FechaEmisionDoc', __cecrDate($this->date ? $this->date : time()));
        $xml->addChild('Mensaje', $this->code);
        if ($this->description)
            $xml->addChild(
                'DetalleMensaje',
                strlen($this->description) > 80 ? substr($this->description, 0, 80) : $this->description
            );
        if ($this->totalTaxes)
            $xml->addChild('MontoTotalImpuesto', $this->totalTaxes);
        $xml->addChild('TotalFactura', $this->total);
        $xml->addChild('NumeroCedulaReceptor', $this->receiver->id);
        $xml->addChild('NumeroConsecutivoReceptor', $this->number);
        return $xml;
    }
    /**
     * Returns the document type or code used to generate the sequential number.
     * @since 1.0.0
     * 
     * @var string
     */
    protected $doctype = '05';
}