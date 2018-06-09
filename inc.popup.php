<?php
if(!isset($_SESSION)){session_start();}
//if (file_exists("securite.php")){include("securite.php");}
if(file_exists("inc.config.php")){include("inc.config.php");}
if(!isset($_SESSION["popup"]) or @$_SESSION["popup"] == ""){$_SESSION["popup"] = "popup";}
variables_session();

switch (@$_SESSION["acte"]) {
  default :
  break;

  case "formulaire":
    switch (@$_SESSION["formulaire"]) {
      default :
      break;

      case "nouveau":
        if(isset($_SESSION["xlien"])){$z["lien"] = $_SESSION["xlien"];}else{$z = "";}
        if(isset($_SESSION["debut"])){
          $z["debut"] = date("Y",$_SESSION["debut"])."-".date("m",$_SESSION["debut"])."-".date("d",$_SESSION["debut"])." ".date("H",$_SESSION["debut"]).":".date("i",$_SESSION["debut"]);
        }
        if(isset($_SESSION["fin"])){
          $z["fin"] = date("Y",$_SESSION["fin"])."-".date("m",$_SESSION["fin"])."-".date("d",$_SESSION["fin"])." ".date("H",$_SESSION["fin"]).":".date("i",$_SESSION["fin"]);
        }
        formulaire($z);
        //if(administrateur($_SESSION["userid"]) && $_SESSION["page"] == "admin"){formulaire_administrateur($z);}else{formulaire($z);}
        unset($z);
        unset($_SESSION["xlien"]);
      break;

      case "modifier":
        $result = mysql_query("select * from ".$_SESSION["table"]." where id_".$_SESSION["table"]."='".$_SESSION["modifier"]."' limit 1");
        $z = mysql_fetch_array($result);
        formulaire($z);
        unset($z);
        unset($_SESSION["modifier"]);
      break;
      
      case "repondre":
        $z["destinataire_messagerie"] = $_SESSION["repondre"];
        $z["lien_messagerie"] = $_SESSION["origine"];
        
        $result = mysql_query("select * from ".$_SESSION["table"]." where id_".$_SESSION["table"]."='".$_SESSION["origine"]."' limit 1");
        $zm = mysql_fetch_array($result);        
        $zl = utilisateur_info($zm["expediteur_messagerie"]);
        
        $z["nom_messagerie"] = "Re : ".$zm["nom_messagerie"];
        $z["info_messagerie"] = " \n\n";
        $z["info_messagerie"] .= "----------\n";
        $z["info_messagerie"] .= ucfirst($zl["prenom_user"])." ".strtoupper($zl["nom_user"])." ".$zm["horloge_messagerie"]."\n";
        $z["info_messagerie"] .= $zm["info_messagerie"]."\n";
        $z["info_messagerie"] .= "----------\n";
        
        formulaire($z);
        unset($z);
        unset($_SESSION["repondre"]);
        unset($_SESSION["origine"]);
      break;

      case "deplacer":
        structure($_SESSION["deplacer"],$_SESSION["table"]);
        unset($_SESSION["deplacer"]);
      break;
    }
  break;
}

unset($_SESSION["acte"]);
unset($_SESSION["formulaire"]);

function formulaire($temp){   
  if(isset($_SESSION["table"])){
    if($_SESSION["table"] <> ""){
      $droitstable = table_droits($_SESSION["table"]);
      if(isset($droitstable["16"])){
          if(isset($droitstable["18"])){
            formulaire_affiche($temp);
          }else{
            echo "<p id=\"centre\">Table (".ucfirst($_SESSION["table"]).")<p id=\"centre\"><b>Non Modifiable</b>";
          }
      }else{
        echo "<br><p id=\"centre\"><img src=\"".$_SESSION["ico"]["interdit"]."\" id=\"i64\" title=\"Interdit\">";
        echo "<p id=\"centre\">Table (".ucfirst($_SESSION["table"]).")<p id=\"centre\"><b>Interdiction Formulaire</b>";
      }
      unset($droitstable);
    }
  }
}

