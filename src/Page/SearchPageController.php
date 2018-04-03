<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Page;

use SilverStripe\View\ArrayData;

class SearchPageController extends \PageController
{
    private static $allowed_actions = ['index'];

    public function index()
    {
        $searcher = new \Suilven\SphinxSearch\Service\Searcher();

        // @todo search indexes addition
        $q = $this->getRequest()->getVar('q');

        $results = $searcher->search($q);
        $results['Query'] = $q;

        return $results;
    }
}
