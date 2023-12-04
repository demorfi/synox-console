<?php declare(strict_types=1);

namespace SynoxWebApi;

use SynoxWebApi\Api\Request\{Content, Journal, Packages, Search, Settings};

class Api
{
    /**
     * @param string   $entryPointUri
     * @param ?Request $client
     * @throws RequestException
     */
    public function __construct(private string $entryPointUri, private ?Request $client = null)
    {
        $this->client ??= new Request($this->entryPointUri);
    }

    /**
     * @return Request
     */
    public function client(): Request
    {
        return $this->client;
    }

    /**
     * @return Journal
     */
    public function journal(): Journal
    {
        return new Journal($this, $this->client);
    }

    /**
     * @return Settings
     */
    public function settings(): Settings
    {
        return new Settings($this, $this->client);
    }

    /**
     * @return Packages
     */
    public function packages(): Packages
    {
        return new Packages($this, $this->client);
    }

    /**
     * @return Search
     */
    public function search(): Search
    {
        return new Search($this, $this->client);
    }

    /**
     * @return Content
     */
    public function content(): Content
    {
        return new Content($this, $this->client);
    }
}