function formulaire_affiche($temp){
  echo "<div class=\"pop\" ".style_cherche("","pop","couleur").">";  
  echo "<div class=\"fenetre\">";
  echo "<img class=\"fenetre\" src=\"".$_SESSION["ico"]["fermer"]."\" title=\"Fermer\" onclick=\"javascript:voir('".$_SESSION["popup"]."');\">";
  echo "<label class=\"fenetre\">Formulaire de saisie</label>";
  echo "</div>\n";

  echo "<form class=\"pop\" name=\"fstd\" id=\"fstd\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";

  $droitschamps = champs_droits($_SESSION["table"]);
  $listechamps  = champs_liste($_SESSION["table"]);
  $titrechamps  = champs_titre($_SESSION["table"]);

  reset($listechamps);
  while(list($key,$val) = each($listechamps)){
    if(isset($droitschamps[$key]["61"])){
      if(isset($droitschamps[$key]["62"])){
        if(isset($droitschamps[$key]["63"])){
          echo "<label class=\"pop\">";
          if(isset($titrechamps[$key]) && @$titrechamps[$key] <> ""){echo ucfirst($titrechamps[$key]);}else{echo ucfirst($key);}
          echo "</label>\n";
          echo formulaire_liste($key,$temp);
        }else{
          echo "<label class=\"pop\">";
          if(isset($titrechamps[$key]) && @$titrechamps[$key] <> ""){echo ucfirst($titrechamps[$key]);}else{echo ucfirst($key);}
          echo "</label>\n";
          if($listechamps[$key] == "longtext"){
            echo "<textarea class=\"pop\" type=\"text\" name=\"form_".$key."\">";
            if(isset($temp[$key]) && @$temp[$key] != ""){echo $temp[$key];}
            echo "</textarea>\n";
          }else{
            if($listechamps[$key] == "datetime"){
              echo "<input type=\"hidden\" name=\"form_".$key."\" value=\"";
              if(isset($temp[$key]) && @$temp[$key] != 0){echo $temp[$key];}
              echo "\">\n";
              echo formulaire_champs_datetime($temp,$key);
            }else{
              echo formulaire_champs_special($key,$temp);
            }
          }
        }
      }else{
        echo "<label class=\"pop\" id=\"disabled\">";
        if(isset($titrechamps[$key]) && @$titrechamps[$key] <> ""){echo ucfirst($titrechamps[$key]);}else{echo ucfirst($key);}
        echo "</label>\n";
        echo "<input class=\"pop\" id=\"disabled\" type=\"text\" name=\"form_vide\" value=\"";
        if(isset($temp[$key]) && @$temp[$key] != ""){echo $temp[$key];}
        echo "\" disabled=\"true\">\n";
        echo "<input type=\"hidden\" name=\"form_".$key."\" value=\"";
        if(isset($temp[$key]) && @$temp[$key] != ""){echo $temp[$key];}
        echo "\">\n";
      }
    }else{
      echo "<input type=\"hidden\" name=\"form_".$key."\" value=\"".formulaire_champs_hidden($key,$temp)."\">\n";
    }
  }
  unset($droitschamps);
  unset($listechamps);
  unset($titrechamps);

  if(isset($_SESSION["formulaire"])){
    $result = mysql_query("select * from ".$_SESSION["table"]." where id_".$_SESSION["table"]."=".$_SESSION["formulaire"]." limit 1");
    if($result){$ligne = mysql_fetch_array($result);}
  }else{

  }
  echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
  echo "<input type=\"hidden\" name=\"table\" value=\"".$_SESSION["table"]."\">";
  echo "<br><br><input type=\"image\" src=\"".$_SESSION["ico"]["valider"]."\" value=\"Valider\"  id=\"i32\" title=\"Cliquez pour valider\">";
  echo "</form>\n";
  echo "</div>\n";
}

function formulaire_champs_datetime($temp,$key){
  $x = "";
  if(isset($temp[$key]) && @$temp[$key] != 0){
    $xdt = explode(" ",$temp[$key]);
    $xdate = $xdt[0];
    $xheure = $xdt[1];
    $xd = explode("-",$xdate);
    $xh = explode(":",$xheure);
    $lejour = mktime(@$xh[0], @$xh[1], @$xh[2], @$xd[1], @$xd[2], @$xd[0]);
  }

  $x .=  "<input class=\"pop\" type=\"text\" id=\"form_date_".$key."\" name=\"form_date_".$key."\" value=\"";
  if(isset($temp[$key]) && @$temp[$key] != 0){$x .= date_numerique($lejour);}
  $x .= "\" style=\" width:80px;text-align:center;\">";
  $lien = "onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.calendrier.php?jour".@$lejour."=&origine=form_date_".$key."','pop');loadobjs();\"";
  $x .= "&nbsp;<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"image16\" ".$lien.">&nbsp;";

  $x .=  "<input class=\"pop\" type=\"text\" id=\"form_heure_".$key."\" name=\"form_heure_".$key."\" value=\"";
  if(isset($temp[$key]) && @$temp[$key] != 0){$x .= heure_numerique($lejour);}
  $x .= "\" style=\" width:50px;text-align:center;\">";
  $lien = "onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?jour".@$lejour."=&origine=form_heure_".$key."','pop');loadobjs();\"";
  $x .= "&nbsp;<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"image16\" ".$lien.">\n";
  return $x;
}

