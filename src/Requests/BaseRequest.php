<?php

namespace Picpay\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Picpay\Exceptions\PicpayRequestException;
use Psr\Http\Message\StreamInterface;

/**
 * Class BaseRequest
 *
 * @package Picpay\Request
 */
abstract class BaseRequest
{
    const API_URL = 'https://appws.picpay.com/ecommerce/public/';

    /** @var Client $client */
    protected $client;

    /**
     * BaseRequest constructor.
     *
     * @param null $picpayToken
     * @param null $sellerToken
     * @param string $apiUrl
     */
    public function __construct($picpayToken = null, $sellerToken = null, $apiUrl = self::API_URL)
    {
        $this->client = new Client([
            'base_uri' => $apiUrl,
            'headers' => [
                'Accept-Encoding' => 'gzip, deflate',
                'Content-Type' => 'application/json',
                'x-picpay-token' => $picpayToken,
                'x-seller-token' => $sellerToken,
            ],
        ]);
    }

    /**
     * Send the request and returns the response body decoded
     * or throw an specific exception with errors messages
     * if the return code is !== 200
     *
     * @return StreamInterface
     * @throws PicpayRequestException
     * @throws GuzzleException
     */
    public function sendRequest()
    {
        try {
            $response = $this->client->send($this->createRequest());

            return json_decode($response->getBody());
        } catch (RequestException $e) {
            $code = -1;
            $message = 'An error ocurred while connecting to PicPay';
            $errors = [];

            if ($response = $e->getResponse()) {
                $code = $response->getStatusCode();

                $body = json_decode($response->getBody());

                $message = isset($body->message) ? $body->message : $message;

                $errors = isset($body->errors) ? $body->errors : $errors;
            }

            throw new PicpayRequestException($message, $code, $e, $errors);
        }
    }

    /**
     * Create the request to the desired endpoint
     * with Http method, endpoint, headers and body
     *
     * @return Request
     */
    abstract protected function createRequest();
}
