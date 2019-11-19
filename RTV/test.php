<?php
$mysqli = new mysqli('gcontrol.raisethevillage.com', 'root', 'q0w1e9r2t8y3u7i4o6p5[','uganda',3307);
/*
 * This is the "official" OO way to do it,
 * BUT $connect_error was broken until PHP 5.2.9 and 5.3.0.
 */
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

/*
 * Use this instead of $connect_error if you need to ensure
 * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
 */
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}

echo 'Success... ' . $mysqli->host_info . "\n";



//$link = mysql_connect('localhost:3307', 'root', 'q0w1e9r2t8y3u7i4o6p5[');
//if (!$link) {
//    die('Could not connect: ' . mysql_error());
//}
//echo 'Connected successfully';
//mysql_close($link);
echo "THIS IS ANOTHER TEST";
?>