function formulaire_liste($champs,$temp){
  switch ($champs) {
    default :
    break;

    case "icone_".$_SESSION["table"]:
      formulaire_icone_liste_affiche($champs,$temp);
    break;

    case "lien_icones":
      formulaire_icone_liste_affiche($champs,$temp);
    break;
        
    case "recurrence":
      $x = "";
      $x .= "<select class=\"pop\" name=\"form_recurrence\">";
      $x .= "<option value=\" \"> </option>";
      $x .= "</select>\n";
      return $x;
    break;
    
    case "id_categorie":
      $x = "";
      categorie("","reload");
      if(!isset($_SESSION["categorie"])){categorie("","reload");}     
      $x .= "<select class=\"pop\" name=\"id_categorie\">";
      @reset($_SESSION["categorie"]);
      $x .= "<option value=\" \"> </option>";
      while (list($key, $val) = @each($_SESSION["categorie"])){
        $c = "";
        if(isset($temp["id_categorie"])){
          if($temp["id_categorie"] != ""){
            if($temp["id_categorie"] == $val["id_categorie"]){
              $c ="selected";
            }
          }
        }
        if(isset($val["id_categorie"])){
          $x .= "<option value=\"".$val["id_categorie"]."\" style=\"background-color:#".$val["info_categorie"].";\" ".$c.">".$val["nom_categorie"]."</option>";
        }
      }
      $x .= "<option value=\" \"> </option>";
      $x .= "</select>\n";
      return $x;
    break;
    
    case "destinataire_".$_SESSION["table"]:
      $x = "";
      $x .= "<select class=\"pop\" name=\"form_destinataire_".$_SESSION["table"]."\">";
      $x .= "<option value=\"\"> </option>";
      $result = mysql_query("select id_user,nom_user,prenom_user from user order by prenom_user,nom_user asc");
      while ($ligne = mysql_fetch_array($result)){
        $c = "";
        if(isset($temp["destinataire_messagerie"])){
          if($temp["destinataire_messagerie"] != ""){
            if($temp["destinataire_messagerie"] == $ligne["id_user"]){
              $c ="selected";
            }
          }
        }
        $x .= "<option value=\"".$ligne["id_user"]."\" ".$c.">".ucfirst($ligne["prenom_user"])." ".strtoupper($ligne["nom_user"])."</option>";
      }
      $x .= "</select>\n";
      return $x;
    break;

    case "id_civilite":
      formulaire_liste_table("civilite");
    break;
  }
}

function formulaire_liste_table($table){
  $x = "";      
  $sql = "select * from ".$table." where etat_".$table." =''";   
  if($result = mysql_query($sql)){
    $x .= "<select class=\"pop\" name=\"form_id_".$table."\">";
    while ($ligne = mysql_fetch_array($result)){
      $x .= "<option value=\"".$ligne["id_".$table]."\" ";
      if(isset($temp["id_".$table]) && $temp["id_".$table] == $ligne["id_".$table]){$x .= "selected";}  
      $x .= ">".$ligne["nom_".$table]." (".@$ligne["info_".$table].")";
      $x .= "</option>";
    }
    $x .= "</select>";
    unset($sql);
    unset($ligne);
  }
  return $x;
}

function formulaire_champs_hidden($champs,$temp){
  switch ($champs) {
    default :
      if(isset($temp[$champs]) && @$temp[$champs] != ""){return $temp[$champs];}
    break;
    case "id_".$_SESSION["table"]:
      if(isset($temp["id_".$_SESSION["table"]]) && @$temp["id_".$_SESSION["table"]] != ""){return $temp["id_".$_SESSION["table"]];}
    break;    
    case "id_user":
      return $_SESSION["userid"];
    break;    
    case "horloge_".$_SESSION["table"]:
      return date_heure();
    break;    
    case "type_".$_SESSION["table"]:
      switch (@$_SESSION["table"]) {
        default :
          if(isset($temp[$champs]) && @$temp[$champs] != ""){return $temp[$champs];}else{return $_SESSION["table"];}
        break;        
        case "messagerie":
          if(isset($temp[$champs]) && @$temp[$champs] != ""){return $temp[$champs];}else{return "message";}
        break;        
        case "systeme":
          if(isset($temp[$champs]) && @$temp[$champs] != ""){return $temp[$champs];}
        break;        
        case "tables":
          if(isset($temp[$champs]) && @$temp[$champs] != ""){return $temp[$champs];}
        break;        
        case "groupe":
          if(isset($temp[$champs]) && @$temp[$champs] != ""){return $temp[$champs];}else{return "groupe";}
        break;
        case "droits":
          if(isset($temp[$champs]) && @$temp[$champs] != ""){return $temp[$champs];}else{return "droits";}
        break;        
        case "redactionnel":
          if(isset($temp[$champs]) && @$temp[$champs] != ""){return $temp[$champs];}else{return "modele";}
        break;
      }
    break;
  }
}



