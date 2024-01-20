<?php declare(strict_types=1);

namespace SynoxWebApi;

use GuzzleHttp\{Client as HttpClient, Exception\GuzzleException};
use WebSocket\{Client as WebSocketClient, Exception as WebSocketException};

class Request
{
    /**
     * @var HttpClient
     */
    private HttpClient $client;

    /**
     * @param string $baseUri
     * @param array  $options
     * @throws RequestException
     */
    public function __construct(private string $baseUri, array $options = [])
    {
        if (!str_ends_with(rtrim($this->baseUri, '/'), '/api')) {
            throw new RequestException('URI must end with /api or /api/');
        }

        $this->client = new HttpClient([...$options, 'base_uri' => $this->baseUri]);
    }

    /**
     * @param callable $handler
     * @return Response
     * @throws RequestException
     */
    private function send(callable $handler): Response
    {
        try {
            return new Response($handler());
        } catch (GuzzleException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param string $resource
     * @param array $options
     * @return Response
     * @throws RequestException
     */
    public function get(string $resource, array $options = []): Response
    {
        return $this->send(fn() => $this->client->get($resource, $options));
    }

    /**
     * @param string $resource
     * @param array  $params
     * @return Response
     * @throws RequestException
     */
    public function post(string $resource, array $params = []): Response
    {
        return $this->send(fn() => $this->client->post($resource, ['json' => $params]));
    }

    /**
     * @param string $resource
     * @param array  $params
     * @return Response
     * @throws RequestException
     */
    public function put(string $resource, array $params = []): Response
    {
        return $this->send(fn() => $this->client->put($resource, ['json' => $params]));
    }

    /**
     * @param string $resource
     * @return Response
     * @throws RequestException
     */
    public function delete(string $resource): Response
    {
        return $this->send(fn() => $this->client->delete($resource));
    }

    /**
     * @param string $host
     * @param string $token
     * @return iterable|Response
     * @throws RequestException
     */
    public function socket(string $host, string $token): iterable|Response
    {
        $address = sprintf('%s/?token=%s', $host, $token);
        $context = stream_context_create(['ssl' => ['verify_peer' => false]]);
        $client  = new WebSocketClient($address, ['return_obj' => true, 'timeout' => 30, 'context' => $context]);

        try {
            while (true) {
                $response = new Response($client->receive());
                if ($response->isEmpty() || $response->getJson('finished')) {
                    break;
                }

                if ($response->inJson('payload')) {
                    yield $response;
                }
            }
        } catch (WebSocketException $e) {
            throw new RequestException($e->getMessage(), $e->getCode(), $e);
        } finally {
            $client->close();
        }
    }
}