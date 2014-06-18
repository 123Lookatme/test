

<?php
//максимальный вывоб блоков на странице
$limit=3;
//максимальное кол-во страниц
$max_pages=ceil($this->num_rows/$limit);
//выбираем страницу, чтоб узнать офсет
$page=$_GET['page'];
$list=$page-1;
$offset=$list*$limit;

//если page=-1 итд
if($page<=0)$page=1;
//если page=100500 итд
if($page>$max_pages) $page=$max_pages;
//чтоб выборка начиналась с 0 эл-та
if($page==1)$offset=0;
if($page==2)$offset=$limit;
//Забираем нужные блоки

$result=$this->get_content($offset,$limit);

?>

<div class="new_container2">
<?php for($i=0;$i<count($result);$i++):?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <span><strong><?=$result[$i]['theme'];?></strong></span>
            <span id="center"><?=$result[$i]['mail'];?></span>
            <span id="right"><?=@date('d-m-Y / H:i:s', $result[$i]['date']);?></span>
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






