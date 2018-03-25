<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Page;

class SearchPageController extends \PageController
{
    private static $allowed_actions = ['search'];

    public function search()
    {
        $searcher = new \Suilven\SphinxSearch\Service\Searcher();

        // @todo search indexes addition
        $q = $this->getRequest()->getVar('q');
        $results = $searcher->search($q);
        return [
            'Title' => 'My Team Name',
            'Records' => $results->Records
        ];
    }
}
