<?php

//if(file_exists("securite.php")){include("securite.php");}

//$xjour = mktime(0, 0, 0, date("n",$_SESSION["jour"]),date("j",$_SESSION["jour"]), date("Y",$_SESSION["jour"]));
if(date("N",$xjour)!= 7){
  $xjour = mktime(0, 0, 0, date("n",$xjour), (date("j",$xjour)-date("N",$xjour))+1, date("Y",$xjour));}else{$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)-6, date("Y",$xjour));
}
$xsemaine = date("W",$xjour);
$_SESSION["jour"] = $xjour;
$liste = cherche_evenement();

echo "<table style=\"width:100%;border-collapse:separate;border-spacing:1px;clear:both;\">\n";
echo "<tr>\n";
echo "<td>&nbsp;</td>\n";
for($lejournum = 1;$lejournum < 8;$lejournum ++){
  echo "<td class=\"module\" id=\"block\" style=\"text-align:center\">";
  //echo "<a class=\"module\" title=\"Ajouter un évènement\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=modifieragenda&modifier=nouveau&jour=".$xjour."&form_heuredebut=00:00&form_heurefin=00:30','surpopup');loadobjs();\">";
  //echo "<img src=\"".$_SESSION["ico"]["ajouter"]."\" class=\"module\">";
  //echo "</a>";
  echo "<a class=\"module\" title=\"Voir ce jour\" href=\"".$_SESSION["lien"]."?jour=".$xjour."&vue=jour\">".jour_texte($lejournum)." ".date("d",$xjour)."</a>";
  echo "</td>\n";
  if($lejournum == 7){$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)-6, date("Y",$xjour));}else{$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)+1, date("Y",$xjour));}
}
echo "</tr>\n";

$_SESSION["debut_agenda"] = 0;
$_SESSION["fin_agenda"] = 23;
  
if(@$_SESSION["tout"] != "o"){
  $hjour = strtolower(jour_texte($_SESSION["jour"]));
  if(isset($_SESSION["preference"][$hjour])){
    $temp = explode(":",$_SESSION["preference"]["jour"][$hjour][1]["debut"]);
    $_SESSION["debut_agenda"] = $temp[0];
    $temp = explode(":",$_SESSION["preference"]["jour"][$hjour][$_SESSION["preference"]["compteur"][$hjour]]["fin"]);
    $_SESSION["fin_agenda"] = $temp[0];
  }
}

$dok = false;
$fok = false;
$dcpt = 0;
$fcpt = 0;
$testdebut[0] = 0;
$testfin[0] = 0;
  
for($lejournum = 1;$lejournum < 8;$lejournum ++) {
  if(isset($liste)&& is_array($liste)){
    reset($liste);
    while (list($key, $ligne) = each($liste)){
      if(date("Ymd",strtotime($ligne["debut_agenda"])) <= date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin_agenda"])) >= date("Ymd",$xjour)){
        if(date("H",strtotime($ligne["debut_agenda"])) < $_SESSION["debut_agenda"]){
          $dok = true;
          $testdebut[$dcpt] = date("H",strtotime($ligne["debut_agenda"]));
          $dcpt ++;
        }
        if(date("H",strtotime($ligne["fin_agenda"])) > $_SESSION["fin_agenda"]){
          $fok = true;
          $testfin[$fcpt] = date("H",strtotime($ligne["fin_agenda"]));
          $fcpt ++;
        }
      }
    }
    if($lejournum == 7){$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)-6, date("Y",$xjour));}else{$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)+1, date("Y",$xjour));}
  }
}

if($dok == true){$_SESSION["debut_agenda"] = $testdebut[0];}
if($fok == true){$_SESSION["fin_agenda"] = $testfin[($fcpt - 1)];}
for($h = $_SESSION["debut_agenda"];$h <= $_SESSION["fin_agenda"];$h ++){
  $heure = str_pad($h, 2, "0", STR_PAD_LEFT);
  echo "<tr>\n";
  echo "<td class=\"module\" id=\"nom\">".$heure.":00</td>\n";
  for($lejournum = 1;$lejournum < 8;$lejournum ++) {
    echo "<td class=\"module\">";
    affiche_minute_semaine($liste,$xjour,$h);
    echo "</td>\n";
    if($lejournum == 7){$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)-6, date("Y",$xjour));}else{$xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour)+1, date("Y",$xjour));}
  }
  echo "</tr>\n";
}

