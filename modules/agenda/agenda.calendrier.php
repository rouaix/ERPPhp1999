<?php
//if (file_exists("securite.php")){include("securite.php");}

if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
$jourh = mktime(0, 0, 0, date("n", $_SESSION["jour"]),1, date("Y",$_SESSION["jour"]));
$maintenant = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
if(date("N",$jourh)!= 7){$jourh = mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)-date("N",$jourh)+1, date("Y",$jourh));}else{$jourh = mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)-6, date("Y",$jourh));}
$semaine = date("W",$jourh);
$style="";

$code = "<tr>\n";
$results = mysql_query("select * from agenda where id_user='".$_SESSION["userid"]."' and etat_agenda=''");
if($results){
  while ($lignes = mysql_fetch_array($results)){
    $evenements[$lignes["id_agenda"]] = $lignes;
  }
}
unset($lignes);
$jstyle="";
for($ligne = 1;$ligne < 7;$ligne ++){
  $mois_actif = false;
  $semaine_active = false;
  $semaine_evenement = false;
  $semaine = date("W",$jourh);

  for($colone = 1;$colone < 8;$colone ++){
    //$jourh = mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)+1, date("Y",$jourh));
    $jourh_actif = false;
    $jourh_evenement = false;    
    $semaine = date("W",$jourh);
    if($jourh == $maintenant){$jourh_actif = true;}
    if($semaine == date("W",$maintenant)){$semaine_active = true;}
    if(date("n",$jourh)==date("n") && date("Y",$jourh)==date("Y")){$mois_actif = true;}
    $titre = "title=\"".date("d",$jourh)."/".date("m",$jourh)."/".date("Y",$jourh)."\"";        
    if(isset($evenements)){
      reset($evenements);    
      while (list($key, $val) = each($evenements)){
        $temp = explode(" ",$val["debut_agenda"]);
        $xdebut = explode("-",$temp[0]);
        $xdatedebut = mktime(0, 0, 0, $xdebut[1],$xdebut[2], $xdebut[0]);
        $temp = explode(" ",$val["fin_agenda"]);
        $xfin = explode("-",$temp[0]);
        $xdatefin = mktime(0, 0, 0, $xfin[1],$xfin[2], $xfin[0]);
        if($xdatedebut == $jourh && $xdatefin == $jourh){
          $jourh_evenement = true;
          $semaine_evenement = true;
        }
        if($xdatedebut < $jourh && $xdatefin == $jourh){
          $jourh_evenement = true;
          $semaine_evenement = true;        
        }
        if($xdatedebut == $jourh && $xdatefin > $jourh){
          $jourh_evenement = true;
          $semaine_evenement = true;        
        }
        if($xdatedebut < $jourh && $xdatefin > $jourh){
          $jourh_evenement = true;
          $semaine_evenement = true;        
        }                  
      }
    }   
    if($mois_actif){
      $styleid="noir";
      if($jourh_actif){
        $styleid="orange";        
        if($jourh_evenement == true){
          $styleid="orange";
          //$style = "class=\"alerte\""; 
        }
      }else{
        if($jourh_evenement == true){
          $styleid="bleu";
          //$style = "class=\"alerte\""; 
        }
      }      
    }else{
      if($jourh_evenement == true){
        //$style = "class=\"alerte\""; 
        $styleid="rouge";
      }else{
        $styleid="";
      }
    }    
    if($jourh == $_SESSION["jour"]){$styleid = "bleu";}
    $liens = "?jour=".$jourh."&page=agenda&vue=jour";
    $code .= "<td id=\"milieu\"><a href=\"".$_SESSION["lien"].$liens."\" id=\"".$styleid."\">".date("d",$jourh)."</a></td>\n";
    unset($liens);
    $jstyle="";
    $jourh = mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)+1, date("Y",$jourh));
  }
  if($mois_actif){$styleid="mois";}
  $liens = "?semaine=".$semaine."&jour=".mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)-7, date("Y",$jourh))."&page=agenda&vue=semaine";
  $code .= "<td id=\"milieu\"><a href=\"".$_SESSION["lien"].$liens."\" id=\"".$styleid."\">$semaine</a></td>\n";
  if($ligne > 6 ){$code .= "</tr>\n";}else{$code .= "</tr>\n<tr>\n";}
  unset($liens);  
}
unset($evenements);
unset($listes);
?>
<table class="table" id="milieu">
<tr>
<td colspan="8" id="milieu">
<a href="<?php echo $_SESSION["lien"];?>?jour=<?php echo mktime(0, 0, 0, date("m",$_SESSION["jour"])-1, date("d",$_SESSION["jour"]), date("Y",$_SESSION["jour"]));?>"><img src="<?php echo $_SESSION["ico"]["gauche"];?>" class="module"></a>
<?php echo mois_texte($_SESSION["jour"])."&nbsp;".date("Y",$_SESSION["jour"])."&nbsp;";?>
<a href="<?php echo $_SESSION["lien"];?>?jour=<?php echo mktime(0, 0, 0, date("m",$_SESSION["jour"])+1, date("d",$_SESSION["jour"]), date("Y",$_SESSION["jour"]));?>"><img src="<?php echo $_SESSION["ico"]["droite"];?>" class="module"></a>
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
<td id="milieu" style="cursor:pointer" title="La num&eacute;rotation des semaines commence le 1er Lundi de l'ann&eacute;e.">Sem.</td>
</tr>
<?php echo $code; ?>
</table>