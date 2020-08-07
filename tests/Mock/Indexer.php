<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Mock;

use SilverStripe\ORM\DataObject;

// @phpcs:disable SlevomatCodingStandard.Functions.UnusedParameter.UnusedParameter
class Indexer extends \Suilven\FreeTextSearch\Base\Indexer implements \Suilven\FreeTextSearch\Interfaces\Indexer
{

    // @phpstan-ignore-next-line
    public function index(DataObject $dataObject): void
    {
        // Do nothing, this is for testing, dev/build flush=all fails first up without this
    }
}
