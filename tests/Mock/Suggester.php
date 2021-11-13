<?php

declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

use Suilven\FreeTextSearch\Container\SuggesterResults;

class Suggester extends \Suilven\FreeTextSearch\Base\Suggester implements \Suilven\FreeTextSearch\Interfaces\Suggester
{
    /** @return array<string> */
    public function suggest(string $q, int $limit = 5): SuggesterResults
    {
        $result = new SuggesterResults();
        switch ($q) {
            case 'webmister':
                $result->setResults(['webmaster']);

                break;
        }

        $suggestions = $result->getResults();
        if (\sizeof($suggestions) > $limit) {
            $suggestions = \array_slice($result, 0, $limit);
            $result->setResults($suggestions);
        }

        $result->setQuery($q);
        $result->setLimit($limit);
        $result->setIndex('unit_test_index');

        return $result;
    }
}
