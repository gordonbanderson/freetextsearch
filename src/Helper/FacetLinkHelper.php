<?php declare(strict_types = 1);

/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */

namespace Suilven\FreeTextSearch\Helper;

use SilverStripe\Control\Controller;
use SilverStripe\ORM\DataObject;
use Suilven\FreeTextSearch\Factory\IndexablePayloadMutatorFactory;
use Suilven\FreeTextSearch\Indexes;

class FacetLinkHelper
{
    /** @var string */
    private $query;

    private $params = [];

    private $facetInContext = '';

    /**
     * @param string $facetInContext
     */
    public function setFacetInContext(string $facetInContext): void
    {
        $this->facetInContext = $facetInContext;
    }

    public function __construct()
    {
        $controller = Controller::curr();
        $params = $controller->getRequest()->getVars();
        $this->query = isset($params['q']) ? $params['q'] : '';
        $this->params = $params;
    }


    public function isSelectedFacet($key)
    {
        return $this->params[$this->facetInContext] == $key;
    }


    public function getDrillDownFacetLink($link, $facetKey)
    {
        $result = $link . '?';
        foreach($this->params as $key => $value)
        {
            $result .= $key .'=' . ($value) .'&';
        }

        $result = rtrim($result, '&');

        return $result;
    }


    /**
     * @param string $link
     * @param $facetKey
     * @return string
     */
    public function getClearFacetLink($link, $facetKey)
    {
        $result = $link . '?';
        foreach($this->params as $key => $value)
        {
            if ($key != $facetKey) {
                $result .= $key .'=' . ($value) .'&';
            }
        }

        $result = rtrim($result, '&');

        return $result;
    }
}
