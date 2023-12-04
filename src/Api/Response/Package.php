<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Response;

use SynoxWebApi\Api\ResponsePrototype;
use SynoxWebApi\RequestException;

class Package extends ResponsePrototype
{
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
    public function getType(): string
    {
        return $this->response['type'];
    }

    /**
     * @return bool
     */
    public function hasEnabled(): bool
    {
        return $this->response['enabled'];
    }

    /**
     * @return array
     */
    public function getSettings(): array
    {
        return $this->response['settings'];
    }

    /**
     * @return string
     */
    public function getSubType(): string
    {
        return $this->response['subtype'];
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
    public function getDescription(): string
    {
        return $this->response['description'];
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->response['version'];
    }

    /**
     * @param bool $state
     * @return bool
     * @throws RequestException
     */
    public function changeState(bool $state): bool
    {
        return $this->api->packages()->changeState($this->getId(), $state);
    }

    /**
     * @param array $settings
     * @return bool
     * @throws RequestException
     */
    public function update(array $settings): bool
    {
        return $this->api->packages()->update($this->getId(), $settings);
    }
}