<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Request;

use SynoxWebApi\Api\RequestPrototype;
use SynoxWebApi\Api\Response\{PackagesFilter as PackagesFilterResponse, Package as PackageResponse};
use SynoxWebApi\RequestException;

class Packages extends RequestPrototype
{
    /**
     * @return iterable|PackageResponse
     * @throws RequestException
     */
    public function read(): iterable|PackageResponse
    {
        foreach ($this->client->get('packages')->getJson() as $package) {
            yield new PackageResponse($this->api, $package);
        }
    }

    /**
     * @return iterable|PackagesFilterResponse
     * @throws RequestException
     */
    public function filters(): iterable|PackagesFilterResponse
    {
        foreach ($this->client->get('packages/filters')->getJson() as $filter) {
            yield new PackagesFilterResponse($this->api, $filter);
        }
    }

    /**
     * @param string $packageId
     * @param bool   $state
     * @return bool
     * @throws RequestException
     */
    public function changeState(string $packageId, bool $state): bool
    {
        $resource = 'packages/changeState/id/' . $packageId;
        return (bool)$this->client->put($resource, ['enabled' => $state])->getJson('success');
    }

    /**
     * @param string $packageId
     * @param array  $settings
     * @return bool
     * @throws RequestException
     */
    public function update(string $packageId, array $settings): bool
    {
        $resource = 'packages/updateSettings/id/' . $packageId;
        return (bool)$this->client->put($resource, compact('settings'))->getJson('success');
    }
}