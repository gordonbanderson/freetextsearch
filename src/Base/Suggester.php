<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Base;

use Suilven\FreeTextSearch\Container\SuggesterResults;

abstract class Suggester implements \Suilven\FreeTextSearch\Interfaces\Suggester
{
    /** @var string */
    protected $index;

    abstract public function suggest(string $q, int $limit = 5): SuggesterResults;


    public function setIndex(string $newIndex): void
    {
        $this->index = $newIndex;
    }
}
