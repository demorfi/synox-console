<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Response;

use SynoxWebApi\Api\ResponsePrototype;
use SynoxWebApi\RequestException;

class SearchItem extends ResponsePrototype
{
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->response['type'];
    }

    /**
     * @return string
     */
    public function getTypeId(): string
    {
        return $this->response['typeId'];
    }

    /**
     * @return string
     */
    public function getPackage(): string
    {
        return $this->response['package'];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->response['id'];
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->response['category'];
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->response['title'];
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->response['date'];
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->response['size'];
    }

    /**
     * @return string
     */
    public function getWeight(): string
    {
        return $this->response['weight'];
    }

    /**
     * @return string
     */
    public function getFetchId(): string
    {
        return $this->response['fetchId'];
    }

    /**
     * @return string
     */
    public function getPageUrl(): string
    {
        return $this->response['pageUrl'];
    }

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return $this->response['properties'];
    }

    /**
     * @return ?string
     */
    public function getDescription(): ?string
    {
        return $this->response['description'] ?? null;
    }

    /**
     * @return bool
     */
    public function isContent(): bool
    {
        return isset($this->response['content']);
    }

    /**
     * @return ?array
     */
    public function getContent(): ?Content
    {
        return isset($this->response['content']) ? new Content($this->api, (array)$this->response['content']) : null;
    }

    /**
     * @return string|int|null
     */
    public function getSeeds(): string|int|null
    {
        return $this->response['seeds'] ?? null;
    }

    /**
     * @return string|int|null
     */
    public function getPeers(): string|int|null
    {
        return $this->response['peers'] ?? null;
    }

    /**
     * @return Content
     * @throws RequestException
     */
    public function fetch(): Content
    {
        return $this->api->content()->fetch($this->getId(), $this->getFetchId());
    }
}