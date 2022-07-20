<?php
include("bd.php");
$carToRent=$_POST['carToRent'];
$dateFromRent=$_POST['dateFromRent'];
$timeFromRent=$_POST['timeFromRent'];
$dateTillRent=$_POST['dateTillRent'];
$timeTillRent=$_POST['timeTillRent'];
$costRent=$_POST['costRent'];
//echo "q".$costRent."q";
$error=false;
$errorText="";
if ($dateFromRent==""){
	$errorText=$errorText."Error type:1<br>";
	$error=true;
}
if ($timeFromRent==""){
	$error=true;
	$errorText=$errorText."Error type:2<br>";
}
if ($dateTillRent==""){
	$error=true;
	$errorText=$errorText."Error type:3<br>";
}
if ($timeTillRent==""){
	$error=true;
	$errorText=$errorText."Error type:4<br>";
}if ($costRent==""){
	$errorText=$errorText."Error type:5<br>";
	$error=true;
}if (!is_numeric($costRent)){
	$errorText=$errorText."Error type:6<br>";
	$error=true;
}
if (strtotime($dateFromRent)>strtotime($dateTillRent)){
		$errorText=$errorText."Error type:15<br>";
	$error=true;
}else if ($dateFromRent==$dateTillRent){
	if (strtotime($timeFromRent)>strtotime($timeTillRent)){
		$errorText=$errorText."Error type:16<br>";
		$error=true;
		
	}
	
}
//$dateToShow="2014-09-01";
//echo strtotime("2014-09-02")-strtotime("2014-09-03");
//echo strtotime("2014-09-03");
//echo $dateToShow;
$res = $mysqli->query("SELECT * FROM cars");
$res->data_seek(0);
//echo $carToRent;
while ($myrow = $res->fetch_assoc())
{
	if (($carToRent!="")&&($carToRent==$myrow['Name'])){
		$idCar=$myrow['ID_Cars'];
	}
	$cars=$cars."<option>".$myrow['Name']."</option>";
}
//echo $idCar;
		

$res = $mysqli->query("SELECT * FROM rent");
		$res->data_seek(0);
		$allCost=0;
		while ($myrow = $res->fetch_assoc())
		{
			//echo myrow['Date_start'];
			if (($idCar!="")&&($idCar==$myrow['FID_Car'])){
				if (($myrow['Date_start']>=$dateFromRent)&&($myrow['Date_start']<=$dateTillRent)){
					$errorText=$errorText."Error type:7<br>";
					$error=true;
				}
				if (($myrow['Date_end']>=$dateFromRent)&&($myrow['Date_end']<=$dateTillRent)){
					$errorText=$errorText."Error type:8<br>";
					$error=true;
				}
				if (($myrow['Date_start']<=$dateFromRent)&&($myrow['Date_end']>=$dateFromRent)){
					if ($dateFromRent==$myrow['Date_start']){
						if ($myrow['Time_start']>$timeFromRent){
							$errorText=$errorText."Error type:9<br>";
							$error=true;
						}
					}else if ($dateFromRent==$myrow['Date_end']){
						if ($myrow['Time_end']<$timeFromRent){
							$errorText=$errorText."Error type:10<br>";
							$error=true;
						}
					}else{
						$errorText=$errorText."Error type:11<br>";
						$error =true;
					}
				}
				if (($myrow['Date_start']<=$dateTillRent)&&($myrow['Date_end']>=$dateTillRent)){
					if ($dateTillRent==$myrow['Date_start']){
						if ($myrow['Time_start']<$timeTillRent){
							$errorText=$errorText."Error type:12<br>";
							$error=true;
						}
					}else if ($dateTillRent==$myrow['Date_end']){
						if ($myrow['Time_end']>$timeTillRent){
							$errorText=$errorText."Error type:13<br>";
							$error=true;
						}
					}else{
						$errorText=$errorText."Error type:14<br>";
						$error =true;
					}
				}
				
			}
		}
		
		//$showError="";
		if ($idCar!=""){
			if ($error==false){
				//echo "<br>q";
				//echo "INSERT INTO rent (FID_Car,Date_start,Time_start,Date_end,Time_end,Cost) VALUES('".$idCar."','".$dateFromRent."','".$timeFromRent."','".$dateTillRent."','".$timeTillRent."','".$costRent."')";
		
				$res = $mysqli->query("INSERT INTO rent (FID_Car,Date_start,Time_start,Date_end,Time_end,Cost) VALUES('".$idCar."','".$dateFromRent."','".$timeFromRent."','".$dateTillRent."','".$timeTillRent."','".$costRent."')");
			}else{
				$showError="Data incorrect";
				
			}
			
		}

		//echo $table;
?>
<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>ЛБ 1(Аренда)</title>
  <link href="external.css" rel="stylesheet">
 </head>
 <body>

<div class="navigation">
<form action="rent.php" method="post">
<a style="margin-left: 50px;"><?php echo $showError; ?></a><br>
<a style="margin-left: 50px;">Выберите авто и дату:</a><br>

<a style="margin-left: 0px;">From:</a>
<input name="dateFromRent" style="background-color: #2980b9; border-radius: 10px;" type=date>
<input name="timeFromRent" style="background-color: #2980b9; border-radius: 10px;" type=time><br>
<a style="margin-left: 27px;">Till:</a>
<input name="dateTillRent" style="background-color: #2980b9; border-radius: 10px;" type=date>
<input name="timeTillRent" style="background-color: #2980b9; border-radius: 10px;" type=time><br>


<span style="margin-left: 60px;" class="custom-dropdown big">
    <select name="carToRent">    
        <option selected="selected"  disabled>Car</option>
		<?php echo $cars ?>
    </select>
</span>
<input name="costRent"  type="text" value="Цена" />
<input style="margin-left: 130px;" class="btn third" type="submit" value="Арендовать" />

</form>
<table id="myTable" class="table_dark">
   <?php echo $table; ?>
</table><br>
<?php echo $out;?>
</div>

 </body>
</html>
