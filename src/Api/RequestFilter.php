<?php declare(strict_types=1);

namespace SynoxWebApi\Api;

use JsonSerializable;

class RequestFilter implements JsonSerializable
{
    /**
     * @var array
     */
    private array $packages = [];

    /**
     * @var array
     */
    private array $category = [];

    /**
     * @param string $name
     * @return string
     */
    public static function formatCategoryName(string $name): string
    {
        return ucfirst(strtolower($name));
    }

    /**
     * @param string $name
     * @return string
     */
    public static function formatPackageName(string $name): string
    {
        $name = str_starts_with($name, 'search-') ? substr($name, 7) : $name;
        return sprintf('search-%s', strtolower(strtr($name, ['-' => '', ' ' => ''])));
    }

    /**
     * @param string ...$category
     * @return static
     */
    public function addCategory(string ...$category): static
    {
        $category       = array_map(fn(string $name): string => static::formatCategoryName($name), $category);
        $this->category = [...$this->category, ...$category];
        return $this;
    }

    /**
     * @param string ...$packageId
     * @return static
     */
    public function addPackage(string ...$packageId): static
    {
        $packageId      = array_map(fn(string $name): string => static::formatPackageName($name), $packageId);
        $this->packages = [...$this->packages, ...$packageId];
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'packages' => $this->packages,
            'category' => $this->category
        ]);
    }
}