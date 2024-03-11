<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Request;

use SynoxWebApi\Api\RequestPrototype;
use SynoxWebApi\Api\{Skeleton\Filter, Response\Profiles as ProfilesResponse};
use SynoxWebApi\RequestException;

class Profiles extends RequestPrototype
{
    /**
     * @return Filter
     */
    public function makeFilter(): Filter
    {
        return new Filter($this->api);
    }

    /**
     * @return iterable|ProfilesResponse
     * @throws RequestException
     */
    public function read(): iterable|ProfilesResponse
    {
        foreach ($this->client->get('profiles')->getJson() as $profile) {
            yield new ProfilesResponse($this->api, $profile);
        }
    }

    /**
     * @param ?string $profileId
     * @param Filter  ...$filters
     * @return ProfilesResponse
     * @throws RequestException
     */
    public function add(?string $profileId = null, Filter ...$filters): ProfilesResponse
    {
        $packages = [];
        foreach ($filters as $filter) {
            foreach ($filter->split() as $packageId => $values) {
                $packages[$packageId] = $values;
            }
        }

        return new ProfilesResponse(
            $this->api, $this->client->post('profiles/create/', ['id' => $profileId, 'packages' => $packages])
            ->getJson('state')
        );
    }

    /**
     * @param string $profileId
     * @param Filter ...$filters
     * @return ProfilesResponse
     * @throws RequestException
     */
    public function update(string $profileId, Filter ...$filters): ProfilesResponse
    {
        $packages = [];
        foreach ($filters as $filter) {
            foreach ($filter->split() as $packageId => $values) {
                $packages[$packageId] = $values;
            }
        }

        $resource = 'profiles/profile/id/' . $profileId;
        return new ProfilesResponse(
            $this->api, $this->client->put($resource, compact('packages'))
            ->getJson('state')
        );
    }

    /**
     * @param string $profileId
     * @return bool
     * @throws RequestException
     */
    public function remove(string $profileId): bool
    {
        $resource = 'profiles/profile/id/' . $profileId;
        return (bool)$this->client->delete($resource)->getJson('success');
    }
}