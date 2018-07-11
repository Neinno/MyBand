<div id="title">
    <h1>CMS</h1>
</div>

<div id="cmscontent">
    <form method="post" action="index.php">
        <label><input type="submit" name="logoutButton" value="Logout"><br></label>
    </form>


    <label><a href="index.php?page=add" class="addButton">Add</a></label>


    {foreach from=$articles item=article}
        <div id="cms">
            <table>
                <tr>
                    <td>{$article[0]}</td>
                    <td>{$article[1]}</td>
                    <td><form method="post" action="index.php">
                            <input type="hidden" name="delete_function_id" value="{$article[0]}">
                            <input type="submit" name="delete_submit" value="Delete">
                        </form>
                    </td>
                    <td>
                        <label><a href="index.php?page=edit&article_id={$article[0]}" class="editButton">Edit</a></label>
                    </td>
                </tr>
            </table>
        </div>
    {/foreach}
</div>

