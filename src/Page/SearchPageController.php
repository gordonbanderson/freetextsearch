<?php

declare(strict_types = 1);

namespace Suilven\FreeTextSearch\Page;

use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\ArrayData;
use Suilven\FreeTextSearch\Container\SearchResults;
use Suilven\FreeTextSearch\Factory\SearcherFactory;
use Suilven\FreeTextSearch\Helper\FacetLinkHelper;
use Suilven\FreeTextSearch\Indexes;

// @phpcs:disable SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingTraversableTypeHintSpecification

/**
 * Class SearchPageController
 *
 * @package Suilven\FreeTextSearch\Page
 * @property int $ID Page ID
 * @property int $PageSize the number of results to show on each page
 */

class SearchPageController extends \PageController
{
    /** @var array<string,string|float|int|bool> */
    protected static $selected = [];

    /** @var array<string,int> */
    // * @phpstan-ignore-next-line
    private $tagCloud = [];

    /** @var array<string> */
    // * @phpstan-ignore-next-line
    private static $allowed_actions = ['index', 'similar'];


    public function similar(): \SilverStripe\View\ViewableData_Customised
    {
         /** @var \Suilven\FreeTextSearch\Page\SearchPage $model */
        $model = SearchPage::get_by_id(SearchPage::class, $this->ID);

        $indexes = new Indexes();
        $index = $indexes->getIndex($model->IndexToSearch);

        /** @var string $clazz */
        $clazz = $index->getClass();

        $dataObjectID = $this->getRequest()->param('ID');
        $dataObjectID = \intval($dataObjectID);


        $objectInContext = DataObject::get_by_id($clazz, $dataObjectID);

        $factory = new SearcherFactory();
        $searcher = $factory->getSearcher();
        $searcher->setIndexName($index->getName());
        $this->paginateSearcher($searcher);

        $results = $searcher->searchForSimilar($objectInContext);

        // tweak results set for rendering purposes, we do not want all the OR constructs
        $results->setQuery('');
        $results->setSimilarTo($objectInContext);

        return $this->renderSearchResults($model, $results);
    }


    public function index(): \SilverStripe\View\ViewableData_Customised
    {
        // @todo search indexes addition
        $q = $this->getRequest()->getVar('q');

        $this->selected = $this->getRequest()->getVars();

        /** @var \Suilven\FreeTextSearch\Page\SearchPage $model */
        $model = SearchPage::get_by_id(SearchPage::class, $this->ID);

        $results = new SearchResults();

        if (isset($q) || $model->PageLandingMode !== 'DoNothing' || isset($this->selected['q'])) {
            $results = $this->performSearchIncludingFacets($model, $q);

            if ($model->PageLandingMode === 'TagCloud') {
                $this->buildTagCloud();
            }
        }

        unset($this->selected['q']);
        unset($this->selected['start']);
        unset($this->selected['flush']);

        return $this->renderSearchResults($model, $results);
    }


    public function performSearchIncludingFacets(SearchPage $searchPage, ?string $q): SearchResults
    {
        $factory = new SearcherFactory();

        /** @var \Suilven\FreeTextSearch\Interfaces\Searcher $searcher */
        $searcher = $factory->getSearcher();
        $searcher->setFilters($this->selected);
        $searcher->setIndexName($searchPage->IndexToSearch);

        $facets = $searchPage->getFacetFields();
        $hasManyFields = $searchPage->getHasManyFields();

        // @todo ShutterSpeed breaks, no idea why

        $searcher->setFacettedTokens($facets);
        $searcher->setHasManyTokens($hasManyFields);
        $this->paginateSearcher($searcher);

        return $searcher->search($q);
    }


    private function buildTagCloud(): void
    {
        /*

        $facetted = isset($results['AllFacets']);



        $targetFacet = new ArrayList();
        if (isset($model->ShowTagCloudFor)) {
            // get the tag cloud from calculated facets, but if not calculated, ie the arrive on the page case,
            // calculate them
            if ($facetted) {
                $facets = $results['AllFacets'];
            } else {
                $proxyResults = $this->performSearchIncludingFacets($selected, $model, $q);
                $facets = $proxyResults['AllFacets'];
            }

            foreach ($facets as $facet) {
                $name = $facet->getField('Name');
                if ($name === $model->ShowTagCloudFor) {
                    $targetFacet = $facet->getField('Facets');

                    break;
                }
            }

            $facetArray = $targetFacet->toArray();
            $minSize = 10;
            $maxSize = 40;
            $maxCount = 0;
            foreach ($facetArray as $tag) {
                $count = $tag['Count'];
                $maxCount = $count > $maxCount
                    ? $count
                    : $maxCount;
            }

            $tagCloud = new ArrayList();
            foreach ($facetArray as $tag) {
                $size = $minSize + ($maxSize - $minSize) * $tag['Count'] / $maxCount;
                $size = \round($size);
                $row = new ArrayData([
                    'Name' => $tag['Value'],
                    'Size' => $size,
                    'Params' => $tag['Params'],
                ]);
                $tagCloud->push($row);
            }

            $results['TagCloud'] = $tagCloud;
        }


        //for($i = 3; $i < 40; $i++) {
           // echo "li.tag{$i} { font-size: {$i}px;};\n";
        //}

        */
    }


