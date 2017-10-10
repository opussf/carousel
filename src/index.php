<?php
if ($_GET["limit"]) {
	$limit = intval( $_GET["limit"] );
}
if (empty($limit)) { $limit = 10; }
if ($_GET["ms"]) {
	$ms = intval( $_GET["ms"] );
}
if (empty($ms)) { $ms = 800; }
if ($_GET["width"]) {
	$width = intval( $_GET["width"]);
}
if (empty($width)) { $width= 640; }


# build the list of slides
$img_dir = "imgs";

$all = scandir("./$img_dir");
$afiles = array();
foreach( $all as $file) {
	if (!is_dir("./$img_dir/$file")) {
		$afiles[] = "$img_dir/$file";
	}
}

# build the size limit array
$alimit = array(1, 2, 5, 10, 20, 50, 100, 200, 500, 1000, 2000, 5000, 10000);
$lcv = 0;
$c = count( $afiles );
foreach( $alimit as $v ) {
	if ($v >= $c) {
		$alimit = array_slice($alimit, 0, $lcv);
		break;
	}
	$lcv++;
}
$alimit[] = $c;

$ams = array(100, 200, 300, 400, 500, 800, 1000, 2000);
$widths = array(640, 720, 1000, 1440);
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>Wow Slideshow</title>
<link type='text/css' href="wowshots.css" rel="stylesheet"/>
</head>
<body>
<div class="menus">
<div class="limit_menu">
<ul>
<li>Limit to:</li>
<?php
# show the limit menu
foreach( $alimit as $a ) {
	$linkStart = "<strong><mark>"; $linkEnd = "</mark></strong>";
	if ($a != $limit) {
		$linkStart = "<a href='index.php?width=$width&limit=$a&ms=$ms'>";
		$linkEnd = "</a>";
	}
	print("<li>$linkStart$a$linkEnd</li>\n");
}
?>
</ul>
</div>
<div class="time_menu">
<ul>
<li>Seconds:</li>
<?php
foreach ( $ams as $m ) {
	$linkStart = "<strong><mark>"; $linkEnd = "</mark></strong>";
	if ($m != $ms) {
		$linkStart = "<a href='index.php?width=$width&limit=$limit&ms=$m'>";
		$linkEnd = "</a>";
	}
	$m = $m / 1000;
	print("<li>$linkStart$m$linkEnd</li>\n");
}

?>
</ul>
</div>
<div class="width_menu">
<ul>
<li>Width:</li>
<?php
foreach( $widths as $w ) {
	$linkStart = "<strong><mark>"; $linkEnd = "</mark></strong>";
	if ($w != $width) {
		$linkStart = "<a href='index.php?width=$w&limit=$limit&ms=$ms'>";
		$linkEnd = "</a>";
	}
	print("<li>$linkStart$w$linkEnd</li>\n");
}
?>
</ul>
</div> <!-- width_menu -->
</div> <!-- Menus -->

<div class="carousel" style="max-width:1000px">
<?php
# mySlides divs for content
$afiles = array_slice($afiles, -$limit);

$lcv = 1; $c = count($afiles);
foreach( $afiles as $file) {
	print("<div class=\"mySlides\">");
	if ($width < 1440) {
		print("<img src=\"mythumb.php?fname=$file&w=$width\" style=\"width:100%\">\n");
	} else {
		print("<img lowsrc=\"mythumb.php?fname=$file&w=50\" src=\"$file\" style=\"width:100%\">\n");
	}
	print("<div class=\"caption\"><a href=\"$file\">$file  $lcv/$c</a></div>");
	print("</div>");
	$lcv++;
}

?>
</div>
<!-- carousel script to show the images -->
<!-- from http://www.w3schools.com/w3css/w3css_slideshow.asp  -->
<script>
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, <? echo $ms ?>); // Change image every miliseconds
}
</script>
</body>
