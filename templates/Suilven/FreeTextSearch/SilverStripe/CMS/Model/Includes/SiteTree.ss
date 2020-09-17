<div class="searchResult">
    <p class="url">$Record.HighlightedLink.RAW</p>
    <h3><a href="$Link">$Record.ResultTitle.RAW</a></h3>
    <% loop $Record.Highlights %>
     $Snippet.RAW
    <% end_loop %>
    <p class="links"><a href="$SimilarLink">Similar</a></p>
</div>
