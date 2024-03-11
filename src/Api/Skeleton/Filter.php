<?php declare(strict_types=1);

namespace SynoxWebApi\Api\Skeleton;

use SynoxWebApi\Api;
use JsonSerializable;

class Filter implements JsonSerializable
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
     * @param Api   $api
     * @param array $packages
     * @param array $category
     */
    public function __construct(protected Api $api, array $packages = [], array $category = [])
    {
        $this->addPackage(...$packages);
        $this->addCategory(...$category);
    }

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
     * @return array
     */
    public function getCategory(): array
    {
        return $this->category;
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
     * @return array
     */
    public function getPackages(): array
    {
        return $this->packages;
    }

    /**
     * @return array
     */
    public function split(): array
    {
        $packages = [];
        foreach ($this->packages as $packageId) {
            $packages[$packageId] = [
                'category' => $this->category
            ];
        }

        return $packages;
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