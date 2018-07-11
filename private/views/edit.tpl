

    <form action="index.php" method="post" >
        <input type='hidden' name="article_id" value="{$article_id}">
        <h1>EDIT ID {$article_id}</h1>
        <textarea name="title" id="" cols="30" rows="1" >{$articles[1]}</textarea><br><br>
        <textarea name="content" id="" cols="30" rows="10">{$articles[2]}</textarea><br><br>
        <input type="submit" name="submit_edit">
    </form>

