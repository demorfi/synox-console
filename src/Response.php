<?php declare(strict_types=1);

namespace SynoxWebApi;

use GuzzleHttp\Utils;
use WebSocket\Message\Message as WebSocketMessage;
use Psr\Http\Message\ResponseInterface;

class Response
{
    /**
     * @var array
     */
    protected array $json = [];

    /**
     * @var string
     */
    protected string $body = '';

    /**
     * @param WebSocketMessage|ResponseInterface $response
     */
    public function __construct(protected WebSocketMessage|ResponseInterface $response)
    {
        $this->body = $this->response instanceof ResponseInterface
            ? $this->response->getBody()->getContents()
            : $this->response->getContent();

        if ($this->response instanceof WebSocketMessage
            || str_starts_with($response->getHeaderLine('Content-Type'), 'application/json')) {
            $this->json = (array)Utils::jsonDecode($this->body, true);
        }
    }

    /**
     * @return WebSocketMessage|ResponseInterface
     */
    public function getResponse(): WebSocketMessage|ResponseInterface
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param ?string $key
     * @param ?mixed  $default
     * @return mixed
     */
    public function getJson(?string $key = null, mixed $default = null): mixed
    {
        return empty($key) ? $this->json : $this->json[$key] ?? $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function inJson(string $key): bool
    {
        return isset($this->json[$key]);
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->body);
    }
}