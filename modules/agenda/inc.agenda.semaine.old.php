<?php
@session_start();
if(file_exists("securite.php")){include("securite.php");}
connexionmysql();

  $xjour = mktime(0, 0, 0, date("n",$_SESSION["jour"]),date("j",$_SESSION["jour"]), date("Y",$_SESSION["jour"]));
  if(date("N",$xjour)!= 7){
    $xjour = mktime(0, 0, 0, date("n",$xjour), (date("j",$xjour)-date("N",$xjour))+1, date("Y",$xjour));
  }else{
    $xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)-6, date("Y",$xjour));
  }

  $_SESSION["jour"] = $xjour;
  $liste = cherche_evenement();
  $xsemaine = num_semaine($xjour);

  echo "<table>\n";
  echo "<tr>\n";
  echo "<td>&nbsp;</td>\n";

    for($lejournum = 1;$lejournum < 8;$lejournum ++) {
      echo "<td class=\"agenda\" id=\"titre\" align=\"center\">";
      echo "<a class=\"agenda\" title=\"Ajouter un évènement\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=modifieragenda&modifier=nouveau&jour=".$xjour."&form_heuredebut=00:00&form_heurefin=00:30','surpopup');loadobjs();\">";
      echo "<img src=\"".$_SESSION["ico"]["ajouter"]."\" class=\"agenda\">";
      echo "</a>";
      echo "<a class=\"agenda\" title=\"Voir ce jour\" href=\"".$_SESSION["lien"]."?jour=".$xjour."&voir=jour\">".jour_texte_num($lejournum)." ".date("d",$xjour)."</a>";
      echo "</td>\n";
      if($lejournum == 7){$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)-6, date("Y",$xjour));}else{$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)+1, date("Y",$xjour));}
    }
  echo "</tr>\n";

  if(@$_SESSION["tout"] != "o"){
    $hjour = strtolower(jour_texte($_SESSION["jour"]));
    //if(!isset($_SESSION["preference"][$hjour])){cherche_preference();}
    if(isset($_SESSION["preference"][$hjour])){
      $temp = explode(":",$_SESSION["preference"]["jour"][$hjour][1]["debut"]);
      $_SESSION["debut_agenda"] = $temp[0];
      $temp = explode(":",$_SESSION["preference"]["jour"][$hjour][$_SESSION["preference"]["compteur"][$hjour]]["fin"]);
      $_SESSION["fin_agenda"] = $temp[0];
    }
  }else{
    $_SESSION["debut_agenda"] = 0;
    $_SESSION["fin_agenda"] = 23;
  }

  for($h = $_SESSION["debut_agenda"];$h <= $_SESSION["fin_agenda"];$h ++) {
    $heure = str_pad($h, 2, "0", STR_PAD_LEFT);
    echo "<tr>\n";
    echo "<td class=\"agenda\" id=\"semaine\">".$heure.":00</td>\n";
    for($lejournum = 1;$lejournum < 8;$lejournum ++) {
      //if(verif_heuredetravail($lejournum,$h,)){$style = " id=\"travail\"";}else{$style = "";}
      echo "<td class=\"agenda\">";
      affiche_minute_semaine($liste,$xjour,$h);
      echo "</td>\n";
      if($lejournum == 7){$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)-6, date("Y",$xjour));}else{$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)+1, date("Y",$xjour));}
    }
    echo "</tr>\n";
  }

  echo "<tr>\n";
  echo "<td>&nbsp;</td>\n";
  for($lejournum = 1;$lejournum < 8;$lejournum ++) {
    echo "<td class=\"agenda\">";
    echo "&nbsp;";
    echo "</td>\n";
  }
  echo "</tr>\n";
  echo "</table>\n";

function affiche_minute_semaine($liste,$xjour,$h){
  $m = 1;
  do {
    if($m == 1 or $m == 16 or $m == 31){
      $style = " style=\"border-bottom:1px solid #eee;\"";
    }else{
      $style = "";
    }
    if(verif_heuredetravail($h,$m,$xjour)){
      //$hstyle = " id=\"travail\"";
      reset($_SESSION["categorie"]);
      $couleur = "ffffBB;";
      while (list($key, $val) = each($_SESSION["categorie"])){
        if($val["nom"] == "Jour"){$couleur = $val["contenu"];}
      }
      $hstyle = " style=\"background-color:#".$couleur."\"";
    }else{
      $hstyle = "";
    }
    echo "<div class=\"agenda\" id=\"quart\"".$hstyle.">";
    //echo "<div".$style.">";
    echo affiche_evenement_semaine($liste,$xjour,$h,$m);
    //echo "</div>";
    echo "</div>\n";
    $m += 15;
  } while ($m <= 46);
}

function affiche_evenement_semaine($liste,$xjour,$h,$m){
  $temp_code = "";
  if(isset($liste)){
    reset($liste);
    while (list($key, $val) = each($liste)){
      if (verif_evenement_semaine($val,$xjour,$h,$m)){
        if(isset($_SESSION["categorie"][$val["categorie"]])){
          $couleur = $_SESSION["categorie"][$val["categorie"]]["contenu"];
        }else{
          $couleur = "ddd";
        }
        $style ="background-color:#".$couleur.";";
        if($val["nom"]!=""){
          $titre = " title=\"".$val["nom"]." => Du ".$val["debut"]." Au ".$val["fin"]."\"";
        }else{
          $titre="";
        }
        $temp_code .= "<a class=\"agenda\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=modifieragenda&modifier=".$val["id"]."','surpopup');loadobjs();\">";
        $temp_code .= "<div class=\"agenda\" id=\"evenement\" style=\"background-color:#".$couleur.";\"".$titre.">";
        //$temp_code .= "<img src=\"images/png/carre-vert10.png\" border=\"0\" class=\"agenda\" id=\"evenement\">";
        $temp_code .= "&nbsp;&nbsp;";
        $temp_code .= "</div>";
        $temp_code .= "</a>\n";
        $ok = false;
      }
    }
  }
  $temp_code .= "&nbsp;";
  return $temp_code;
}

function verif_evenement_semaine($val,$xjour,$h,$m){
  $ok = false;
  $xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour), date("Y",$xjour));
  $debut = mktime(0, 0, 0, $val["debut_mois"], $val["debut_jour"], $val["debut_annee"]);
  $fin = mktime(0, 0, 0, $val["fin_mois"], $val["fin_jour"], $val["fin_annee"]);
  
  if($debut < $xjour && $fin > $xjour){$ok = true;}
  if($debut == $xjour && $fin > $xjour){
    if($val["debut_heure"] < $h){$ok = true;}
    if($val["debut_heure"] <= $h){
      if($val["debut_minute"] < $m){$ok = true;}
    }
  }
  if($debut < $xjour && $fin == $xjour){
    if($val["fin_heure"] > $h){$ok = true;}
    if($val["fin_heure"] == $h){
      if($val["fin_minute"] > $m){$ok = true;}
    }
  }
  if($debut == $xjour && $fin == $xjour){
    if($val["debut_heure"] < $h && $val["fin_heure"] > $h){$ok = true;}
    if($val["debut_heure"] == $h){
      if($val["debut_minute"] < $m){
        if($val["fin_heure"] > $h){$ok = true;}
      }
    }
    if($val["fin_heure"] == $h){
      if($val["fin_minute"] > $m){
        if($val["debut_heure"] < $h){$ok = true;}
      }
    }
    if($val["debut_heure"] <= $h && $val["fin_heure"] >= $h){
      if($val["debut_minute"] <= $m && $val["fin_minute"] >= $m){$ok = true;}
    }
  }
  return $ok;
}
?>
