<?php
session_start();
?>
<html>
<body>
<table border=1>
<caption><EM>Test</EM></caption>
<tr>
<th>Item</th>
<th>Sold</th>
<th>Goal</th>
</tr>
<?php
require_once('config.php');
$goal=array(4823,2148,507,156,72,137,836,603,545,901,1195,144,707,545,707,398,383);
$goal_food=array($goal[0],$goal[1],$goal[2]);
$goal_home=array($goal[3],$goal[4],$goal[5],$goal[6]);
$goal_health=array($goal[7],$goal[8],$goal[9]);
$goal_child=array($goal[10],$goal[11],$goal[12],$goal[13],$goal[14]);


$query="SELECT  title, buyDate, COUNT(realObject_id) as count
FROM playerPurchase
JOIN realObject ON (playerPurchase.realObject_id=realObject.id)
WHERE buyDate > '2011-07-01' AND title IN ('Beans','Maize','Soap','Jerry Can','Mosquito Nets','Sugar'
,'Kids Shoes','Scholarship','School Uniform','T-Shirts','Water Tanks','Cooking Pots','Dishes', 'Tarp Shelter', 'Water Filter', 'Sports Equipment')
GROUP BY title
ORDER BY
(CASE realObject.collectionId
WHEN 17 THEN 1
WHEN 18 THEN 2
WHEN 19 THEN 3
WHEN 20 THEN 4
When 0 THEN 5 end), title asc
";


	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($t,$d,$c)===FALSE) exit("bind error");

	//will populate village dropdown
	$i=0;
	while($stmt->fetch()){
$title[] = $t;
$count[] = $c;
IF ($c > 0) {$percent[] = ($c/$goal[$i])*100;}
else
$percent[]=0;
echo "<tr><td>" .  $t . "<td>" . $c . "<td>" . $goal[$i] . "\n";
$i++;
	}

$_SESSION['title'] = $title;
$_SESSION['count'] = $count;
$_SESSION['percent'] = $percent;
$_SESSION['goal']= $goal;
echo "</tr></table>";

//child query


$query="SELECT realObject.title as title, buyDate,IFNULL(Subtotal.Total,0) as count
FROM realObject
LEFT JOIN (SELECT title, buyDate, COUNT(realObject_id) as Total
FROM playerPurchase
JOIN realObject ON (playerPurchase.realObject_id=realObject.id)
WHERE buyDate > '2011-07-01' AND realObject.collectionId='20'
GROUP BY realObject.title) Subtotal ON realObject.title=Subtotal.title
WHERE realObject.collectionId='20'
ORDER BY title";


	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($t,$d,$c)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
$title_child[] = $t;
$count_child[] = $c;
IF ($c <> 0) {$percent_child[] = ($c/$goal_child[$i])*100;}
else
$percent_child[]=0;
$i++;
}
$_SESSION['title-child'] = $title_child;
$_SESSION['count-child'] = $count_child;
$_SESSION['percent-child'] = $percent_child;
$_SESSION['goal-child']= $goal_child;


//food query

$query="SELECT realObject.title as title, buyDate,IFNULL(Subtotal.Total,0) as count
FROM realObject
LEFT JOIN (SELECT title, buyDate, COUNT(realObject_id) as Total
FROM playerPurchase
JOIN realObject ON (playerPurchase.realObject_id=realObject.id)
WHERE buyDate > '2011-07-01' AND realObject.collectionId='17'
GROUP BY realObject.title) Subtotal ON realObject.title=Subtotal.title
WHERE realObject.collectionId='17'
ORDER BY title";

	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($t,$d,$c)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
$title_food[] = $t;
$count_food[] = $c;
IF ($i == 1) {$count_food[$i] = $c + 926;}
IF ($i == 2) {$count_food[$i] = $c + 121.52;}
IF ($c <> 0) {$percent_food[] = ($count_food[$i]/$goal_food[$i])*100;}
else
$percent_food[]=0;
$i++;
}
$_SESSION['title-food'] = $title_food;
$_SESSION['count-food'] = $count_food;
$_SESSION['percent-food'] = $percent_food;
$_SESSION['goal-food']= $goal_food;
echo "TEST TEST TasdfakjfsakfdaEST" . $count_food[1];
//health query


$query="SELECT realObject.title as title, buyDate,IFNULL(Subtotal.Total,0) as count
FROM realObject
LEFT JOIN (SELECT title, buyDate, COUNT(realObject_id) as Total
FROM playerPurchase
JOIN realObject ON (playerPurchase.realObject_id=realObject.id)
WHERE buyDate > '2011-07-01' AND realObject.collectionId='19'
GROUP BY realObject.title) Subtotal ON realObject.title=Subtotal.title
WHERE realObject.collectionId='19'
ORDER BY title";

	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($t,$d,$c)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
$title_health[] = $t;
$count_health[] = $c;
IF ($c <> 0) {$percent_health[] = ($c/$goal_health[$i])*100;}
else
$percent_health[]=0;
$i++;
}
$_SESSION['title-health'] = $title_health;
$_SESSION['count-health'] = $count_health;
$_SESSION['percent-health'] = $percent_health;
$_SESSION['goal-health']= $goal_health;

//home query

