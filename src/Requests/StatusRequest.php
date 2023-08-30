<?php

namespace Picpay\Requests;

use GuzzleHttp\Psr7\Request;

/**
 * Class StatusRequest
 *
 * @package Picpay\Requests
 */
class StatusRequest extends BaseRequest
{
    /** @var string $referenceId */
    private $referenceId;

    /**
     * Constructs the base http request and set the reference ID.
     *
     * @param $picpayToken
     * @param $referenceId
     */
    public function __construct($picpayToken, $referenceId)
    {
        parent::__construct($picpayToken);

        $this->referenceId = $referenceId;
    }

    /**
     * Create the request to the desired endpoint
     * with Http method, endpoint, headers and body
     *
     * @return Request
     */
    protected function createRequest()
    {
        return new Request('GET', "payments/{$this->referenceId}/status");
    }
}