function formulaire_champs_special($champs,$temp){
  $zz = @$temp[1];
  switch ($champs) {
    default :
      echo "<input class=\"pop\" type=\"text\" name=\"form_".$champs."\" value=\"";
      if(isset($temp[$champs]) && @$temp[$champs] != ""){echo $temp[$champs];}
      echo "\">\n";
    break;
    case "texte_style":
      echo "<input class=\"pop\" type=\"text\" name=\"form_".$champs."\" id=\"form_".$champs."\" value=\"";
      if(isset($temp[$champs]) && @$temp[$champs] != ""){echo $temp[$champs];}
      echo "\" ".style_cherche('',@$zz,'couleur').">";
      affiche_z($champs,"texte"); 
    break;
    case "fond_style":
      echo "<input class=\"pop\" type=\"text\" name=\"form_".$champs."\" id=\"form_".$champs."\" value=\"";
      if(isset($temp[$champs]) && @$temp[$champs] != ""){echo $temp[$champs];}
      echo "\" ".style_cherche('',@$zz,'couleur').">"; 
      affiche_z($champs,"fond");
    break;
    case "bord_style":
      echo "<input class=\"pop\" type=\"text\" name=\"form_".$champs."\" id=\"form_".$champs."\" value=\"";
      if(isset($temp[$champs]) && @$temp[$champs] != ""){echo $temp[$champs];}
      echo "\" ".style_cherche('',@$zz,'couleur').">"; 
      affiche_z($champs,"bord");
    break;
  }
}

unset($_SESSION["popup"]);

function affiche_x($r,$v,$b,$l,$ctype){
  if($l > 100){$l = 100;}
  $r = round(($r * $l)/100);
  $v = round(($v * $l)/100);
  $b = round(($b * $l)/100);
  $c = couleur_rgb2html($r,$v,$b);
  echo "<td class=\"couleur\" style=\"background-color:#".$c."\" ";  
  echo " onclick=\"";
  echo "setvaleurid('form_".$ctype."_style','".$c."');";
  if($ctype == "texte"){echo "couleurtexte('form_texte_style','".$c."');couleurtexte('form_fond_style','".$c."');couleurtexte('form_bord_style','".$c."');";}
  if($ctype == "fond"){echo "couleurfond('form_texte_style','".$c."');couleurfond('form_fond_style','".$c."');couleurfond('form_bord_style','".$c."');";}
  if($ctype == "bord"){echo "couleurbord('form_texte_style','".$c."');couleurbord('form_fond_style','".$c."');couleurbord('form_bord_style','".$c."');";}
  echo "\" ";    
  echo "title=\"Couleur ".$ctype." ".$c."\"></td>\n";
}

function affiche_y($r,$v,$b,$ctype){
  $c = couleur_rgb2html($r,$v,$b);
  echo "<td class=\"couleur\" style=\"background-color:#".$c."\" ";  
  echo " onclick=\"";
  echo "setvaleurid('form_".$ctype."_style','".$c."');";
  if($ctype == "texte"){echo "couleurtexte('form_texte_style','".$c."');couleurtexte('form_fond_style','".$c."');couleurtexte('form_bord_style','".$c."');";}
  if($ctype == "fond"){echo "couleurfond('form_texte_style','".$c."');couleurfond('form_fond_style','".$c."');couleurfond('form_bord_style','".$c."');";}
  if($ctype == "bord"){echo "couleurbord('form_texte_style','".$c."');couleurbord('form_fond_style','".$c."');couleurbord('form_bord_style','".$c."');";}
  echo "\" ";    
  echo "title=\"Couleur ".$ctype." ".$c."\"></td>\n";
} 

