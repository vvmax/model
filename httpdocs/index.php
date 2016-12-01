<?php include 'lib/include.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cоздание логико-смысловых моделей</title>
        <meta charset="UTF-8">
		<meta name="keywords" content="Логико-смысловая модель" />
		<meta name="description" content="Cоздание логико-смысловых моделей" />
        <link rel="stylesheet" type="text/css" href="/css/styles.css">
		<link rel="stylesheet" type="text/css" href="/opt/fancybox/jquery.fancybox-1.3.4.css">
		<script type="text/javascript" src="/opt/jquery-1.4.3.min.js"></script>
		<script type="text/javascript" src="/opt/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
    </head>
    <body>
        <div id="wrap">
			<?php include 'header.php'; ?>
            <section>
                <h1>Cоздание логико-смысловых моделей</h1>
				<P>Сайт позволяет облегчить учебный процесс, путем упрощения преподаваемого материала с помощью логико-смысловых моделей.
				</P>
				<p><b>Учитель</b> может создать свои логико-смысловые модели для заполнения, или использовать уже имеющиеся. Также он может проверять ЛСМ заполненные своими учениками</p>
				<p><b>Ученик</b> может заполнить любые из представленных моделей и сохранить, распечатать или отправить их на проверку учителю. </p>
				<p class="standartImage"><a class="fancybox" title="ЛСМ обоснования особенностей восприятия информации" href="images/model_example.png"><img src='images/model_example.png' alt="ЛСМ обоснования особенностей восприятия информации"></a></p>
				<p>ЛСМ – это образно-понятийная  конструкция, в которой смысловой
					компонент представлен  связанной системой понятий, а логический компонент выполнен из радиальных и круговых
					графических элементов, предназначенных
					для размещения понятий.
					ЛСМ относится к дидактическим наглядным
					средствам поддержки учебных действий,
					содержащим смысловые понятийные и логические компоненты . 
					Благодаря ей операции переработки учебного материала выполняются непосредственно
					в процессе его восприятия, а с помощью образно-понятийного представления изучаемого объекта происходит координация первой и
					второй сигнальных систем.</p>
				<p><a class='simplea' href="help.php">Подробнее...</a></p>
            </section>
			<?php include 'footer.php'; ?>
        </div>
		<script>
			$(document).ready(function () {
				$('.fancybox').fancybox();
			});
		</script>
    </body>
</html>
