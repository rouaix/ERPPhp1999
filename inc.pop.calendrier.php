<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("securite.php")){include("securite.php");}

if(count($_GET)){
   while (list($key, $val) = each($_GET)){
      if($val!=""){$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');}else{unset($_SESSION[$key]);}
   }
}

if(count($_POST)){
   while (list($key, $val) = each($_POST)){
      if($val!=""){$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');}else{unset($_SESSION[$key]);}
   }
}

unset($_GET);
unset($_POST);

if(file_exists("inc.config.php")){include("inc.config.php");}
?>
<img class="fenetre" id="fermer" src="images/jpg/x.jpg" title="Fermer" onclick="javascript:voir('pop');">
<table cellpadding="0" cellspacing="0" border="0" style="width:100%;height:100%;">
<tr>
<td width="100%" height="100%" id="milieu">
<form style="margin:10px;" enctype="multipart/form-data" method="post" action="index.php">
<?php
if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){
  $_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
}
$jour = mktime(0, 0, 0, date("m",$_SESSION["jour"]),1, date("Y",$_SESSION["jour"]));
$ligne = 1;
$colone = 1;
$code = "<tr>\n";
$semaine = false ;
if(date("w",$jour)!=0){$jour = mktime(0, 0, 0, date("m",$jour), date("d",$jour)-date("w",$jour), date("Y",$jour));}else{$jour = mktime(0, 0, 0, date("m",$jour), date("d",$jour)-7, date("Y",$jour));}
while ($ligne <= 6){
   $joura=0;
   while ($colone <= 7){
      $jour = mktime(0, 0, 0, date("m",$jour), date("d",$jour)+1, date("Y",$jour));
      $zz =date("W",$jour);      
      if ($zz < 10){$zz = "".$zz;}
      $titre= "title=\"".date("d",$jour)."/".date("m",$jour)."/".date("Y",$jour)."\"";
      if(date("m",$jour)==date("m") && date("Y",$jour)==date("Y")){
         $joura++;
         if(date("d",$jour)==date("d") && date("m",$jour)==date("m") && date("Y",$jour)==date("Y")){
            $styleid="jour";
            $semaine = true;
         }else{
            if(date("m",$jour)==date("m") && date("Y",$jour)==date("Y")){
              $styleid="mois";
            }else{$styleid="";}               
         }
      }else{$styleid="";}
      $lien ="javascript:setvaleurid('".$_SESSION["origine"]."','".date_numerique($jour)."');voir('pop');";
      //$lien = $_SESSION["lien"]."?jour=".$jour."&voir=jour";
      $code .= "<td id=\"milieu\"><a href=\"$lien\" id=\"".$styleid."\">".date("d",$jour)."</a></td>\n";
      $colone++;
   }
   $colone = 1;
   $ligne++;
   if($semaine){
      $styleid="semaine";
      $semaine = false;
    }else{
      $styleid="mois";
      
      if($joura == 0){$styleid="";}
   }
   //$lien = $_SESSION["lien"]."?semaine=".$zz."&jour=".$jour."&voir=semaine";
   $code .= "<td id=\"milieu\" style=\"border-left:1px solid #cccccc;\">";
   //$code .= "<p class=\"cal\" id=\"".$styleid."\">";
   $code .= $zz;
   //$code .= "</p>";
   $code .= "</td>\n";
   if($ligne > 6 ){$code .= "</tr>\n";}else{$code .= "</tr>\n<tr>\n";}
}
?>
<table class="table" style="width:250px;height:200px;">
<tr>
<td colspan="8" id="milieu"><?php
$lien = "onClick=\"javascript:ajaxpage('".$_SESSION["location"]."scripts/inc.pop.calendrier.php?origine=".$_SESSION["origine"]."&jour=";
$lien .= mktime(0, 0, 0, date("m",$_SESSION["jour"])-1, date("d",$_SESSION["jour"]), date("Y",$_SESSION["jour"]));
$lien .= "','pop');loadobjs();\"";
?><img <?php echo $lien;?> src="../images/jpg/fg.jpg" id="i12">&nbsp;
<?php echo mois_texte($_SESSION["jour"])."&nbsp;".date("Y",$_SESSION["jour"]);?>
<?php 
$lien = "onClick=\"javascript:ajaxpage('".$_SESSION["location"]."scripts/inc.pop.calendrier.php?origine=".$_SESSION["origine"]."&jour=";
$lien .= mktime(0, 0, 0, date("m",$_SESSION["jour"])+1, date("d",$_SESSION["jour"]), date("Y",$_SESSION["jour"]));
$lien .= "','pop');loadobjs();\"";
?>&nbsp;<img <?php echo $lien;?> src="../images/jpg/fd.jpg" id="i12">
</td>
</tr>
<tr>
<td id="milieu">L</td>
<td id="milieu">M</td>
<td id="milieu">M</td>
<td id="milieu">J</td>
<td id="milieu">V</td>
<td id="milieu">S</td>
<td id="milieu">D</td>
<td id="milieu" style="width:50px;">Sem.</td>
</tr>
<?php 
echo $code; 
unset($_SESSION["origine"]);
?>
</table>




</form>
</td>
</tr>
</table>
<?php
unset($_SESSION["origine"]);
?>