function affiche_z($champs,$ctype){
$l = 100;
$pas = 17;
$min = 0;
$max = 255;

echo "<table><tr><td>\n";

  echo "<table class=\"couleur\"><tr>\n";
    affiche_x($max,$min,$min,$l,$ctype);
    for($x = $min;$x <= $max;$x += $pas){affiche_x($max,$x,$min,$l,$ctype);}
    affiche_x($max,$max,$min,$l,$ctype);
    for($X = $max;$x > $min;$x -= $pas){affiche_x($x,$max,$min,$l,$ctype);}
    affiche_x($min,$max,$min,$l,$ctype);
    for($x = $min;$x <= $max;$x += $pas){affiche_x($min,$max,$x,$l,$ctype);} 
    affiche_x($min,$max,$max,$l,$ctype);
    for($X = $max;$x > $min;$x -= $pas){affiche_x($min,$x,$max,$l,$ctype);}
    affiche_x($min,$min,$max,$l,$ctype);
    for($x = $min;$x <= $max;$x += $pas){affiche_x($x,$min,$max,$l,$ctype);}
    affiche_x($max,$min,$max,$l,$ctype);
    for($X = $max;$x > $min;$x -= $pas){affiche_x($x,$min,$x,$l,$ctype);}
    affiche_x($min,$min,$min,$l,$ctype);
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($y = $min;$y <= $max;$y += $pas/6.8){affiche_x($y,$y,$y,$l,$ctype);}
  echo "</tr></table>\n";

echo "</td>\n";

echo "<td id=\"milieu\">\n";
  echo "<img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"i16\" title=\"Plus de couleurs\" onclick=\"voir('t".$ctype."c');\">";
echo "</td></tr></table>\n";

echo "<table id=\"t".$ctype."c\" style=\"display:none;\"><tr><td>\n";

  echo "<table class=\"couleur\">\n";
    for($x = $min;$x <= $max;$x += $pas/2){
      echo "<tr>\n";  
      for($y = $min;$y <= $max;$y += $pas/2){affiche_x($y,$x,$x - $y,$l,$ctype);}
      echo "</tr>\n";
    }
  echo "</table>\n";


  echo "<table class=\"couleur\"><tr>\n";
    for($y = $min;$y <= $max;$y += $pas/2){affiche_x($y,$y,$y,$l,$ctype);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x($max,0,0,$l,$ctype);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($max,$y,$y,$ctype);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x($max,0,$x,$l,$ctype);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($max,$y,$max,$ctype);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x($max,$max,0,$l,$ctype);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($max,$max,$y,$ctype);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x(0,$max,0,$l,$ctype);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($y,$max,$y,$ctype);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x(0,0,$max,$l,$ctype);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($y,$y,$max,$ctype);}
  echo "</tr></table>\n";

  echo "<table class=\"couleur\"><tr>\n";
    for($x = $min;$x < $max;$x += $pas){
      $l = round($x/($max/100));
      affiche_x(0,$max,$max,$l,$ctype);
    }
    for($y = $min;$y <= $max;$y += $pas){affiche_y($y,$max,$max,$ctype);}
  echo "</tr></table>\n";

echo "</td></tr></table>\n";
}

function formulaire_icone_liste_affiche($champs,$temp){
  $x = "";
  echo "<input class=\"pop\" type=\"text\" id=\"ficone\" name=\"form_".$champs."\" value=\"".@$temp[$champs]."\">";      
  $s = array("png","jpg","gif");
  $ldir = array();      
  array_push ($ldir,"../images/icones/");
  array_push ($ldir,"../images/divers/"); 
  array_push ($ldir,"../images/jpg/");     
  while(list(,$dir) = each($ldir)){
    if ($handle = opendir($dir)){          
      echo "<div style=\"margin:20px;\">";
      while(false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && $file != "index.php") {
          $ext = pathinfo($file, PATHINFO_EXTENSION);
          if(in_array($ext,$s)){
            echo "<img src=\"".$dir.$file."\" height=\"48px;\" title=\"Choisir ".ucfirst($file)."\" onclick=\"javascript:setvaleurid('ficone','".$dir.$file."');valider('fstd');\"";                
            if(@$temp[$champs] == $dir.$file){
              echo  " style=\"cursor:pointer;border:1px solid #000;margin:5px;padding:5px;background-color:#444;\"";
            }else{
              echo " style=\"cursor:pointer;border:1px solid #ccc;margin:5px;padding:5px;background-color:#fff;\"";
            }
            echo ">";
          }
        }
      }
      echo "</div>\n";
      closedir($handle);
    }        
  }            
  return $x;
}

?>