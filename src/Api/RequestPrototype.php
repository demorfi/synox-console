<?php declare(strict_types=1);

namespace SynoxWebApi\Api;

use SynoxWebApi\{Api, Request};

class RequestPrototype
{
    /**
     * @param Api     $api
     * @param Request $client
     */
    public function __construct(protected Api $api, protected Request $client)
    {
    }
}