<?php
include("bd.php");
$carToChange=$_POST['carToChange'];
$raceDist=$_POST['raceDist'];
//echo $raceDist;
if ($carToChange!=""){
	//echo "1<br>";
	if ($raceDist!=""){
		//echo "2<br>";
		if (is_numeric($raceDist)){
			//echo "3<br>";
			//echo "UPDATE cars SET Race='".$raceDist."' WHERE Name=".$carToChange;
			$res = $mysqli->query("UPDATE cars SET Race='".$raceDist."' WHERE Name='".$carToChange."'");
		
		}
	}
}
$res = $mysqli->query("SELECT * FROM cars");
		$res->data_seek(0);
		while ($myrow = $res->fetch_assoc())
		{
			$table=$table."<tr><td>".$myrow['Name']."</td><td>".$myrow['Race']."</td></tr>";
			$cars=$cars."<option>".$myrow['Name']."</option>";
		}
		//echo $table;

		//echo $table;
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 1(Редактор пробега)</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="race_edit.php" method="post">
<a style="margin-left: 100px;">Выберите машину:</a><br>
<span style="margin-left: 60px;" class="custom-dropdown big">
    <select name="carToChange">    
        <option selected="selected"  disabled>Car</option>
		<?php echo $cars ?>
    </select>
</span>
<input name="raceDist"  type="text" value="Пробег" />
<input class="btn third" style="margin-left: 130px;" type="submit" value="Изменить" />

</form>
<table id="myTable" class="table_dark">
<tr><th>Cars</th><th>Race</th></tr>
   <?php echo $table; ?>
</table><br>
<?php echo $out;?>
</div>

 </body>
</html>