    /** @throws \Exception */
    private function renderSearchResults(
        SearchPage $model,
        SearchResults $results
    ): \SilverStripe\View\ViewableData_Customised {
        $indexes = new Indexes();
        $index = $indexes->getIndex($model->IndexToSearch);

        $hasManyFieldsDetails = $index->getHasManyFields();
        $hasManyFieldsNames = \array_keys($hasManyFieldsDetails);

        /** @var string $clazz */
        $clazz = $index->getClass();

        $templateName = 'Suilven/FreeTextSearch/' . \str_replace('\\', '/', $clazz);
        $splits = \explode('/', $templateName);
        $last = \array_pop($splits);
        $templateName = \implode('/', $splits) . '/Includes/' . $last;


        $records = $results->getRecords();

        $newRecords = new ArrayList();
        foreach ($records as $record) {
            $highsList = new ArrayList();
            $highlightsArray = $record->Highlights;

            if (isset($highlightsArray['Title'])) {
                $record->ResultTitle = $highlightsArray['Title'][0];
                unset($highlightsArray['Title']);
            }

            $record->HighlightedLink = $record->Link;
            if (isset($highlightsArray['Link']) && \count($highlightsArray['Link']) > 0) {
                $record->HighlightedLink = $highlightsArray['Link'][0];
                unset($highlightsArray['Link']);
            }

            // this simply repeats the title most times
            unset($highlightsArray['MenuTitle']);

            $keys = \is_null($highlightsArray)
                ? []
                : \array_keys($highlightsArray);
            foreach ($keys as $highlightedField) {
                foreach ($highlightsArray[$highlightedField] as $highlightsForField) {
                    $do = new DataObject();
                    // @phpstan-ignore-next-line
                    $do->Snippet = '...' . $highlightsForField . '...';

                    $highsList->push($do);
                }
            }

            $record->Highlights = $highsList;

            $html = $this->renderWith(
                [
                    $templateName,
                    'Suilven/FreeTextSearch/SilverStripe/CMS/Model/Includes/SiteTree',
                ],
                [
                    'Record' => $record,
                    'SimilarLink' => $this->Link('similar') . '/' . $record->ID,
                ]
            );
            $record->HTML = $html;
            $newRecords->push($record);
        }

        $paginatedList = new PaginatedList($records);
        $paginatedList->setLimitItems(false);
        $paginatedList->setPageLength($results->getPageSize());
        $paginatedList->setTotalItems($results->getTotaNumberOfResults());
        $paginatedList->setCurrentPage($results->getPage());


        $facets = $results->getFacets();
        $selectedFacetNames = \array_keys($this->selected);
        $displayFacets = new ArrayList();

        $helper = new FacetLinkHelper();


        /** @var \Suilven\FreeTextSearch\Container\Facet $facet */
        foreach ($facets as $facet) {
            $displayFacet = new DataObject();
            $facetName= $facet->getName();

            /** @phpstan-ignore-next-line */
            $displayFacet->Name = $facetName;
            $helper->setFacetInContext($facetName);
            $isHasManyFacet = \in_array($facetName, $hasManyFieldsNames, true);
            $isSelectedFacet = \in_array($facetName, $selectedFacetNames, true);


            $counts = new ArrayList();
            /** @var \Suilven\FreeTextSearch\Container\FacetCount $facetCount */
            foreach ($facet->getFacetCounts() as $facetCount) {
                // @todo Make this an object
                $count = new DataObject();
                $key = $facetCount->getKey();

                /** @phpstan-ignore-next-line */
                $count->Key = $key;

                /** @phpstan-ignore-next-line */
                $count->Count = $facetCount->getCount();
                $link = $helper->isSelectedFacet($key) ? null: $helper->getDrillDownFacetLink(
                    $model->Link(),
                    $count->Key
                );

                $clearFacetLink = $helper->isSelectedFacet($key)
                    ? $helper->getClearFacetLink($model->Link(), $facet->getName())
                    : null;

                // @phpstan-ignore-next-line
                $count->Link = $link;

                // @phpstan-ignore-next-line
                $count->ClearFacetLink = $clearFacetLink;

                // @phpstan-ignore-next-line
                $count->IsSelected = $isSelectedFacet;

                // @phpstan-ignore-next-line
                $count->KeySelected = $helper->isSelectedFacet($key);


                // decide whether or not to show this facet count
                if ($isHasManyFacet) {
                    if ($isSelectedFacet && !\is_null($count->ClearFacetLink)) {
                        $counts->push($count);
                    } elseif (!$isSelectedFacet && \is_null($count->ClearFacetLink)) {
                        $counts->push($count);
                    }
                } else {
                    // token facets
                    $counts->push($count);
                }
            }

            // @phpstan-ignore-next-line
            $displayFacet->FacetCounts = $counts;

            $displayFacets->push($displayFacet);
        }

        return $this->customise(new ArrayData([
            'NumberOfResults' => $results->getTotaNumberOfResults(),
            'Query' => $results->getQuery(),
            'Records' => $newRecords,
            'Page' => $results->getPage(),
            'PageSize' => $results->getPageSize(),
            'Pages' => $results->getTotalPages(),
            'Suggestions' => new ArrayList($results->getSuggestions()),
            'Time' => $results->getTime(),
            'Pagination' => $paginatedList,
            'SimilarTo' => $results->getSimilarTo(),
            'Facets' => $displayFacets,
        ]));
    }


    private function paginateSearcher(\Suilven\FreeTextSearch\Interfaces\Searcher &$searcher): void
    {
        $searcher->setPageSize($this->PageSize);
        $start = $this->getRequest()->getVar('start');


        // page 1 is the first page
        $page = isset($start)
            ? \ceil($start / $this->PageSize) + 1
            : 1;

        $page = \intval($page);
        $searcher->setPage($page);
    }
}
