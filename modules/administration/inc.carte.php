<?php
if (file_exists("securite.php")){include("securite.php");}
if(!isset($_SESSION["carte"])){$_SESSION["carte"]="site";}else{
  if($_SESSION["carte"]==""){$_SESSION["carte"]="site.mm";}
}
echo "<div style=\"position:relative;overflow:hidden;display:block;\">";
echo "<h3>Carte mentale</h3>";
echo "
	<div id=\"flashcontent\" style=\"position:relative;margin-top:5px;margin-left:2px;height:700px;border:1px solid #222222;\">
		 Flash plugin or Javascript are turned off.
		 Activate both  and reload to view the mindmap
	</div>	
	<script type=\"text/javascript\">
		function getMap(map){
		  var result=map;
		  var loc=document.location+'';
		  if(loc.indexOf(\".mm\")>0 && loc.indexOf(\"?\")>0){
			result=loc.substring(loc.indexOf(\"?\")+1);
		  }
		  return result;
		}
		var fo = new FlashObject(\"".$_SESSION["location"]."scripts/visorFreemind.swf\", \"visorFreeMind\", \"100%\", \"100%\", 6, \"#ffffff\");
		fo.addParam(\"quality\", \"high\");
		fo.addParam(\"bgcolor\", \"#ffffff\");
		fo.addVariable(\"openUrl\", \"_blank\");
		fo.addVariable(\"startCollapsedToLevel\",\"10\");
		fo.addVariable(\"maxNodeWidth\",\"200\");
		fo.addVariable(\"mainNodeShape\",\"rectangle\");
		fo.addVariable(\"justMap\",\"false\");
		fo.addVariable(\"initLoadFile\",getMap('".$_SESSION["location"]."../fichiers/fichiers/fichiers/cartes/".$_SESSION["carte"]."'));
		fo.addVariable(\"defaultToolTipWordWrap\",200);
		fo.addVariable(\"offsetX\",\"left\");
		fo.addVariable(\"offsetY\",\"center\");
		fo.addVariable(\"buttonsPos\",\"top\");
		fo.addVariable(\"min_alpha_buttons\",20);
		fo.addVariable(\"max_alpha_buttons\",100);
		fo.addVariable(\"scaleTooltips\",\"false\");
		fo.write(\"flashcontent\");
		// ]]>
	</script>
  ";
echo "</div>";
?>