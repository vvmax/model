<?
include 'lib/include.php';
if (isset($_REQUEST['OBJECT']) && isset($_REQUEST['ELEMENTS']))
{
    $obTableAnswer = new Data_Answer();
    $_REQUEST['ID']=$obTableAnswer->addAnswer($_REQUEST);
}
$arData= Utils_Model::getFillModel($_REQUEST['ID']);

?>
<html>
    <head>
        <title>Логические схемы</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
	<script type="text/javascript" src="/opt/jquery-2.1.4.min.js"></script>
    </head>
    <body>
        <div id="wrap">
             <?php include 'header.php';?>
            <section>
                <h1>Заполните модель</h1>
		<h2><?php print $arData['MODEL']['NAME'] ?></h2>
		<div class="textimg">
		    <img class="miniImage" src="/image.php?ID=<?=$_REQUEST['ID']?>">
		    <div class="imgmenu"> 
		        <a href="/readymodel.php?ID=<?=$_REQUEST['ID']?>">Ссылка на ответ</a>
			<a href="/image.php?ID=<?=$_REQUEST['ID']?>">Ссылка на схему</a>
			<a onclick="window.print();return false;" href="javascript:void(0)">Печать  схемы</a>
		    </div>
		</div>
		<table class='elements'><tr><th><?= $arData['MODEL']['OBJECT']?></th><td><?=$arData['ANSWER']['DATA']['OBJECT']?></td></tr></table>
		<?foreach ($arData['CATEGORIES'] as $key=>$arCategory):	?>
		<h3><?= $arCategory['NAME']?></h3>
		<table class="elements">
		    <?foreach ($arCategory['ELEMENTS'] as $arElement):	?>
		<tr><th><?= $arElement['NAME']?></th><td><?=$arData['ANSWER']['DATA']['ELEMENTS'][$arElement['ID']]?></td></tr>
		    <?  endforeach;	?>
		</table>
		<?  endforeach;	?>
		<?  //Utils_Image::getImage()?>
            </section>
	    <?php include 'footer.php';?>
        </div>
	<script>
	    $(document).ready(function(){
		$('.miniImage').click(function(e){
		    var ob=$(this);
		    console.log(ob.attr('src'));
		    var box=$('<div/>',{class:'imagebox',css:{'background-image':'url('+ob.attr('src')+')'}});
		    $('body').append(box);
		    box.click(function(){
			box.remove();
		    })
		});
		
	    });
	    
	</script>
    </body>
</html>
