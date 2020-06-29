<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

class Suggester extends \Suilven\FreeTextSearch\Base\Suggester implements \Suilven\FreeTextSearch\Interfaces\Suggester
{
    /** @return array<string> */
    public function suggest(string $q, int $limit = 5): array
    {
        $result = 'unknown';
        switch ($q) {
            case 'webmister':
                $result = 'webmaster';

                break;
        }

        if (\sizeof($result) > $limit) {
            $result = \array_slice($result, 0, $limit);
        }

        return $result;
    }
}