$query="SELECT realObject.title as title, buyDate,IFNULL(Subtotal.Total,0) as count
FROM realObject
LEFT JOIN (SELECT title, buyDate, COUNT(realObject_id) as Total
FROM playerPurchase
JOIN realObject ON (playerPurchase.realObject_id=realObject.id)
WHERE buyDate > '2011-07-01' AND realObject.collectionId='18'
GROUP BY realObject.title) Subtotal ON realObject.title=Subtotal.title
WHERE realObject.collectionId='18'
ORDER BY title";

	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($t,$d,$c)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
$title_home[] = $t;
$count_home[] = $c;
IF ($c <> 0) {$percent_home[] = ($c/$goal_home[$i])*100;}
else
$percent_home[]=0;
$i++;
}
$_SESSION['title-home'] = $title_home;
$_SESSION['count-home'] = $count_home;
$_SESSION['percent-home'] = $percent_home;
$_SESSION['goal-home']= $goal_home;
?>
<table border=1>
<caption><EM>Top Monthly For:</EM></caption>
<tr>
<th>Player</th>
<th># Bought</th>
</tr>
<?php
$query="SELECT  login, COUNT(realObject_id) as count
FROM playerPurchase
JOIN realObject ON (playerPurchase.realObject_id=realObject.id)
JOIN playerList ON (playerPurchase.player_ID = playerList.id)
WHERE buyDate > '2011-07-01' AND title IN ('Beans','Maize','Soap','Jerry Can','Mosquito Nets','Sugar'
,'Kids Shoes','Scholarship','School Uniform','T-Shirts','Water Tanks','Cooking Pots','Dishes', 'Tarp Shelter', 'Water Filter', 'Sports Equipment')
GROUP BY login
ORDER BY count desc
LIMIT 0, 10";

	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($l,$c)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
echo "<tr><td>" .  $l . "<td>" . $c . "\n";

}

echo "</tr></table>";
?>
<table border=1>
<caption><EM>Top Florin Weekly:</EM></caption>
<tr>
<th>Player</th>
<th>Florin Spent</th>
</tr>
<?php
$today = date("Y-m-d");

$oneWeekAgo = date("Y-m-d", strtotime('-7 day' . $today));
echo $oneWeekAgo;

$query="SELECT  login, SUM(realObject.priceGameMoney) as count
FROM playerPurchase
JOIN realObject ON (playerPurchase.realObject_id=realObject.id)
JOIN playerList ON (playerPurchase.player_ID = playerList.id)
WHERE buyDate > ? AND title IN ('Beans','Maize','Soap','Jerry Can','Mosquito Nets','Sugar'
,'Kids Shoes','Scholarship','School Uniform','T-Shirts','Water Tanks','Cooking Pots','Dishes', 'Tarp Shelter', 'Water Filter', 'Sports Equipment')
AND login NOT IN ('#####joeytest99#####', 'joey18', 'cameron', 'biko')
GROUP BY login
ORDER BY count desc
LIMIT 0, 25";

	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	$stmt->bind_param("s", $oneWeekAgo);
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($l,$c)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
echo "<tr><td>" .  $l . "<td>" . $c . "\n";

}
echo "</tr></table>";
?>
<table border=1>
<caption><EM>Top Collections Ever:</EM></caption>
<tr>
<th>Player</th>
<th># Collections</th>
</tr>
<?php

$query="SELECT  playerList.login, COUNT(userCollection.playerId) as count
FROM userCollection
JOIN playerList ON (userCollection.playerId = playerList.id)
WHERE login NOT IN ('#####joeytest99#####')
GROUP BY login
ORDER BY count desc
LIMIT 0, 25";

	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($l,$c)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
echo "<tr><td>" .  $l . "<td>" . $c . "\n";

}
echo "</tr></table>";
?>

<table border=1>
<caption><EM>Top Gift Giver Ever:</EM></caption>
<tr>
<th>Player</th>
<th># Gifts Given</th>
</tr>
<?php

$query="SELECT  playerList.login, COUNT(playerGifts.fromPlayer) as count
FROM playerGifts
JOIN playerList ON (playerGifts.fromPlayer = playerList.id)
WHERE login NOT IN ('#####joeytest99#####')
GROUP BY login
ORDER BY count desc
LIMIT 0, 25";

	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($l,$c)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
echo "<tr><td>" .  $l . "<td>" . $c . "\n";

}

echo "</tr></table>";

$query="SELECT login,firstName,villagePopulation,email
FROM playerList
ORDER BY villagePopulation desc
LIMIT 0, 100";

	$stmt=$link->prepare($query);
	if($stmt===FALSE) exit("Prepare error $db->error");
	if($stmt->execute()===FALSE) exit("Execute error: $stmt->error");
	if($stmt->bind_result($l,$fn,$p,$e)===FALSE) exit("bind error");

$i = 0;
	while($stmt->fetch()){
if($e) echo $e . ",";

}
mysqli_close($link);

?>

<br><img width='450' border='3' height='280' src='mapinfo-child.php'>
<br><img width='450' border='3' height='280' src='mapinfo-food.php'>
<br><img width='450' border='3' height='280' src='mapinfo-health.php'>
<br><img width='450' border='3' height='280' src='mapinfo-home.php'>
</body>
</html>