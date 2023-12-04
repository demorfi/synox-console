<?php declare(strict_types=1);

namespace SynoxWebApi;

use GuzzleHttp\Utils;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Exception;
use Throwable;

class RequestException extends Exception
{
    /**
     * @inheritdoc
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        if ($previous instanceof GuzzleRequestException) {
            $content = $previous->getResponse()->getBody()->getContents();
            if (!empty($content)) {
                $message = Utils::jsonDecode($content)?->error;
            }
        }

        parent::__construct($message, $code, $previous);
    }
}