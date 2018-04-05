<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Page;

use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\ArrayData;

class SearchPageController extends \PageController
{
    private static $allowed_actions = ['index'];

    private static $db = [
        'PageSize' => 'Int'
    ];

    private static $defaults = [
        'PageSize' => 10
    ];

    public function index()
    {

        // @todo search indexes addition
        $q = $this->getRequest()->getVar('q');

        /** @var array $selected */
        $selected = $this->getRequest()->getVars();

        unset($selected['start']);

        echo 'SELECTED: ' . print_r($selected, 1);

        unset($selected['start']);
        $results = [];

        if (!empty($selected)) {
            $searcher = new \Suilven\SphinxSearch\Service\Searcher();
            $searcher->setFilters($selected);
            $searcher->setIndex('flickr');
            $searcher->setFacettedTokens(['shutterspeed', 'iso', 'aperture']);

            if ($this->PageSize == 0) {
                $this->PageSize=10;
            }
            $searcher->setPageSize($this->PageSize);
            $start = $this->getRequest()->getVar('start');

            error_log('START:' . $start);

            // page 1 is the first page
            $page = empty($start) ? 1 : ($start/$this->PageSize) + 1;
            $searcher->setPage($page);
            $results = $searcher->search($q);
            $results['Query'] = $q;
        }

        $results['ShowResult'] = 'FlickrResult';
        $results['CleanedLink'] = $this->Link();
        return $results;

        // cannot get this override to work :(  Layout does not yield to parent Page template
        // $data = new ArrayData($results);
        // return $data->renderWith(['Layout/FlickrSearch', '\Page']);
    }
}
