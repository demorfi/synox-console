<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Response;

use SynoxWebApi\Api\ResponsePrototype;
use SynoxWebApi\RequestException;

class Search extends ResponsePrototype
{
    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->response['token'];
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->response['host'];
    }

    /**
     * @return string
     */
    public function getWsHost(): string
    {
        return str_replace('websocket', 'ws', $this->getHost());
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->response['limit'];
    }

    /**
     * @return iterable|SearchItem
     * @throws RequestException
     */
    public function run(): iterable|SearchItem
    {
        return $this->api->search()->run($this);
    }
}