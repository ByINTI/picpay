<?php

namespace Picpay\Requests;

use GuzzleHttp\Psr7\Request;

/**
 * Class CancellationRequest
 * @package Picpay\Request
 */
class CancellationRequest extends BaseRequest
{
    /** @var string $referenceId */
    private $referenceId;

    /** @var string $authorizationId */
    private $authorizationId;

    /** @var string $picpayToken */
    private $picpayToken;

    /**
     * Constructs the base http request and set
     * the reference and authorization IDs.
     *
     * @param string $picpayToken
     * @param string $referenceId
     * @param string $authorizationId
     */
    public function __construct($picpayToken, $referenceId, $authorizationId)
    {
        parent::__construct($picpayToken);

        $this->referenceId = $referenceId;
        $this->authorizationId = $authorizationId;
    }

    /**
     * Create the request to the cancellations endpoint
     * setting POST method, no added headers and the
     * authorizationId as body
     *
     * @return Request
     */
    public function createRequest()
    {
        return new Request(
            'POST',
            "payments/{$this->referenceId}/cancellations",
            [],
            json_encode(['authorizationId' => $this->authorizationId])
        );
    }
}
