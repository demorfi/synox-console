<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Skeleton;

use SynoxWebApi\{Api, RequestException};

class Setting
{
    /**
     * @param Api    $api
     * @param string $type
     * @param string $name
     * @param mixed  $value
     */
    public function __construct(protected Api $api, protected string $type, protected string $name, protected mixed $value)
    {
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function value(): mixed
    {
        return $this->value;
    }

    /**
     * @param string|int|bool $value
     * @return bool
     * @throws RequestException
     */
    public function update(string|int|bool $value): bool
    {
        return $this->api->settings()->update($this->name, $value, $this->type);
    }
}