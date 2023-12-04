<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Request;

use SynoxWebApi\Api\{RequestPrototype, Response\Journal as JournalResponse};
use SynoxWebApi\RequestException;

class Journal extends RequestPrototype
{
    /**
     * @return iterable|JournalResponse
     * @throws RequestException
     */
    public function read(): iterable|JournalResponse
    {
        foreach ($this->client->get('journal')->getJson() as $journal) {
            yield new JournalResponse($this->api, $journal);
        }
    }

    /**
     * @return int
     * @throws RequestException
     */
    public function size(): int
    {
        return (int)$this->client->get('journal/size')->getJson('size', 0);
    }

    /**
     * @return bool
     * @throws RequestException
     */
    public function remove(): bool
    {
        return (bool)$this->client->delete('journal')->getJson('success');
    }
}