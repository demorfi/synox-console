<?php declare(strict_types=1);

namespace SynoxWebApi\Api;

use SynoxWebApi\Api;

class ResponsePrototype
{
    /**
     * @param Api   $api
     * @param array $response
     */
    public function __construct(protected Api $api, protected array $response)
    {
    }

    /**
     * @return array
     */
    public function response(): array
    {
        return $this->response;
    }
}