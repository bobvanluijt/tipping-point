<?php
include 'func.inc.php';
// GET AIRCRAFT CG DATA
$result = mysqli_query($GLOBALS['dbLink'], "SELECT * FROM aircraft_cg WHERE tailnumber=" . $_REQUEST['tailnumber']);
while($row = mysqli_fetch_array($result)) {
	$arm[] = $row['arm'];
	$weight[] = $row['weight'];
}
	// We have to add the first point back to the end so we have a connected graph
	$arm[] = $arm[0];
	$weight[] = $weight[0];


 /* CAT:Scatter chart */

 /* pChart library inclusions */
 include("pChart/class/pData.class.php");
 include("pChart/class/pDraw.class.php");
 include("pChart/class/pImage.class.php");
 include("pChart/class/pScatter.class.php");

 /* Create the pData object */
 $myData = new pData();

 /* Create the X axis and the binded series */
 $myData->addPoints($arm,"EnvelopeCG");
 $myData->setSerieOnAxis("EnvelopeCG",0);
 $myData->setAxisName(0,"Inches From Reference Datum");
 $myData->setAxisXY(0,AXIS_X);
 $myData->setAxisUnit(0,"\"");
 $myData->setAxisPosition(0,AXIS_POSITION_BOTTOM);

 /* Create the Y axis and the binded series */
 $myData->addPoints($weight,"EnvelopeWeight");
 $myData->setSerieOnAxis("EnvelopeWeight",1);
 $myData->setAxisName(1,"Pounds");
 $myData->setAxisXY(1,AXIS_Y);
 $myData->setAxisPosition(1,AXIS_POSITION_LEFT);

 /* Create the 1st scatter chart binding */
 $myData->setScatterSerie("EnvelopeCG","EnvelopeWeight",0);
 $myData->setScatterSerieDescription(0,"CG Envelope");
 $myData->setScatterSerieColor(0,array("R"=>0,"G"=>0,"B"=>255));

 /* Draw the background */
 $Settings = array("R"=>0, "G"=>0, "B"=>0, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107);

 if ($_REQUEST['size']=="small") {
	/* Create the pChart object */
 	$myPicture = new pImage(400,195,$myData);
	/* Draw the background */
	$myPicture->drawRectangle(0,0,399,194,$Settings);
	/* Set the graph area */
	$myPicture->setGraphArea(50,25,375,135);
 } else {
	/* Create the pChart object */
	$myPicture = new pImage(700,340,$myData);
	/* Draw the background */
	$myPicture->drawRectangle(0,0,699,339,$Settings);
	/* Set the graph area */
	$myPicture->setGraphArea(50,25,675,280);
 }

 /* Set the default font */
 $myPicture->setFontProperties(array("FontName"=>"pChart/fonts/verdana.ttf","FontSize"=>8));

 /* Create the Scatter chart object */
 $myScatter = new pScatter($myPicture,$myData);

 /* Draw the scale */
 $myScatter->drawScatterScale();

 /* Turn on shadow computing */
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10));

 /* Draw a scatter line chart */
  $myScatter->drawScatterLineChart();



 //caleb
 /* Draw a scatter plot chart */
$myData->setSerieDrawable(0,FALSE);

  /* Create the X axis and the binded series */
 $myData->addPoints($_GET["totarm"],"MyCG");
 $myData->setSerieOnAxis("MyCG",0);

 /* Create the Y axis and the binded series */
 $myData->addPoints($_GET["totwt"],"MyWeight");
  $myData->setSerieOnAxis("MyWeight",1);

 /* Create the 2nd scatter chart binding */
 $myData->setScatterSerie("MyCG","MyWeight",1);
 $myData->setScatterSerieDescription(1,"My CG");
 $myData->setScatterSerieColor(1,array("R"=>255,"G"=>0,"B"=>0));

 /* Create data value label */
 $LabelSettings = array("Decimals"=>1,"NoTitle"=>TRUE);
 $myScatter->writeScatterLabel(1,0,$LabelSettings);

/* Draw a scatter plot chart */
$myScatter->drawScatterPlotChart();



 /* Render the picture (choose the best way) */
 $myPicture->stroke();
?>