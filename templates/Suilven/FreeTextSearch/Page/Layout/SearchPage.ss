<main role="main" class="container">
    <% if $SideBar %>
        <% include SideBar %>
    <% end_if %>
    <h1 class="mt-5">$Title</h1>
    <form action="$URL">
        <div class="col-xs-12">
            <div class="input-group">
                <input name="q" type="text" class="form-control" placeholder="Search..." value="$Query">
                <span class="input-group-btn">
                <button class="btn btn-secondary" type="button"><i class="fa fa-search"></i></button>
          </span>
            </div>
        </div>
    </form>

    <% if $NumberOfResults > 0 %>
        <p>$NumberOfResults results found in $Time seconds</p>

            <% loop $Records %>
                    <h3><a href="$Link">$ResultTitle</a></h3>
                    <div>$AbsoluteLink</div>
                    <% loop $Highlights %>
                     $Snippet.RAW
                    <% end_loop %>
                <hr/>
            <% end_loop %>


<% with $Pagination %>
        <% if $MoreThanOnePage %>
            <div class="pagination-container">
                <nav aria-label="Search pagination for '$Query'">
                    <ul class="pagination justify-content-center pt4 pb4">

                        <% if $PrevLink %>
                            <li class="page-item"><a class="page-link" href="$PrevLink"><% _t('CommentsInterface_ss.PREV','previous') %></a></li>
                        <% else %>
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1"><% _t('CommentsInterface_ss.PREV','previous') %></a>
                            </li>
                        <% end_if %>

                        <% if $Pages %>
                            <% loop $PaginationSummary(8) %>
                                <% if $CurrentBool %>
                                    <li class="page-item active">
                          <span class="page-link">
                            $PageNum
                              <span class="sr-only">(current)</span>
                          </span>
                                    </li>
                                <% else %>
                                    <% if $Link %>
                                        <li class="page-item"><a class="page-link" href="$Link">$PageNum</a></li>
                                    <% else %>
                                        <a class="page-link" href="#" tabindex="-1">&hellip;</a>
                                    <% end_if %>

                                <% end_if %>
                            <% end_loop %>
                        <% end_if %>

                        <% if $NextLink %>
                            <li class="page-item"><a class="page-link" href="$NextLink"><% _t('CommentsInterface_ss.NEXT','next') %></a></li>
                        <% else %>
                            <a class="page-link" href="#" tabindex="-1"><% _t('CommentsInterface_ss.NEXT','next') %></a>
                        <% end_if %>
                    </ul>
                </nav>

            </div>
        <% end_if %>
<% end_with %>



    <% else %>
        <p>Sorry, your search query did not return any results</p>
    <% end_if %>
</main>


