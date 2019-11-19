<?php
session_start();
//graphs trend throughout weeks of virtual and real demand for one product.
require_once('config.php');
db_connect();

//grabbing # of sales between periods.
//Beans,Maize,Soap



$query="SELECT villages.name,villageID,COUNT(villages.name) FROM villages ORDER BY villageID";
$stmt=$db->prepare($query);
if($stmt===FALSE) exit("Prepare error $db->error");
if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
if($stmt->bind_result($vName,$vID,$villageCount)===FALSE) exit("bind error");
	while($stmt->fetch()){
		$villageIDs[]=$vID;
		$villageList[]=$vName;
	}
	$stmt->close;
	
	

	$query = "SELECT SUM(realdemanddetails.quantity),villages.name,weeklydemanddetails.weekDate
FROM realdemanddetails
JOIN villages ON(realdemanddetails.villageID=villages.villageID)
LEFT JOIN weeklydemanddetails ON(weeklydemanddetails.weekID=realdemanddetails.weekID) AND(weeklydemanddetails.villageID=realdemanddetails.villageID)
WHERE realdemanddetails.villageID = ?
GROUP BY  weeklydemanddetails.weekDate";

for ($i = 0; $i < $villageCount; $i++) {
	$stmt=$db->prepare($query);
	
	if($stmt===FALSE) exit("Prepare error $db->error");
	$stmt->bind_param('i',$villageIDs[$i]);
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($sumRD,$villageName,$wkDate)===FALSE) exit("bind error");
	while($stmt->fetch()){
		//making separate arrays for each village.
		${"rd_village{$villageIDs[$i]}[]"} = $sumRD;
		${"wkd_village{$villageIDs[$i]}[]"} = $wkDate;
		

		//summing total in one list as well, just in case needed.
		$sumRealDemand[]=$sumRD;
		$sumWeeks[]=$wkDate;
		$sumNames[]=$villageName;
	}
	$stmt->close;
		
}


	
//getting max demand for max y parameter on chart.
$query = "SELECT MAX(realdemanddetails.quantity), MAX(virtualdemanddetails.quantity)
				 FROM realdemanddetails
				 LEFT JOIN virtualdemanddetails ON(realdemanddetails.realID=virtualdemanddetails.virtualID)";
	
	$stmt=$db->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	 
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($maxr,$maxv)===FALSE) exit("bind error");
	while($stmt->fetch()){	
	$maxDemand = max($maxr,$maxv); 
	}
	
//indexing and sorting all dates, and applying a
//first get min date
 $query = "SELECT MIN(weeklydemanddetails.weekDate) FROM weeklydemanddetails";
$stmt=$db->prepare($query);
if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
if($stmt->bind_result($minD)===FALSE) exit("bind error");
while($stmt->fetch()){
	$minDate=$minD;
}

//get date difference between dates, as well as number of unique dates.
$query = "SELECT DateDiff(weeklydemanddetails.weekDate,?),MAX(DateDiff(weeklydemanddetails.weekDate,?)),weekDate,COUNT(weekDate) FROM weeklydemanddetails
GROUP BY weekDate
ORDER BY weekDate";

$stmt=$db->prepare($query);
$stmt->bind_param('ss',$minDate,$minDate);
if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
if($stmt->bind_result($dateDiff,$maxDateDiff,$wkDate,$weekCount)===FALSE) exit("bind error");
while($stmt->fetch()){
	$dateDiff[$wkDate] = $dateDiff;
	$uniqueDates[] = $wkDate;
	}
//datediff array will get difference in dates
//from the minimum date, will be used to create chart x axis.

?>
