<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Request;

use SynoxWebApi\Api\{RequestPrototype, RequestFilter};
use SynoxWebApi\Api\Response\{Search as SearchResponse, SearchItem as SearchItemResponse};
use SynoxWebApi\RequestException;

class Search extends RequestPrototype
{
    /**
     * @var ?RequestFilter
     */
    private ?RequestFilter $filters = null;

    /**
     * @return RequestFilter
     */
    public function makeFilters(): RequestFilter
    {
        return $this->filters = new RequestFilter;
    }

    /**
     * @param string $query
     * @return SearchResponse
     * @throws RequestException
     */
    public function create(string $query): SearchResponse
    {
        return new SearchResponse(
            $this->api,
            $this->client->post('search/start', ['query' => $query, 'filters' => $this->filters ?? []])
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