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
        $result = [];
        switch ($q) {
            case 'sheep':
                $result = [
                    'Title' => 'Sheep in New Zealand',
                ];
        }

        return $result;
    }
}
