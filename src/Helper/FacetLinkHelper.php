<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\Control\Controller;

class FacetLinkHelper
{
    /** @var string */
    private $query;

    private $params = [];

    private $facetInContext = '';

    public function __construct()
    {
        $controller = Controller::curr();
        $params = $controller->getRequest()->getVars();
        $this->query = isset($params['q'])
            ? $params['q']
            : '';
        $this->params = $params;
    }


    public function setFacetInContext(string $facetInContext): void
    {
        $this->facetInContext = $facetInContext;
    }


    public function isSelectedFacet($key)
    {
        return isset($this->params[$this->facetInContext]) && $this->params[$this->facetInContext] === $key;
    }


    public function getDrillDownFacetLink($link, $facetKey)
    {
        $result = $link . '?';
        $facetParams = \array_merge($this->params, [$this->facetInContext => $facetKey]);
        foreach ($facetParams as $key => $value) {
            $result .= $key .'=' . ($value) .'&';
        }

        $result = \rtrim($result, '&');

        return $result;
    }


    public function getClearFacetLink(string $link, $facetKey): string
    {
        echo 'FK=' . $facetKey . '<br/>';
        $result = $link . '?';
        foreach ($this->params as $key => $value) {
            if ($key === $facetKey) {
                continue;
            }

            $result .= $key .'=' . ($value) .'&';
        }

        $result = \rtrim($result, '&');

        return $result;
    }
}
