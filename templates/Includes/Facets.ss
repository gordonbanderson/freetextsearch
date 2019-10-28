<% if $Records %>
<ul>
<% loop AllFacets %>
<li>$Name
<ul>
<% loop $Facets %>
<li><a href="{$Top.Link}?{$Params}">$Value ($Count)</a></li>
<% end_loop %>
</ul>
</li>
<% end_loop %>
</ul>
<% end_if %>

