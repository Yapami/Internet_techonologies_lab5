<?php
include("bd.php");
$dateToShow=$_POST['dateToShow'];
//$dateToShow="2014-11-15";
//echo strtotime("2014-09-02")-strtotime("2014-09-03");
//echo strtotime("2014-09-03");
//echo $dateToShow;
$res = $mysqli->query("SELECT * FROM rent");
		$res->data_seek(0);
		$allCost=0;
		while ($myrow = $res->fetch_assoc())
		{
			//echo myrow['Date_start'];
			if ($dateToShow!=""){
				if (($myrow['Date_start']<=$dateToShow)&&($myrow['Date_end']>=$dateToShow)){
					$res1 = $mysqli->query("SELECT * FROM cars WHERE ID_Cars=".$myrow['FID_Car']);
					$res1->data_seek(0);
					$myrow1 = $res1->fetch_assoc();
					
					
					
					$allRentTime=strtotime($myrow['Date_end'])-strtotime($myrow['Date_start'])."<br>";
					//echo strtotime($myrow['Time_end'])-strtotime($myrow['Time_start']);
					$allRentTime=$allRentTime+ strtotime($myrow['Time_end'])-strtotime($myrow['Time_start'])."<br>";
					$allRentTime=$allRentTime*1.0;
					$costPerSec=$myrow['Cost']/$allRentTime;
					//echo $costPerSec."<br>";
					$moneyPerDay=$costPerSec*60*60*24;
					//echo 86400-strtotime($myrow['Time_end'])+strtotime("00:00:00");
					if ($dateToShow==$myrow['Date_start']){
						$moneyPerDay=$moneyPerDay-((strtotime($myrow['Time_start'])-strtotime("00:00:00"))*$costPerSec);
					}else if ($dateToShow==$myrow['Date_end']){
						$moneyPerDay=$moneyPerDay-((86400-strtotime($myrow['Time_end'])+strtotime("00:00:00"))*$costPerSec);
						
					}
					
					$table=$table."<tr><td>".$myrow1['Name']."</td><td>".$moneyPerDay."</td></tr>";
					$allCost=$allCost+$moneyPerDay;
					//echo $myrow['Date_start']."-".$myrow['Date_end']."=".($myrow['Date_end']-$myrow['Date_start'])."<br>";
				}
				
			}
		}
		if ($dateToShow!=""){
			
			$table="<tr><th>All</th><th>".$allCost."</th></tr>".$table;
		}

		//echo $table;
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 1(Прибыль)</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="money.php" method="post">
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
