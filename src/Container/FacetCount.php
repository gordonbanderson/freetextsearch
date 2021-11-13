<?php

declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Container;

/**
 * Class Facet
 *
 * @package Suilven\FreeTextSearch\Container
 */
class FacetCount
{
    /** @var string|float|int|bool */
    private $key;

    /** @var int */
    private $count;


    /**
     * FacetCount constructor.
     *
     * @param string|float|int|bool $key
     */
    public function __construct($key, int $count)
    {
        $this->key = $key;
        $this->count = $count;
    }


    /** @return string|float|int|bool */
    public function getKey()
    {
        return $this->key;
    }


    public function getCount(): int
    {
        return $this->count;
    }
}