echo "<tr>\n";
echo "<td>&nbsp;</td>\n";
for($lejournum = 1;$lejournum < 8;$lejournum ++) {
  echo "<td class=\"module\">";
  echo "&nbsp;";
  echo "</td>\n";
}
echo "</tr>\n";
echo "</table>\n";

function affiche_minute_semaine($liste,$xjour,$h){
  $m = 1;
  //echo "<table style=\"margin:0;padding:0;\">\n";
  do {
    if($m == 1 or $m == 16 or $m == 31){
      $style = " style=\"border-bottom:1px solid #eee;\"";
    }else{
      $style = "";
    }
    if(verif_heure_travail($h,$m,$xjour)){
      $couleur = categorie("","Jour");
      if($couleur == ""){$couleur = "ffffBB;";}
      $hstyle = " style=\"background-color:#".$couleur."\"";
    }else{
      $hstyle = "";
    }
    //echo "<tr>\n";
    //echo "<td class=\"module\" id=\"quart\" ".$hstyle.">";
    echo affiche_evenement_semaine($liste,$xjour,$h,$m);
    //echo "</td>\n";
    //echo "</tr>\n";
    $m += 15;
  } while ($m <= 46);
  //echo "</table>\n";
}

function affiche_evenement_semaine($liste,$xjour,$h,$m){
  $temp_code = "";
  if(isset($liste)&& is_array($liste)){
    reset($liste);
    while (list($key, $val) = each($liste)){
      if (verif_evenement($val,$xjour,$h,$m)){
        if($val["nom_agenda"]!=""){
          $titre = " title=\"".$val["nom_agenda"]." => Du ".date("d/m/Y",strtotime($val["debut_agenda"]))." Au ".date("d/m/Y",strtotime($val["fin_agenda"]))."\"";
        }else{
          $titre="";
        }
        $temp_code .= "<div class=\"module\" ".categorie($val,"b")." ".$titre." id=\"block\">";
        $temp_code .= lien_editer($val);
        //$temp_code .= ucfirst($val["nom"]);
        $temp_code .= "<p class=\"module\">";
        if($val["info_agenda"] != ""){$temp_code .= "".ucfirst(nl2br($val["info_agenda"]))."";}
        if(date("Ymd",strtotime($val["debut_agenda"])) == date("Ymd",$xjour) && date("Ymd",strtotime($val["fin_agenda"])) == date("Ymd",$xjour)){
          $temp_code .= "<p class=\"module\" id=\"droite\">";
          $temp_code .= "<i class=\"module\">";
          $temp_code .= date("H:i",strtotime($val["debut_agenda"]))." - ".date("H:i",strtotime($val["fin_agenda"]));
          $temp_code .= "</i>";
        }else{
          $temp_code .= "<p class=\"module\" id=\"droite\"><i class=\"module\">".date("d/m/Y",strtotime($val["debut_agenda"]))."";
          $temp_code .= "<br>".date("d/m/Y",strtotime($val["fin_agenda"]))."</i>";
        }
        $temp_code .= "</div>";
        $ok = false;
      }
    }
  }
  $temp_code .= "&nbsp;";
  return $temp_code;
}

function verif_evenement($val,$xjour,$h,$m){
  $ok = false;
  $xjour = mktime(0, 0, 0, date("m",$xjour), date("d",$xjour), date("Y",$xjour));
  if(date("Ymd",strtotime($val["debut_agenda"])) <= date("Ymd",$xjour) && date("Ymd",strtotime($val["fin_agenda"])) >= date("Ymd",$xjour)){
    if(date("H",strtotime($val["debut_agenda"])) == $h){
      if(date("i",strtotime($val["debut_agenda"])) >= ($m -1 ) && date("i",strtotime($val["debut_agenda"])) < ($m + 14)){
        $ok = true;
      }
    }
  }
  return $ok;
}
?>
