<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Interfaces;

use Suilven\FreeTextSearch\Container\SuggesterResults;

interface Suggester
{

    /**
     * @param string $q the text term to query
     * @param int $limit the number of results to return at a max, default is 5
     * @return \Suilven\FreeTextSearch\Container\SuggesterResults suggested terms based on the $q parameter
     */
    public function suggest(string $q, int $limit = 5): SuggesterResults;


    /** @param string $newIndex the name of the index */
    public function setIndex(string $newIndex): void;
}
