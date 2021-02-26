
    <? $id = (is_string($id)) ? $id : 'Не названо'?>

    <? echo '<li><a href="?id='.$id.'">'.$id.'</a></li>'?>

    <? if(isset($category['shilds'])){ ?>
        <ul>
            <?
            foreach ($category['shilds'] as $key => $shild) {
                echo "<ul><li>$key</li></ul>";
            }
            ?>
        </ul>
    <?php }?>


