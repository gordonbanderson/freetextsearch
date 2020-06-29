<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

use Suilven\FreeTextSearch\Base\SearcherBase;

class Searcher extends SearcherBase
{
    /** @return array<string,array<string,string>> */
    public function search(string $q): array
    {
        \error_log('***** MOCK SEARCH *****');

        $result = [];
        switch ($q) {
            case 'Fish':
                $result = [
                    'Title' => 'Fishing in New Zealand',
                ];
                $result['ResultsFound'] = 1;
                $result['AllFacets'] = [];
        }

        return $result;
    }
}
