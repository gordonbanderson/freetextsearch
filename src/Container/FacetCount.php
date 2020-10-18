<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Container;

use SilverStripe\ORM\ArrayList;

/**
 * Class Facet
 * @package Suilven\FreeTextSearch\Container
 */
class FacetCount
{
    private $key;

    private $count;

    public function __construct($key, $count)
    {
        $this->key = $key;
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }
}
