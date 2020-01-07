<?php

namespace ComprobanteElectronico\Traits;

use Exception;
use ComprobanteElectronico\Enums\PaymentType;

/**
 * Trait used for XML models with payments.
 * 
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
trait XmlWithPaymentsTrait
{
    /**
     * Adds a payment type to the array.
     * @since 1.0.0
     * 
     * @param \ComprobanteElectronico\Data\Item $item Item to add.
     * 
     * @return this for chaining
     */
    public function payment($type)
    {
        if ($this->paymentTypes === null || !is_array($this->paymentTypes))
            $this->paymentTypes = [];
        if (count($this->paymentTypes) > 4)
            throw new Exception(sprintf(__i18n('Cannot add more than %d payment types.'), 4));
        $this->paymentTypes[] = $type;
        return $this;
    }
    /**
     * Runs validation on all payments.
     * @since 1.0.0
     */
    protected function arePaymentsValid()
    {
        if ($this->paymentTypes === null || ! is_array($this->paymentTypes) || count($this->paymentTypes) === 0)
            throw new Exception(sprintf(__i18n('%s is missing.'), __i18n('Payment type')));
        // Validate items
        for ($i = 0; $i < count($this->paymentTypes); ++$i) {
            if (!PaymentType::exists($this->paymentTypes[$i]))
                throw new Exception(sprintf(__i18n('%s \'%s\' is unknown.'), __i18n('Payment type'), $this->paymentTypes[$i]));
        }
    }
}