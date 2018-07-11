<div id="title">
    <h1>News</h1>
</div>

<div id="contentarticle">
<h3>Current page: {$current_page}</h3>


    {if $current_page gt 1}
        <a href="index.php?page=news&pageno={$current_page - 1}" class="nextbutton">Previous</a>
    {/if}


    {if $current_page lt $number_of_pages}
        <a href="index.php?page=news&pageno={$current_page + 1}" class="nextbutton">Next</a>
    {/if}



    {foreach from=$articles item=article}
    <div id="article">
        <div id="articletitle">
            <h2>{$article[0]}</h2>
        </div>

        <div id="articlecontent">
            <p>{$article[1]}</p>
        </div>

        <div id="articleimage">
            <img src="{$article[2]}" alt="image" class="imagenews" />
        </div>
    </div>
    {/foreach}




