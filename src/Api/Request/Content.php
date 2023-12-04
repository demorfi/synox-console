<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Request;

use SynoxWebApi\Api\{RequestFilter, RequestPrototype, Response\Content as ContentResponse};
use SynoxWebApi\RequestException;

class Content extends RequestPrototype
{
    /**
     * @param string $packageId
     * @param string $fetchId
     * @return ContentResponse
     * @throws RequestException
     */
    public function fetch(string $packageId, string $fetchId): ContentResponse
    {
        $resource = 'content/fetch/packageId/' . RequestFilter::formatPackageName($packageId);
        return new ContentResponse(
            $this->api,
            $this->client->post($resource, compact('fetchId'))->getJson()
        );
    }

    /**
     * @param string $name
     * @param string $typeId
     * @return string
     * @throws RequestException
     */
    public function downloadUrn(string $name, string $typeId): string
    {
        $resource = sprintf('content/download/name/%s/type/%s', $name, $typeId);
        return $this->client->get($resource, ['allow_redirects' => false])
            ->getResponse()->getHeaderLine('Location');
    }

    /**
     * @param string $name
     * @param string $typeId
     * @return string
     * @throws RequestException
     */
    public function download(string $name, string $typeId): string
    {
        $resource = sprintf('content/download/name/%s/type/%s', $name, $typeId);
        return $this->client->get($resource)->getBody();
    }
}