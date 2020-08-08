<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 24/3/2561
 * Time: 20:36 น.
 */

namespace Suilven\FreeTextSearch\Tests\Models;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;

class FlickrPhoto extends DataObject implements TestOnly
{
    private static $table_name = 'TestFTSFlickrPhoto';

    private static $db = [
        'Title' => 'Varchar(255)',
        'Description' => 'HTMLText',
        'TakenAt' => 'Datetime',


        'Orientation' => 'Int',
        'PostCode' => 'Varchar(20)',
        'FlickrPlaceID' => 'Varchar(255)',
        'Aperture' => 'Float',
        'ShutterSpeed' => 'Varchar',
        'FocalLength35mm' => 'Int',
        'ISO' => 'Int',

        'AspectRatio' => 'Float',

        // geo
        'Lat' => 'Decimal(18,15)',
        'Lon' => 'Decimal(18,15)',
    ];

    private static $belongs_many_many = array(
        'FlickrSets' => FlickrSet::class
    );

    private static $many_many = array(
        'FlickrTags' => FlickrTag::class
    );
}
