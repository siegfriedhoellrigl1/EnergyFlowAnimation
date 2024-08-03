<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="5">
    <title>Energy Flow</title>
  </head>
  <body bgcolor="darkgrey">
<?php
 $dat=file_get_contents("http://10.0.9.6/uebersicht/index.php");
 preg_match('#BKW Prod. :.*\+.(.*)#', $dat, $match);
// echo "match = ".$match[1];
 preg_match('#\=(.[-0-9]+)\s(.*)#',$match[1],$match1);
 $solar = $match1[1]; if ($solar=="") $solar=0;
// echo "Solar = ".$solar;

 preg_match('#Leistung   : (.*)#', $dat, $match);
 preg_match('#(.*)\\ W(.*)#',$match[1],$match1);
 $netz = $match1[1];

// echo "netz = ".$match[1];

 $haus=$netz+$solar;
 $batterie=0;
?>



<object data="EnergyFlow.svg" type="image/svg+xml" width="500" id="EnergyFlowSvg"></object>


<script>

var EnergyFlow;

document.getElementById("EnergyFlowSvg").addEventListener("load", function() {
   EnergyFlow = document.getElementById("EnergyFlowSvg").contentDocument;
   EnergyFlow.SetBatteryStateOfCharge(0, 12.3);
   EnergyFlow.Animation(<?php echo $haus;?>, 'Home',    true,   10000);
   EnergyFlow.Animation(<?php echo 0; ?>, 'Battery', true,   1000);
   EnergyFlow.Animation(<?php echo $solar; ?>, 'Solar',   false, 10000);
   EnergyFlow.Animation(<?php echo $netz; ?>, 'Grid',    false,  10000); 
});


</script>

  </body>
  <a href=".">Zurück</a>
  <?php print $dat; ?>
</html>
