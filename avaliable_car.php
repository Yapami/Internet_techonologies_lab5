<?php
include("bd.php");
$dateToShow=$_POST['dateToShow'];
//$dateToShow="2014-09-01";
//echo strtotime("2014-09-02")-strtotime("2014-09-03");
//echo strtotime("2014-09-03");
//echo $dateToShow;

$res = $mysqli->query("SELECT * FROM cars");
$res->data_seek(0);
while ($myrow = $res->fetch_assoc())
{
	$arrayCar[$myrow["ID_Cars"]]=$myrow["Name"];
	$availableCar[$myrow["ID_Cars"]]="Available";
}

$res = $mysqli->query("SELECT * FROM rent");
		$res->data_seek(0);
		$allCost=0;
		while ($myrow = $res->fetch_assoc())
		{
			//echo myrow['Date_start'];
			if ($dateToShow!=""){
				if (($myrow['Date_start']<=$dateToShow)&&($myrow['Date_end']>=$dateToShow)){

					
					
					if ($dateToShow==$myrow['Date_start']){
						if ($availableCar[$myrow["FID_Car"]]=="Available"){
							$availableCar[$myrow["FID_Car"]]="Available till ".$myrow['Time_start'];
						}else{
							$availableCar[$myrow["FID_Car"]]=$availableCar[$myrow["FID_Car"]]." till"+$myrow['Time_start'];
						}
					}else if ($dateToShow==$myrow['Date_end']){
						if ($availableCar[$myrow["FID_Car"]]=="Available"){
							$availableCar[$myrow["FID_Car"]]="Available after ".$myrow['Time_end'];
						}else{
							$availableCar[$myrow["FID_Car"]]=$availableCar[$myrow["FID_Car"]]." after"+$myrow['Time_end'];
						}
					}else{
						$availableCar[$myrow["FID_Car"]]="Not available";
					}
				}
				
			}
		}
		if ($dateToShow!=""){
			foreach($availableCar as $id => $status) {
				
				$table=$table."<tr><td>".$arrayCar[$id]."</td><td>";
				if ($status=="Available"){
					$table=$table."<font color='green'>";
				}
				else if ($status=="Not available"){
					$table=$table."<font color='red'>";
				}
				else{
					$table=$table."<font color='yellow'>";
				}
				$table=$table.$status."</font></td></tr>";
			}
			
		}

		//echo $table;
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 1(Свободные машины)</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="avaliable_car.php" method="post">
<a style="margin-left: 50px;">Выберите дату:</a><br>
<input name="dateToShow" style="background-color: #2980b9; border-radius: 10px;" type=date>
<input class="btn third" type="submit" value="Загрузить" />

</form>
<table id="myTable" class="table_dark">
   <?php echo $table; ?>
</table><br>
<?php echo $out;?>
</div>

 </body>
</html>
