<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Request;

use SynoxWebApi\Api\{RequestPrototype, Response\Settings as SettingsResponse};
use SynoxWebApi\RequestException;

class Settings extends RequestPrototype
{
    /**
     * @return SettingsResponse
     * @throws RequestException
     */
    public function read(): SettingsResponse
    {
        return new SettingsResponse($this->api, $this->client->get('settings')->getJson());
    }

    /**
     * @param string          $type
     * @param string          $name
     * @param string|int|bool $value
     * @return bool
     * @throws RequestException
     */
    public function update(string $name, string|int|bool $value, string $type = 'app'): bool
    {
        $resource = 'settings/update/type/' . $type;
        return (bool)$this->client->put($resource, compact('name', 'value'))
            ->getJson('success');
    }
}