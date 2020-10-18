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

    private $value;

    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
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
    public function getValue()
    {
        return $this->value;
    }
}
