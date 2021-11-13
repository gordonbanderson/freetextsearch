<?php

declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Container;

/**
 * Class Facet
 *
 * @package Suilven\FreeTextSearch\Container
 */
class Facet
{
    /** @var string */
    private $name;

    /** @var array<\Suilven\FreeTextSearch\Container\FacetCount> */
    private $facetCounts = [];

    /**
     * Facet constructor.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /** @param string|float|int|bool $key $key */
    public function addFacetCount($key, int $count): void
    {
        $fc = new FacetCount($key, $count);
        $this->facetCounts[] = $fc;
    }


    public function getName(): string
    {
        return $this->name;
    }


    /** @return array<\Suilven\FreeTextSearch\Container\FacetCount> */
    public function getFacetCounts(): array
    {
        return $this->facetCounts;
    }


    /** @return array<string|float|int|bool, int> */
    public function asKeyValueArray(): array
    {
        $result = [];
        /** @var \Suilven\FreeTextSearch\Container\FacetCount $fc */
        foreach ($this->facetCounts as $fc) {
            $result[$fc->getKey()] = $fc->getCount();
        }

        return $result;
    }
}
