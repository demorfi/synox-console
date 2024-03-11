<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Response;

use SynoxWebApi\Api\ResponsePrototype;
use SynoxWebApi\Api\Skeleton\Filter;
use SynoxWebApi\RequestException;

class Profiles extends ResponsePrototype
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->response['id'];
    }

    /**
     * @return Filter
     */
    public function makeFilter(): Filter
    {
        return new Filter($this->api);
    }

    /**
     * @return iterable|Filter
     */
    public function getFilters(): iterable|Filter
    {
        foreach ($this->response['values'] as $packageId => $filters) {
            yield new Filter($this->api, [$packageId], $filters['category'] ?? []);
        }
    }

    /**
     * @param Filter ...$filters
     * @return static
     * @throws RequestException
     */
    public function update(Filter ...$filters): static
    {
        return $this->api->profiles()->update($this->getId(), ...$filters);
    }
}