<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Container;

use SilverStripe\ORM\ArrayList;

/**
 * Class Facet
 * @package Suilven\FreeTextSearch\Container
 */
class Facet
{
    /** @var string */
    private $name;

    /** @var array<FacetCount> */
    private $facetCounts = [];

    /**
     * Facet constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }


    public function addFacetCount($key, $value)
    {
        $fc = new FacetCount($key, $value);
        $this->facetCounts[] = $fc;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getFacetCounts(): array
    {
        return $this->facetCounts;
    }


    public function asKeyValueArray()
    {
        $result = [];
        /** @var FacetCount $fc */
        foreach($this->facetCounts as $fc)
        {
            $result[$fc->getKey()] = $fc->getCount();
        }
        return $result;
    }
}
