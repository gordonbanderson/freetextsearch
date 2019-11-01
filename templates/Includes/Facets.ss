<% if $Records %>
<ul>
<% loop AllFacets %>
<li>$Name
<ul>
<% loop $Facets %>
<li><% if $Selected %>$Value ($Count) &nbsp;
<a href="{$Top.Link}?{$Params}"><% include Utils/FontAwesomeIcon Icon='close' %></a>
<% else %><a href="{$Top.Link}?{$Params}">$Value ($Count)</a><% end_if %></li>
<% end_loop %>
</ul>
</li>
<% end_loop %>
</ul>
<% end_if %>

