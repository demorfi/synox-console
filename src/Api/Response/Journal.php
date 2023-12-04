<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Response;

use SynoxWebApi\Api\ResponsePrototype;

class Journal extends ResponsePrototype
{
    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->response['message'];
    }

    /**
     * @return float
     */
    public function getTimestamp(): float
    {
        return $this->response['time'];
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->response['date'];
    }
}