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

    /** @var array<string,string|int|float|bool> */
    private $params = [];

    /** @var string */
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


    /** @param bool|float|int|string $key */
    public function isSelectedFacet($key): bool
    {
        // @TODO === $key on the RHS
        return isset($this->params[$this->facetInContext]) && $this->params[$this->facetInContext] === $key;
    }


    /** @param bool|float|int|string $facetKey */
    public function getDrillDownFacetLink(string $searchPageLink, $facetKey): string
    {
        $result = $searchPageLink . '?';
        $facetParams = \array_merge($this->params, [$this->facetInContext => $facetKey]);
        foreach ($facetParams as $key => $value) {
            $encodedValue = \is_string($value)
                ? \urlencode($value)
                : $value;
            $result .= $key .'=' . ($encodedValue) .'&';
        }

        $result = \rtrim($result, '&');

        return $result;
    }


    /** @param bool|float|int|string $facetKey */
    public function getClearFacetLink(string $searchPageLink, $facetKey): string
    {
        echo 'FK=' . $facetKey . '<br/>';
        $result = $searchPageLink . '?';
        foreach ($this->params as $key => $value) {
            if ($key === $facetKey) {
                continue;
            }
            $encodedValue = \is_string($value)
                ? \urlencode($value)
                : $value;
            $result .= $key .'=' . ($encodedValue) .'&';
        }

        $result = \rtrim($result, '&');

        return $result;
    }
}
