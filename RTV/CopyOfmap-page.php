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

$goal=array(3000,300,30,30,30,30,30,30,30,30);

$query="SELECT  title, buyDate, COUNT(realObject_id) as count
FROM playerPurchase
JOIN realObject ON (playerPurchase.realObject_id=realObject.id)
WHERE buyDate > '2011-07-01' AND title IN ('Beans','Maize','Soap','Jerry Can','Mosquito Nets','Sugar'
,'Kids Shoes','Scholarship','School Uniform','T-Shirts','Water Tanks','Cooking Pots','Dishes')
GROUP BY title
ORDER BY count desc";

$result = mysql_query($query)
or die(mysql_error());
$i = 0;
while($row=mysql_fetch_array($result))
{
$title[] = $row['title'];
$count[] = $row['count'];
$percent[] = ($row['count']/$goal[$i])*100;
echo "<tr><td>" .  $row['title'] . "<td>" . $row['count'] . "<td>" . $goal[$i] . "\n";

$i++;
}
$_SESSION['title'] = $title;
$_SESSION['count'] = $count;
$_SESSION['percent'] = $percent;
$_SESSION['goal']= $goal;
echo "</tr>";
mysql_close($link);

?>
<br><img width='440' border='3' height='220' src='images/mapinfo.php.png'>
</body>
</html>