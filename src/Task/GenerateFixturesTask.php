<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Task;


use SilverStripe\Dev\BuildTask;
use Suilven\UKPostCodes\Factory\PostCodeFactory;

class GenerateFixturesTask extends BuildTask
{

    protected $title = 'Create random fixture data';

    protected $description = 'Generate plausible data for fixtures';

    private static $segment = 'genfix';

    protected $enabled = true;


    public function run($request)
    {
        $result = "Suilven\FreeTextSearch\Tests\Models\FlickrPhoto:\n";
        $factory = new PostCodeFactory();
        $lords = PostCodeFactory::get('NW8 8QN');
        $nearby = $lords->nearest();

        // nouns list from http://www.desiquintans.com/nounlist
        
        for($i=0; $i < 100; $i++) {

        }
    }
}
