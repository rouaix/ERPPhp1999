<?php
//@session_start();
if(file_exists("securite.php")){include("securite.php");}
connexionmysql();

$_SESSION["debut_agenda"] = 0;
$_SESSION["fin_agenda"] = 23;

$hjour = strtolower(jour_texte($_SESSION["jour"]));
$xjour = mktime(0, 0, 0, date("m",$_SESSION["jour"]),date("d",$_SESSION["jour"]), date("Y",$_SESSION["jour"]));
$liste = cherche_evenement();

@reset($_SESSION["categorie"]);
$tstyle = "";
while (list($key, $val) = each($_SESSION["categorie"])){
  if($val["nom"] == "Jour"){$tstyle = " style=\"background-color:#".$val["contenu"]."\"";}
}
  
if(@$_SESSION["tout"] != "o"){
  $hjour = strtolower(jour_texte($_SESSION["jour"]));
  if(isset($_SESSION["preference"][$hjour])){
    $temp = explode(":",$_SESSION["preference"]["jour"][$hjour][1]["debut"]);
    $_SESSION["debut_agenda"] = $temp[0];
    $temp = explode(":",$_SESSION["preference"]["jour"][$hjour][$_SESSION["preference"]["compteur"][$hjour]]["fin"]);
    $_SESSION["fin_agenda"] = $temp[0];
  }
}
  
echo "<table>\n";

if(isset($liste)&& is_array($liste)){
  reset($liste);
  while (list($key, $ligne) = each($liste)){
    if(date("Ymd",strtotime($ligne["debut"])) < date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin"])) >= date("Ymd",$xjour)){
      echo "<tr>\n";
      echo "<td>&nbsp;</td>\n";
      echo "<td class=\"agenda\" ".$tstyle.">";
      echo affiche_evenement_special($ligne);
      echo "</td>\n";
      echo "</tr>\n";
    }
    
    if(date("Ymd",strtotime($ligne["debut"])) == date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin"])) >= date("Ymd",$xjour)){
      if(date("H",strtotime($ligne["debut"])) < $_SESSION["debut_agenda"]){
        echo "<tr>\n";
        echo "<td class=\"agenda\" id=\"jour\" ".$tstyle.">".lien_nouveau(date("H",strtotime($ligne["debut"]))).str_pad(date("H",strtotime($ligne["debut"])), 2, "0", STR_PAD_LEFT).":00</td>\n";
        echo "<td class=\"agenda\" id=\"plan\" ".$tstyle.">";
        $m = 1;
        do {
          $temp = affiche_evenement($liste,date("H",strtotime($ligne["debut"])),$xjour,$m);
          if(verif_evenement($val,$xjour,$heure,$m)){$temp = affiche_evenement_debut($val);}
          if($temp != ""){echo $temp;}
          $m += 15;
        } while ($m <= 46);
        echo "</td>\n";
        echo "</tr>\n";
      }
    }
  }
}

for($h = @$_SESSION["debut_agenda"];$h <= @$_SESSION["fin_agenda"];$h ++) {
  $heure = str_pad($h, 2, "0", STR_PAD_LEFT);
  echo "<tr>\n";
  echo "<td class=\"agenda\" id=\"jour\" ".$tstyle.">".lien_nouveau($heure).$heure.":00</td>\n";
  echo "<td class=\"agenda\" id=\"plan\" ".$tstyle.">";
  $m = 1;
  do {
    $temp = affiche_evenement($liste,$h,$xjour,$m);
    if(verif_evenement($val,$xjour,$heure,$m)){$temp = affiche_evenement_debut($val);}
    if($temp != ""){echo $temp;}
    $m += 15;
  } while ($m <= 46);
  echo "</td>\n";
  echo "</tr>\n";
}

if(isset($liste)&& is_array($liste)){
  reset($liste);
  while (list($key, $ligne) = each($liste)){
    if(date("Ymd",strtotime($ligne["debut"])) <= date("Ymd",$xjour) && date("Ymd",strtotime($ligne["fin"])) > date("Ymd",$xjour)){
      echo "<tr>\n";
      echo "<td>&nbsp;</td>\n";
      echo "<td class=\"agenda\" ".$tstyle.">";
      echo affiche_evenement_special($ligne);
      echo "</td>\n";
      echo "</tr>\n";
    }
  }
}
echo "</table>\n";
unset($liste);
  
function affiche_evenement($liste,$heure,$xjour,$m){
  $temp = "";
  if(isset($liste)&& is_array($liste)){
    reset($liste);
    while (list($key, $val) = each($liste)){
      if(verif_evenement($val,$xjour,$heure,$m)){
        $temp = affiche_evenement_debut($val);
      }
    }
  }
  return $temp;
}

function verif_evenement($val,$xjour,$h,$m){
  $ok = false;
  $xjour = mktime(0, 0, 0, date("n",$xjour), date("j",$xjour), date("Y",$xjour));
  if(date("Ymd",strtotime($val["debut"])) == date("Ymd",$xjour)){
    if(date("H",strtotime($val["debut"])) == $h){
      if(date("i",strtotime($val["debut"])) >= ($m -1 ) && date("i",strtotime($val["debut"])) < ($m + 14)){
        $ok = true;
      }
    }
  }
  return $ok;
}

function affiche_evenement_debut($val){
  $x = lien_editer($val)."<b>".ucfirst($val["nom"])."</b>";
  if($val["contenu"] != ""){$x .= "<p class=\"agenda\">".ucfirst(nl2br($val["contenu"]));}
  $temp = "<div id=\"texte\" class=\"agenda\"".categorie($val,"t").">";
  $temp .= lien_editer($val)."&nbsp;";
  $temp .= str_pad(date("H",strtotime($val["debut"])), 2, "0", STR_PAD_LEFT).":".str_pad(date("i",strtotime($val["debut"])), 2, "0", STR_PAD_LEFT)." - ".str_pad(date("H",strtotime($val["fin"])), 2, "0", STR_PAD_LEFT).":".str_pad(date("i",strtotime($val["fin"])), 2, "0", STR_PAD_LEFT);
  //$temp .= "&nbsp;<b>".ucfirst($val["nom"])."</b>";
  $temp .= "</div>";
  return $temp;
}

function affiche_evenement_special($val){
  $temp = "<div class=\"agenda\" id=\"marge\"".categorie($val,"t").">";
  $temp .= "Depuis le ".date("d/m/Y",strtotime($val["debut"]))." - Jusqu'au ".date("d/m/Y",strtotime($val["fin"]));
  $temp .= "<div id=\"texte\" class=\"agenda\" ".$style.">".lien_editer($val);
  $temp .= ucfirst($val["nom"]);
  if($val["contenu"] != ""){$temp .= " (".ucfirst(nl2br($val["contenu"])).")";}
  $temp .= "</div>";
  $temp .= "</div>\n";
  return $temp;
}

unset($_SESSION["debut_agenda"]);
unset($_SESSION["fin_agenda"]);
?>
