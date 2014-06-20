<?php
$result=$this->pagination(3);
$max_pages=$result[0];
$result=$result[1];
?>

<div class="right"><a href="<?php $_SERVER['PHP_SELF']?>index.php?exit">Выход</a> </div>
<div class="new_container2">
    <?php for($i=0;$i<count($result);$i++):?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span><strong><?=$result[$i]['theme'];?></strong></span>
                <span id="center"><?=$result[$i]['mail'];?></span>
                <span class="right"><?=@date('d-m-Y / H:i:s', $result[$i]['date']);?></span>
            </div>
            <div class="panel-body"><div class="panel-body container_new"><?=$result[$i]['msg'];?></div></div>
            <?php if($result[$i]['file']):?>
                <div class="panel-footer"><a href="?file=<?=$result[$i]['file'];?>">скачать</a></div>
            <?php endif;?>
        </div>
    <?php endfor?>
</div>

<?php if($max_pages>1):?>
    <ul class="pagination" id="center">
        <li><a href="<?php $_SERVER['PHP_SELF'];?>?page=1">&laquo;</a></li>
             <?php for($i=1;$i<=$max_pages;$i++):?>
                 <li><a href=<?php $_SERVER['PHP_SELF']?>index.php?page=<?=$i;?>><?=$i;?></a></li>
             <?php endfor;?>
        <li><a href="<?php $_SERVER['PHP_SELF'];?>?page=<?=$max_pages;?>">&raquo;</a></li>
    </ul>
<?php endif;?>






