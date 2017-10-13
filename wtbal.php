<? include 'func.inc';
   PageHeader($config['site_name']); ?>

<?
if ($_REQUEST['tailnumber']=="") {
// NO AIRCRAFT SPECIFIED, SHOW ACTIVE AIRCRAFT LIST

	echo "<body>\n";
	echo "<table border=\"1\" cellpadding=\"3\" width=\"700\" align=\"center\">\n";
	echo "<tr><td>\n";
	echo "<h2>" . $config['site_name'] . "</h2>\n";
	echo "<p>Select aircraft tail number.</p>\n";

	echo "<form method=\"get\" action=\"wtbal.php\">\n";
	AircraftListActive();
	echo "<input type=\"submit\" value=\"Go\"></form>\n";

	echo "</td></tr></table>\n";

} else {
// AIRCRAFT SELECTED, DO WEIGHT & BALANCE

	// GET AIRCRAFT INFORMATION
	$aircraft_result = mysql_query("SELECT * FROM aircraft WHERE id=" . $_REQUEST['tailnumber']);
	$aircraft = mysql_fetch_assoc($aircraft_result);

?>


<script type="text/javascript">

<!-- Hide script
function WeightBal() {
  var df = document.forms[0];

<?

$weights_query = mysql_query("SELECT * FROM aircraft_weights WHERE tailnumber = " . $aircraft['id'] . " ORDER BY 'order' ASC");
while($weights = mysql_fetch_assoc($weights_query)) {
	if ($weights['fuel']=="true") {
		echo "df.line" . $weights['id'] . "_gallons.value = ";
			if (empty($_GET["line" . $weights['id'] . "_gallons"])) {echo($weights['weight']);} else { echo($_GET["line" . $weights['id'] . "_gallons"]); }
			echo ";\n";
		echo "df.line" . $weights['id'] . "_wt.value = ";
			if (empty($_GET["line" . $weights['id'] . "_gallons"])) {echo(($weights['weight'] * $weights['fuelwt']));} else {echo(($_GET["line" . $weights['id'] . "_gallons"] * $weights['fuelwt']));}
			echo ";\n";
	} else {
	echo "df.line" . $weights['id'] . "_wt.value = ";
		if (empty($_GET["line" . $weights['id']])) {echo($weights['weight']);} else { echo($_GET["line" . $weights['id']]); }
		echo  ";\n";
	}
	echo "df.line" . $weights['id'] . "_arm.value = (" . $weights['arm'] . ").toFixed(1);\n\n";
}

?>

  Process();
}

function Process() {
  var df = document.forms[0];

<?

$weights_query = mysql_query("SELECT * FROM aircraft_weights WHERE tailnumber = " . $aircraft['id'] . " ORDER BY 'order' ASC");
while($weights = mysql_fetch_assoc($weights_query)) {
	if ($weights['fuel']=="true") {
		echo "var line" . $weights['id'] . "_gallons = df.line" . $weights['id'] . "_gallons.value;\n";
		echo "var line" . $weights['id'] . "_wt = line" . $weights['id'] . "_gallons * " . $weights['fuelwt'] . ";\n";
		echo "df.line" . $weights['id'] . "_wt.value = line" . $weights['id'] . "_gallons * " . $weights['fuelwt'] . ";\n";
	} else {
		echo "var line" . $weights['id'] . "_wt = df.line" . $weights['id'] . "_wt.value;" . "\n";
	}
	echo "var line" . $weights['id'] . "_arm = df.line" . $weights['id'] ."_arm.value;" . "\n";
	echo "var line" . $weights['id'] . "_mom = line" . $weights['id'] . "_wt * line" . $weights['id'] . "_arm;\n";
	echo "df.line" . $weights['id'] . "_mom.value = line" . $weights['id'] . "_mom.toFixed(1);\n\n";
	$momentlist[0] = $momentlist[0] . " -line" . $weights['id'] . "_mom";
	$wtlist[0] = $wtlist[0] . " -line" . $weights['id'] . "_wt";
}
echo "var totmom = -1 * (" . print_r($momentlist[0],TRUE) . ");\n";
echo "df.totmom.value = totmom.toFixed(1);\n";

echo "var totwt = -1 * (" . print_r($wtlist[0],TRUE) . ");\n";
echo "df.totwt.value = totwt.toFixed(1);\n\n";

echo "var totarm = totmom / totwt;\n";
echo "df.totarm.value = Math.round(totarm*100)/100;\n\n";

echo "var w1 = " . $aircraft['maxwt'] . ";\n";
echo "var c1 = " . $aircraft['cgwarnfwd'] .";\n";
echo "var w2 = " . $aircraft['emptywt'] . ";\n";
echo "var c2 = " . $aircraft['cgwarnaft'] . ";\n";
echo "var overt  = Math.round(totwt - " . $aircraft['maxwt'] . ");\n\n";
  
echo "document.wbimage.src = 'scatter.php?tailnumber=" . $aircraft['id'] . "&totarm=' + totarm + '&totwt=' + totwt;\n";

?>

// WARNINGS
if  (parseFloat(Math.round(totwt))>w1) {
        var message = "\nBased on the provided data,\n"
            message += "this aircraft will be overweight at takeoff!\n"
       alert(message + "By " + overt + " lbs. ")
        inuse_flag = false
    }

if  (parseFloat(Math.round(totarm*100)/100)>c2) {
        var message = "\nBased on the provided data,\n"
        message += "The takeoff CG may be AFT of limits\n"
        message += "for this aircraft. Please check the\n"
        message += "CG limitations as it applies to the\n"
        message += "weight and category of your flight.\n"
        alert(message)
        inuse_flag = false
    }

if  ( (parseFloat(Math.round(totarm*100)/100)>c2)&&
         (parseFloat(Math.round(totarm*100)/100)<c1) &&
          (parseFloat(Math.round(totwt))> (w1 - ((w1-w2)/(c1-c2))*c1 + ((w1-w2)/(c1-c2))*(parseFloat(Math.round(totarm*100)/100)))))
            {
        var message = "\n(1)Based on the provided data,\n"
        message += "The takeoff CG may be FWD of limits\n"
        message += "for this aircraft. Please check the\n"
        message += "CG limitations as it applies to the\n"
        message += "weight and category of your flight.\n"
        alert(message)
        inuse_flag = false
    }

if  (parseFloat(Math.round(totarm*100)/100)<c1) {
        var message = "\n(2)Based on the provided data,\n"
        message += "The takeoff CG may be FWD of limits\n"
        message += "for this aircraft. Please check the\n"
        message += "CG limitations as it applies to the\n"
        message += "weight and category of your flight.\n"
        alert(message)
        inuse_flag = false
    }
 } 
// -->

isamap = new Object();
isamap[0] = "_df"
isamap[1] = "_ov"
isamap[2] = "_ot"
isamap[3] = "_dn"

</script>
</head>

<body bgcolor="#FFFFFF" onload="WeightBal();">

<center><table border="1" cellpadding="3" width="700">
<tr>
	<td colspan="4" rowspan="6">

<h2><? echo $config['site_name'] . "<br>" . $aircraft['makemodel'] . " " . $aircraft['tailnumber'];
	echo "<div class=\"noprint\"><input type=\"button\" value=\"Choose Another Aircraft\" class=\"noprint\" style=\"vertical-align: middle\" onClick=\"parent.location='wtbal.php'\"></div>"; ?></h2>
	
	<FORM method="get" action="wtbal.php"><input type="hidden" name="tailnumber" value="<? echo($aircraft['id']); ?>">

<p class="noprint"><font size="-1"><b><i>Replace default weights with your actual weights, then click "Calculate".</i></b></p>

<p><b>PILOT SIGNATURE  X__________________________________________________</b><br>
<font size="-2">The Pilot In Command is responsible for ensuring all calculations are correct and safe before conducting flight activities.</font><br>
<? date_default_timezone_set($config['timezone']); echo date("D, j M Y H:i:s T"); ?></font>
</td>

	<th>Empty Wt</th>
</tr>
<tr><td><font size="-1"><center><? echo $aircraft['emptywt']; ?></center></font></td></tr>
<tr><th>Empty CG</th></tr>
<tr><td><font size="-1"><center><? echo $aircraft['emptycg']; ?></center></font></td></tr>
<tr><th>MGW</th></tr>
<tr><td><font size="-1"><center><? echo $aircraft['maxwt']; ?></center></font></td></tr>
		
<tr>
<th width="40%" colspan="2">Item</th>
<th width="20%">Weight</th>
<th width="20%">Arm</th>
<th width="20%">Moment</th>

<?

$weights_query = mysql_query("SELECT * FROM aircraft_weights WHERE tailnumber = " . $aircraft['id'] . " ORDER BY  `aircraft_weights`.`order` ASC");
while($weights = mysql_fetch_assoc($weights_query)) {
	echo "<tr><td";
	if ($weights['fuel']=="false") {
		echo " colspan=\"2\"";
	}
	echo "><font size=\"-1\">" . $weights['item'] . "</font></td>\n";
	if ($weights['fuel']=="true") {
		echo "<td align=\"right\"><input type=\"number\" step=\"any\" name=\"line" . $weights['id'] . "_gallons\" tabindex=\"" . $tabindex . "\" onblur=\"Process()\" class=\"numbergals\">";
		echo "<FONT SIZE=\"-1\">Gallons</FONT></TD>";
		echo "<td align=\"center\"><input type=\"number\" name=\"line" . $weights['id'] . "_wt\" readonly class=\"readonly numbers\"></td>\n";
	} else {
		if ($weights['emptyweight']=="true") {
			echo "<td align=\"center\"><input type=\"number\" name=\"line" . $weights['id'] . "_wt\" readonly class=\"readonly numbers\"></td>\n";
		} else {
			echo "<td align=\"center\"><input type=\"number\" step=\"any\" name=\"line" . $weights['id'] . "_wt\" tabindex=\"" . $tabindex . "\" onblur=\"Process()\" class=\"numbers\"></td>\n";
		}
	}
	echo "<td align=\"center\"><input type=\"number\" name=\"line" . $weights['id'] . "_arm\" readonly class=\"readonly numbers\"></td>\n";
	echo "<td align=\"center\"><input type=\"number\" name=\"line" . $weights['id'] . "_mom\" readonly class=\"readonly numbers\"></td></tr>\n\n";
	$tabindex++;
}

?>

<tr bgcolor="#FFFF80">
<td align="right" colspan="2"><b>Totals</b></td>

<td align="CENTER"><input type="number" name="totwt" readonly class="readonly numbers"></TD>
<td align="right">&nbsp;</td>
<td align="CENTER"><input type="number" name="totmom" readonly class="readonly numbers"></TD>
</TR>

<tr bgcolor="#FFFF80">
<td colspan="2">
	<font size="-1"><b>CG limits: </b></font>
	<font size="-1" face="courier"><? echo $aircraft['cglimits']; ?></font></td>
<TD COLSPAN=1 ALIGN="Right"><B>Takeoff C.G.</B></TD>
<TD align="center"><input type="number" name="totarm" maxlength="5" readonly class="readonly numbers"></TD>
<td>&nbsp;</td>
</tr>

<tr class="noprint">
<td COLSPAN=5>
<center><input type="submit" name="Submit" value=" Calculate " tabindex="<? echo($tabindex); $tabindex++; ?>" onClick="Process()">&nbsp;&nbsp;
<input type="button" name="Reset" value="Reset" onclick="WeightBal()">&nbsp;&nbsp;
<input type="button" value="Print" onClick="window.print()"></center>

</td></tr>
</TABLE>

<? echo("<img name=\"wbimage\">"); ?>
</center>
</FORM>

<?
}
?>

<? PageFooter($config['administrator'],$ver);
mysql_close($con);
?>