<?php

namespace Picpay\Requests;

use GuzzleHttp\Psr7\Request;
use Picpay\Entities\Payment;

/**
 * Class PaymentRequest
 *
 * @package Picpay\Request
 */
class PaymentRequest extends BaseRequest
{
    /** @var Payment $payment */
    private $payment;

    /**
     * Constructs the base http request and set the payment data.
     *
     * @param string $picpayToken
     * @param Payment $payment
     * @throws \Exception
     */
    public function __construct($picpayToken, Payment $payment)
    {
        parent::__construct($picpayToken);

        $this->payment = $payment;
    }

    /**
     * Create the request to the desired endpoint
     * with Http method, endpoint, headers and body
     *
     * @return Request
     */
    protected function createRequest()
    {
        return new Request('POST', 'payments', [], json_encode($this->payment));
    }
}
