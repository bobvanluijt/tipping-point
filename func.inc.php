<?php

/* VARIABLES */
$ver = "0.9";
$tabindex=1;

$dbname=""; // EDIT
$dbuser=""; // EDIT
$dbpass=""; // EDIT

/* DON'T CHANGE BELOW */

$con = mysqli_connect("localhost",$dbuser,$dbpass);
mysqli_select_db($dbname, $con);

$config_result = mysqli_query("SELECT * FROM configuration");
while($config_row = mysqli_fetch_assoc($config_result)) {
  $config{$config_row['item']}=$config_row['value'];
}

function PageHeader($site_name) {
	ob_start();
	?>
	<html>
	<head>
	<title>WEIGHT AND BALANCE CALCULATOR - <?=$site_name?></title>

	<style type="text/css">

	body {font-family: Cambria, Tahoma, Verdana; font-size: 12px;}
	input, select {font-family: Cambria, Tahoma, Verdana; font-size: 11px; border:1px solid #AAAAAA;}
	h2,h3 {color: 17365D}
	th {background-color: #4F81BD; text-align: center;}
	abbr {border-bottom: 1px dashed; cursor: help;}
	.readonly {background-color: #CCCCCC;}
	.numbers {text-align: right; width: 70px;}
	.numbergals {text-align: right; width: 40px;}
	@media print { .noprint { display: none; } }

	</style>
	<?php
}

function PageFooter($admin,$ver) {
	?>
	<p class="noprint" style="text-align:center; font-size:12px;"><i>Questions? Suggestions?  <a href="mailto:<?php echo($admin); ?>?subj=[Weight%20&%20Balance%20Tool]"><?php echo($admin); ?></a><br>
	<a href=\"http://sourceforge.net/p/tippingpoint\" target=\"_blank\">Tipping Point - Open Source Weight &amp; Balance Software</a> - Version <a href="changelog.txt" target="_blank"><?php echo($ver); ?></a></i></p>
	</body></html>
	<?php
	ob_end_flush();
}

function PassEncode($str) {
	$out=base64_encode($str);
	return $out;
}

function PassDecode($str) {
	$out=base64_decode($str);
	return $out;
}

function TimezoneList($str) {
	echo("<select id=\"TIMEZONE\" name=\"TIMEZONE\">");
	$timezone_identifiers = DateTimeZone::listIdentifiers();
	foreach( $timezone_identifiers as $value ){
		if ( preg_match('/^(America|Antartica|Arctic|Asia|Atlantic|Europe|Indian|Pacific)\//', $value ) ){
			$ex=explode("/",$value);//obtain continent,city
			if ($continent!=$ex[0]){
				if ($continent!="") echo "</optgroup>\n";
				echo "<optgroup label=\"".$ex[0]."\">\n";
			}
			$city=$ex[1];
			if (is_null($ex[2])==FALSE) { $city=$city . "/" . $ex[2]; }
			$continent=$ex[0];
		            echo "<option value=\"".$value."\"";
		            if ($str==$value) {
		            	echo " selected";
		            }
		            echo ">".$city."</option>\n";
	        }
	}
	echo("</optgroup></select>");
}

function AircraftListActive() {
	echo "<select name=\"tailnumber\">\n";
	$result = mysqli_query("SELECT * FROM aircraft WHERE active=1 ORDER BY tailnumber ASC");
	while($row = mysqli_fetch_array($result)) {
		echo "<option value=\"" . $row['id'] . "\">" . $row['tailnumber'] . " - " . $row['makemodel'] . "</option>\n";
	}
	echo "</select>\n";
}

function AircraftListAll() {
	echo "<select name=\"tailnumber\">\n";
	echo "<optgroup label=\"Active\">\n";
	$result = mysqli_query("SELECT * FROM aircraft WHERE active=1 ORDER BY tailnumber ASC");
	while($row = mysqli_fetch_array($result)) {
		echo "<option value=\"" . $row['id'] . "\">" . $row['tailnumber'] . " - " . $row['makemodel'] . "</option>\n";
	}
	echo "</optgroup>\n";
	echo "<optgroup label=\"Inactive\">\n";
	$result = mysqli_query("SELECT * FROM aircraft WHERE active=0 ORDER BY tailnumber ASC");
	while($row = mysqli_fetch_array($result)) {
		echo "<option value=\"" . $row['id'] . "\">" . $row['tailnumber'] . " - " . $row['makemodel'] . "</option>\n";
	}
	echo "</optgroup>\n";
	echo "</select>\n";
}

?>