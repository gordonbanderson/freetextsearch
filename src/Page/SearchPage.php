<?php
/**
 * Created by PhpStorm.
 * User: gordon
 * Date: 25/3/2561
 * Time: 17:01 น.
 */
namespace Suilven\FreeTextSearch\Page;

class SearchPage extends \Page
{
    // @todo move to an extension
    // @todo do not hardwire to Sphinx
    public function search(\SilverStripe\Control\HTTPRequest $request)
    {


        return $this->renderWith('SearchResults', $results);


        /*
         * <% if $SearchResult.Matches %>
    <h2>Results for &quot;{$Query}&quot;</h2>
    <p>Displaying Page $SearchResult.Matches.CurrentPage of $SearchResult.Matches.TotalPages</p>
    <ol>
        <% loop $SearchResult.Matches %>
            <li>
                <h3><a href="$Link">$Title</a></h3>
                <p><% if $Abstract %>$Abstract.XML<% else %>$Content.ContextSummary<% end_if %></p>
            </li>
        <% end_loop %>
    </ol>
<% else %>
    <p>Sorry, your search query did not return any results.</p>
<% end_if %>
         */
    }
}
