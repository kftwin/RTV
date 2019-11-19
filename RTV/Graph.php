<?php session_start();
//require_once('chart-aggregatecode.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<link href="Graph_CSS.css" type="text/css" rel="stylesheet">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Graph</title>
</head>
<body>
<form action='https://chart.googleapis.com/chart' method='POST'>
  <input type="hidden" name="cht" value="bvg"  />
   <input type="hidden" name="chxr" value="0,1,2|1,1,100"/>
  <input type="hidden" name="chxl" value="1:|Weeks|3:|Demand"  />
  <input type="hidden" name="chtt" value=" Product Weekly Demands"  />
  <input type="hidden" name="chs" value= "600x400" />
  <input type="hidden" name="chbh" value="a" />
  <input type="hidden" name="chco" value="2C5DF9,94B8FD" /> 
  <input type="hidden" name="chxt" value="x,x,y,y"  />
  <input type="hidden" name="chf" value="c,s,C2BDDD2C"  />
  <input type="hidden" name="chxp" value="1,50|3,50"  />
  <input type="hidden" name="chd" value="t:10,20"/>
  <input type="hidden" name="chdl" value="Real Products|Virtual Products"  />
  <input type="hidden" name="chm" value="b,FF7A00,0,1,0"  />
  <input type="submit" value ="Create chart"/>
</form>
</body>
</html>