<?php
include("bd.php");
$vendorToShow=$_POST['vendorToShow'];

$res = $mysqli->query("SELECT * FROM vendors");
		$res->data_seek(0);
		while ($myrow = $res->fetch_assoc())
		{
			if ($vendorToShow==$myrow['Name']){
				$idVendorToShow=$myrow['ID_Vendors'];
				
			}
			$vendors=$vendors."<option>".$myrow['Name']."</option>";
		}
		if($idVendorToShow!=""){
			$res = $mysqli->query("SELECT * FROM cars WHERE FID_Vendors=".$idVendorToShow);
			$res->data_seek(0);
			while ($myrow = $res->fetch_assoc())
			{
				$table=$table."<tr><td>".$myrow['Name']."</td><td>".$vendorToShow."</td></tr>";
			}
			
		}
		//echo $table;
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 1(Производитель)</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="vendor.php" method="post">
<a style="margin-left: 50px;">Выберите производителя:</a><br>
<span class="custom-dropdown big">
    <select name="vendorToShow">    
        <option selected="selected"  disabled>Производитель</option>
		<?php echo $vendors ?>
    </select>
</span><input class="btn third" type="submit" value="Загрузить" />
</form>
<table id="myTable" class="table_dark">
   <tr>
    <th>Машина</th>
    <th>Производитель</th>
   </tr>
   <?php echo $table; ?>
</table><br>
<?php echo $out;?>
</div>

 </body>
</html>
