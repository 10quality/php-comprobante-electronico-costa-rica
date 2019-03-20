<?php

use ComprobanteElectronico\Data\Xml\Invoice;
use ComprobanteElectronico\Data\Item;
use ComprobanteElectronico\Data\Entity;
use ComprobanteElectronico\Enums\EntityType;
use ComprobanteElectronico\Enums\SaleType;
use ComprobanteElectronico\Enums\PaymentType;

/**
 * Test invoice model.
 *
 * @author Cami M <info@10quality.com>
 * @license MIT
 * @package ComprobanteElectronico
 * @version 1.0.0
 */
class InvoiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test invoice properties.
     * @since 1.0.0
     */
    public function testProperties()
    {
        // Prepare
        // ---
        $entity = new Entity(['rawId' => '1-1250-0368', 'type' => EntityType::INDIVIDUAL]);
        // ---
        $invoice = new Invoice;
        $invoice->key = 'KEY';
        $invoice->id = 501;
        $invoice->date = '2018-12-01 22:15';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CC;
        $invoice->issuer = $entity;
        $invoice->receiver = $entity;
        $invoice->creditTerms = 'month';
        $invoice->currency = 'USD';
        $invoice->exchangeRate = 541;
        $invoice->totalTaxedServices = 9.99;
        $invoice->totalExemptServices = 9.99;
        $invoice->totalTaxedGoods = 9.99;
        $invoice->totalExemptGoods = 9.99;
        $invoice->totalTaxed = 9.99;
        $invoice->totalExempt = 9.99;
        $invoice->totalSales = 9.99;
        $invoice->totalDiscount = 9.99;
        $invoice->totalNetSales = 9.99;
        $invoice->totalTaxes = 9.99;
        $invoice->total = 110.99;
        $expected = '{"key":"KEY","id":501,"date":"2018-12-01 22:15","issuer":{"id":112500368,"type":"01"},'
            .'"receiver":{"id":112500368,"type":"01"},"saleType":"01","paymentType":"02","creditTerms":"month",'
            .'"currency":"USD","exchangeRate":541,"totalTaxedServices":9.99,"totalExemptServices":9.99,'
            .'"totalTaxedGoods":9.99,"totalExemptGoods":9.99,"totalTaxed":9.99,"totalExempt":9.99,"totalSales":9.99,'
            .'"totalDiscount":9.99,"totalNetSales":9.99,"totalTaxes":9.99,"total":110.99,"items":[]}';
        // Assert
        $this->assertEquals($expected, (string)$invoice);
    }
    /**
     * Test method.
     * @since 1.0.0
     */
    public function testAddItemMethod()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->key = 'KEY';
        $invoice->id = 501;
        $invoice->date = '2018-12-01 22:15';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CC;
        // Exec
        $invoice->add(new Item(['quantity' => 1, 'price' => 9.99]));
        $expected = '{"key":"KEY","id":501,"date":"2018-12-01 22:15","saleType":"01","paymentType":"02",'
            .'"items":[{"quantity":1,"price":9.99}]}';
        // Assert
        $this->assertEquals($expected, (string)$invoice);
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Currency is missing.
     */
    public function testCurrencyMissingException()
    {
        // Prepare
        $invoice = new Invoice;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Sale type is missing.
     */
    public function testSaleTypeMissingException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown sale type 'A999'.
     */
    public function testSaleTypeInvalidValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = 'A999';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Credit terms is required if sale type is set for 'CREDIT'.
     */
    public function testCreditTermsMissingException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CREDIT;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Credit terms has more than 10 characters.
     */
    public function testCreditTermsMaxLengthException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CREDIT;
        $invoice->creditTerms = 'morethantenchars';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Payment type is missing.
     */
    public function testPaymentTypeMissingException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown payment type 'A999'.
     */
    public function testPaymentTypeInvalidValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = 'A999';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Exchange rate is not numeric.
     */
    public function testExchangeRateDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->exchangeRate = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Exchange rate should be lower than 9999999999999.99999.
     */
    public function testExchangeRateMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->exchangeRate = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total taxed services is not numeric.
     */
    public function testTotalTaxedServicesDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalTaxedServices = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total taxed services should be lower than 9999999999999.99999.
     */
    public function testTotalTaxedServicesMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalTaxedServices = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total exempt services is not numeric.
     */
    public function testTotalExemptServicesDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalExemptServices = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total exempt services should be lower than 9999999999999.99999.
     */
    public function testTotalExemptServicesMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalExemptServices = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total taxed goods is not numeric.
     */
    public function testTotalTaxedGoodsDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalTaxedGoods = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total taxed goods should be lower than 9999999999999.99999.
     */
    public function testTotalTaxedGoodsMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalTaxedGoods = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total exempt goods is not numeric.
     */
    public function testTotalExemptGoodsDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalExemptGoods = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total exempt goods should be lower than 9999999999999.99999.
     */
    public function testTotalExemptGoodsMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalExemptGoods = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total taxed is not numeric.
     */
    public function testTotalTaxedDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalTaxed = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total taxed should be lower than 9999999999999.99999.
     */
    public function testTotalTaxedMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalTaxed = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total exempt is not numeric.
     */
    public function testTotalExemptDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalExempt = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total exempt should be lower than 9999999999999.99999.
     */
    public function testTotalExemptMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalExempt = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total sales is not numeric.
     */
    public function testTotalSalesDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalSales = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total sales should be lower than 9999999999999.99999.
     */
    public function testTotalSalesMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalSales = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total discount is not numeric.
     */
    public function testTotalDiscountDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalDiscount = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total discount should be lower than 9999999999999.99999.
     */
    public function testTotalDiscountMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalDiscount = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total net sales is not numeric.
     */
    public function testTotalNetSalesDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalNetSales = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total net sales should be lower than 9999999999999.99999.
     */
    public function testTotalNetSalesMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalNetSales = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total in taxes is not numeric.
     */
    public function testTotalTaxesDataTypeException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalTaxes = 'col';
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Total in taxes should be lower than 9999999999999.99999.
     */
    public function testTotalTaxesMaxValueException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->totalTaxes = 19999999999999.99999;
        // Assert
        $invoice->isValid();
    }
    /**
     * Test exception.
     * @since 1.0.0
     *
     * @expectedException        Exception
     * @expectedExceptionMessage Unknown code type 'YO'.
     */
    public function testItemException()
    {
        // Prepare
        $invoice = new Invoice;
        $invoice->currency = 'USD';
        $invoice->saleType = SaleType::CASH;
        $invoice->paymentType = PaymentType::CASH;
        $invoice->add(new Item(['codeType' => 'YO']));
        // Assert
        $invoice->isValid();
    }
}