<?php
session_start();

  // Create some random text-encoded data for a line chart.
  header('content-type: image/png');
  $url = 'https://chart.googleapis.com/chart?chid=' . md5(uniqid(rand(), true));
  $chd = 't:';
  //populate percentages
  foreach($_SESSION['percent-food'] as $percent){
    $chd .= $percent . ',';
  }
  $chd = substr($chd, 0, -1);
  $chd .= "|";

  //foreach($_SESSION['title'] as $t){
   // $chd .= 100 . ',';
 // } 
  $chd = substr($chd, 0, -1);
//  $chxl = "-0:|";
  //populate product names
//  foreach($_SESSION['title-child'] as $name){
  //  $chxl .= $name . '|';
//  } 
  $chxl .= "0:|0%|25%|50%|75%|100%";
  
 // foreach($_SESSION['goal'] as $goal){
  //  $chxl .= $goal . '|';
 // }
 // $chxl .= "3:|GOAL";
  
// $chxr = "1,1," . $_SESSION['max'];
// $chds = "0," . $_SESSION['max'];
 
  // Add data, chart type, chart size, and scale to params.
  $chart = array(
    'cht' => 'bhs',
  	'chm' => 'N*0*%,000000,0,-1,11',
    'chf' => 'bg,s,3B523A00|c,lg,45,3B523A,0,8CBB77,1',
    //'chds' => '0,100,0,160',
    'chxs' => '0,C7E071,11.5,0,lt,C7E071|1,C7E071,11.5,0,lt,C7E071',
    'chxl' => $chxl,
    'chs' => '450x280',
   // 'chxr' => $chxr,
    'chtt' => 'Food Collection',
    'chco' => 'C7E071',
    'chxt' => 'x',
  	'chbh' => 'a',
  	'chma' => '40,40',
  //  'chf'  => 'c,s,C2BDDD2C',
    'chxp' => '2,50|3,50',
   // 'chdl' => 'Real Demand|Virtual Demand',
  //  'chm' => 'b,FF7A00,0,1,0',
    'chd' => $chd,
  	'chts' => 'C7E071,16'
    );

  // Send the request, and print out the returned bytes.
  $context = stream_context_create(
    array('http' => array(
      'method' => 'POST',
      'content' => http_build_query($chart,'', '&'))));
  fpassthru(fopen($url, 'r', false, $context));
?>
