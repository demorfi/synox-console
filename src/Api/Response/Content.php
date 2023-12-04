<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Response;

use SynoxWebApi\Api\ResponsePrototype;
use SynoxWebApi\RequestException;

class Content extends ResponsePrototype
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
    public function getExtension(): string
    {
        return $this->response['extension'];
    }

    /**
     * @return string
     */
    public function getTypeId(): string
    {
        return $this->response['typeId'];
    }

    /**
     * @return ?string
     */
    public function getContent(): ?string
    {
        return $this->response['content'] ?? null;
    }

    /**
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->response['available'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->response['name'];
    }

    /**
     * @return string
     */
    public function getBaseName(): string
    {
        return $this->response['baseName'];
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->response['path'];
    }

    /**
     * @return string
     * @throws RequestException
     */
    public function downloadUrn(): string
    {
        return $this->api->content()->downloadUrn($this->getName(), $this->getType());
    }

    /**
     * @return string
     * @throws RequestException
     */
    public function download(): string
    {
        return $this->api->content()->download($this->getName(), $this->getType());
    }
}