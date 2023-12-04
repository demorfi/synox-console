<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Response;

use SynoxWebApi\Api\ResponsePrototype;

class PackagesFilter extends ResponsePrototype
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->response['id'];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->response['name'];
    }

    /**
     * @return array
     */
    public function getCases(): array
    {
        return $this->response['cases'];
    }
}