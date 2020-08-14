<?php declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Types;

use League\CLImate\CLImate;
use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use Suilven\FreeTextSearch\Factory\IndexCreatorFactory;

class FieldTypes
{
    public const BOOLEAN = 'Boolean';
    public const FLOAT = 'Float';
    public const FOREIGN_KEY = 'ForeignKey';
    public const INTEGER = 'Int';
    public const TIME = 'DBDatetime';

}
