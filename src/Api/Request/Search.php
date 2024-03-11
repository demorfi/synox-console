<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Request;

use SynoxWebApi\Api\{RequestPrototype, Skeleton\Filter};
use SynoxWebApi\Api\Response\{Search as SearchResponse, SearchItem as SearchItemResponse};
use SynoxWebApi\RequestException;

class Search extends RequestPrototype
{
    /**
     * @var ?Filter
     */
    private ?Filter $filters = null;

    /**
     * @return Filter
     */
    public function makeFilters(): Filter
    {
        return $this->filters = new Filter($this->api);
    }

    /**
     * @param string  $query
     * @param ?string $profile
     * @return SearchResponse
     * @throws RequestException
     */
    public function create(string $query, ?string $profile = null): SearchResponse
    {
        return new SearchResponse(
            $this->api,
            $this->client->post('search/start', ['query' => $query, 'profile' => $profile, 'filters' => $this->filters ?? []])
                ->getJson()
        );
    }

    /**
     * @param SearchResponse $search
     * @return iterable|SearchItemResponse
     * @throws RequestException
     */
    public function run(SearchResponse $search): iterable|SearchItemResponse
    {
        foreach ($this->client->socket($search->getWsHost(), $search->getToken()) as $response) {
            yield new SearchItemResponse($this->api, $response->getJson('payload'));
        }
    }
}