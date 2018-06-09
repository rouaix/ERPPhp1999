<?php
if (file_exists("securite.php")){include("securite.php");}
if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
$jourh = mktime(0, 0, 0, date("n", $_SESSION["jour"]),1, date("Y",$_SESSION["jour"]));
$maintenant = mktime(0, 0, 0, date("n"), date("j"), date("Y"));
if(date("N",$jourh)!= 7){$jourh = mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)-date("N",$jourh)+1, date("Y",$jourh));}else{$jourh = mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)-6, date("Y",$jourh));}
$semaine = date("W",$jourh);
$mois = date("n",$maintenant);

$tstyle = categorie("","Jour");

$code = "<tr>\n";
$evenements = cherche_evenement();

for($ligne = 1;$ligne < 7;$ligne ++){
  $mois_actif = false;
  $jour_mois = false;
  $semaine_active = false;
  $semaine_evenement = false;
  $semaine = date("W",$jourh);
  for($colone = 1;$colone < 8;$colone ++){
    $jourh_actif = false;
    $jourh_evenement = false;
    $jour_mois = false;
    if($jourh == $maintenant){$jourh_actif = true;}
    if($semaine == date("W",$maintenant)){$semaine_active = true;}
    if(date("n",$jourh)== date("n") && date("Y",$jourh) == date("Y")){$mois_actif = true;}
    $titre = "title=\"".date("d",$jourh)."/".date("m",$jourh)."/".date("Y",$jourh)."\"";        
    $event = "";
    if(isset($evenements)&& is_array($evenements)){
      reset($evenements);
      while (list($key, $val) = each($evenements)){
        if(date("Ymd",strtotime($val["debut_agenda"])) == date("Ymd",$jourh) && date("Ymd",strtotime($val["fin_agenda"])) == date("Ymd",$jourh)){
          $jourh_evenement = true;
          $semaine_evenement = true;
        }
        if(date("Ymd",strtotime($val["debut_agenda"])) < date("Ymd",$jourh) && date("Ymd",strtotime($val["fin_agenda"])) == date("Ymd",$jourh)){
          $jourh_evenement = true;
          $semaine_evenement = true;
        }
        if(date("Ymd",strtotime($val["debut_agenda"])) == date("Ymd",$jourh) && date("Ymd",strtotime($val["fin_agenda"])) > date("Ymd",$jourh)){
          $jourh_evenement = true;
          $semaine_evenement = true;
        }
        if(date("Ymd",strtotime($val["debut_agenda"])) < date("Ymd",$jourh) && date("Ymd",strtotime($val["fin_agenda"])) > date("Ymd",$jourh)){
          $jourh_evenement = true;
          $semaine_evenement = true;
        }
        if(date("Ymd",strtotime($val["debut_agenda"])) <= date("Ymd",$jourh) && date("Ymd",strtotime($val["fin_agenda"])) >= date("Ymd",$jourh)){
          $event .= "<div class=\"module\" id=\"block\" ".categorie($val,"b").">";
          $event .= lien_editer($val);
          //$event .= ucfirst($val["nom_agenda"]);
          $event .= "<p class=\"module\">";
          if($val["info_agenda"] != ""){$event .= "".ucfirst(nl2br($val["info_agenda"]))."";}
          if(date("Ymd",strtotime($val["debut_agenda"])) == date("Ymd",$jourh) && date("Ymd",strtotime($val["fin_agenda"])) == date("Ymd",$jourh)){
            $event .= "<p class=\"module\" id=\"droite\">";
            $event .= "<i class=\"module\">";
            $event .= date("H:i",strtotime($val["debut_agenda"]))." - ".date("H:i",strtotime($val["fin_agenda"]));
            $event .= "</i>";
          }else{
            $event .= "<p class=\"module\" id=\"droite\"><i class=\"module\">".date("d/m/Y H:i",strtotime($val["debut_agenda"]))."";
            $event .= "<br>".date("d/m/Y H:i",strtotime($val["fin_agenda"]))."</i>";
          }
          $event .= "</div>\n";
        }
      }
    }
    if($jourh_evenement == true){$styleid="id=\"even\"";}else{$styleid="";}
    if(date("n",$jourh) == $mois){$style = $tstyle;}else{$style="";}
    if($jourh == $_SESSION["jour"]){$style = "id=\"actif\"";}

    $liens = "?jour=".$jourh."&page=agenda&vue=jour";
    $code .= "<td class=\"module\" ".$style." style=\"width:15%;height:40px;\" id=\"nom\">";
    $code .= "<a href=\"".$_SESSION["lien"].$liens."\" class=\"module\" ".$styleid." title=\"Voir ce jour\">";
    //$code .= "<div class=\"module\">";
    $code .= date("d",$jourh);
    //$code .= "</div>";
    $code .= "</a>";
    if($event==""){$event = "<div style=\"height:20px;\">&nbsp;</div>";}
    $code .= $event;
    $code .= "</td>\n";
    unset($liens);
    $jstyle="";
    $jourh = mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)+1, date("Y",$jourh));
  }
  if($semaine_active){$style = $tstyle;}else{$style="";}
  if($semaine == date("W",$_SESSION["jour"])){$style="id=\"sactif\"";}
  $jourlien = mktime(0, 0, 0, date("n",$jourh), date("j",$jourh)-7, date("Y",$jourh));
  //$liens = "?semaine=".$semaine."&jour=".$jourlien."&page=agenda&vue=semaine";
  //$code .= "<td class=\"module\" ".$style." id=\"semaine\"><a href=\"".$_SESSION["lien"].$liens."\" ".$styleid."><h4>".$semaine."</h4></a></td>\n";
  if($ligne > 6 ){$code .= "</tr>\n";}else{$code .= "</tr>\n<tr>\n";}
  unset($liens);  
}
unset($evenements);
unset($listes);
?>
<table  style="width:100%;border-collapse:separate;border-spacing:1px;clear:both;">
<tr>
<td class="module">Lundi</td>
<td class="module">Mardi</td>
<td class="module">Mercredi</td>
<td class="module">Jeudi</td>
<td class="module">Vendredi</td>
<td class="module">Samedi</td>
<td class="module">Dimanche</td>
</tr>
<?php echo $code; ?>
</table>
