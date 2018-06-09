<?php
if (file_exists("securite.php")){include("securite.php");}

$echelle = "1";
$table = "planning";
$_SESSION["table"] = $table;
 
switch ($_SESSION["voir"]) {
  default :
    //echo "<h3>";
    //echo "<a title=\"Nouveau Planning\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=planning&acte=formulaire&formulaire=nouveau','surpopup');\"><img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"i32\"></a>";
    //echo "&nbsp;";
    if(@$_SESSION["vid"] !=""){
      echo "<a title=\"Afficher la liste des plannings\" href=\"".$_SESSION["lien"]."?voir=&vid=\"><img src=\"".$_SESSION["ico"]["affirmer"]."\" id=\"i14\"></a> ";
    }
    echo "Planning".pluriel(compte_planning(''));
    //echo "</h3>\n";
    liste_planning('');
    if(compte_planning('archive')!=0){
      //echo "<br><br><h3>";
      if(@$_SESSION["vid"] !=""){
        echo "<a title=\"Afficher la liste des plannings\" href=\"".$_SESSION["lien"]."?voir=&vid=\"><img src=\"".$_SESSION["ico"]["affirmer"]."\" id=\"i14\"></a> ";
      }
      echo "Archive".pluriel(compte_planning('archive'));
      //echo "</h3>\n";
      liste_planning('archive');
    }
  break;
  
  case "p" :
    //echo "<h3>";
    //echo "<a title=\"Nouveau Planning\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=planning&acte=formulaire&formulaire=nouveau','surpopup');\"><img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"i32\"></a>";
    echo "&nbsp;";
    if(@$_SESSION["vid"] !=""){echo "<a title=\"Afficher la liste des plannings\" href=\"".$_SESSION["lien"]."?voir=&vid=\"><img src=\"".$_SESSION["ico"]["affirmer"]."\" id=\"i14\"></a> ";}
    echo "Planning".pluriel(compte_planning(''));
    //echo "</h3>\n";
    affiche_planning($echelle,'');
    affiche_planning($echelle,'archive');
  break;
}

function liste_planning($condition){
 $table = "planning";
 $_SESSION["table"] = $table;
 if($condition == "archive"){$condition = " and etat_planning !=''";}else{$condition=" and etat_planning =''";}
 $sql = "select * from planning where type_planning='planning' ".$condition." and id_user='".$_SESSION["userid"]."' order by nom_planning";
 $result = mysql_query($sql);
 //if(mysql_num_rows($result)>0){echo "Planning".pluriel(compte_planning_normal())." actif".pluriel(compte_planning_normal());}
 if($result){
  while ($ligne = mysql_fetch_array($result)){
    echo "<div class=\"planning\" id=\"block\">";
    if($ligne["etat_planning"]=="t"){echo "<s>";}
    style_titre_planning($ligne,$table,"listeplanning",$condition);
    if($ligne["etat_planning"]=="t"){echo "</s>";}
    echo "</div>";
  }
 }
}

function style_titre_planning($ligne,$table,$x,$condition){
 $couleur = "#999999";
 $fond = "#ffffff;";
 if($ligne["etat_planning"]=="x"){$pstyle="id=\"terminer\"";}else{$pstyle="";}
 switch ($x) {
 default :
 break;
 case "listeplanning":
    if($ligne["etat_planning"]==""){
    echo "<h5 class=\"planning\" ".categorie($ligne,"b")." ".$pstyle.">";
    echo "<img src=\"".$_SESSION["ico"]["menu"]."\" id=\"14\" title=\"Menu !\" onclick=\"javascript:voir('m".$ligne["id_planning"]."');\">";
    echo "<span class=\"planning\" id=\"m".$ligne["id_planning"]."\" style=\"display:none;\">";

    echo "<a title=\"Afficher ce planning\" href=\"".$_SESSION["lien"]."?voir=p&vid=".$ligne["id_planning"]."\"><img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\"></a>";
    echo "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=effaceligne&effaceligne=".$ligne["id_planning"]."\" title=\"Supprimer !\n\nAttention !\nCette action est d&eacute;finitive !\"><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i14\"></a>";
    echo "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=restaurer&restaurer=".$ligne["id_planning"]."\" title=\"Restaurer !\"><img src=\"".$_SESSION["ico"]["restaurer"]."\" id=\"i14\"></a>";
    if($ligne["etat_planning"]=="t"){echo ico_annuleterminer($ligne["id_planning"],"planning");}else{echo ico_terminer($ligne["id"],"planning");}
    echo "</span>";
    echo "&nbsp;[".les_enfants($ligne["id_planning"],"planning")."]";
    unset($_SESSION["enfants"]);
    echo "&nbsp;".$ligne["nom_planning"]."";
    avancement($ligne);
    echo "</h5>\n";
  }else{
    echo "<h5 class=\"planning\" ".categorie($ligne,"t")." ".$pstyle.">";
    echo "<a title=\"Afficher ce planning\" href=\"".$_SESSION["lien"]."?voir=p&vid=".$ligne["id_planning"]."\"><img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\"></a>";
    if($ligne["etat_planning"]=="t"){echo ico_annuleterminer($ligne["id_planning"],"planning");}else{echo ico_terminer($ligne["id_planning"],"planning");}
    echo "&nbsp;";
    echo "[".les_enfants($ligne["id_planning"],"planning")."]";
    unset($_SESSION["enfants"]);
    if($ligne["etat_planning"]=="t"){echo "<s>";}
    echo "&nbsp;".$ligne["nom"];
    if($ligne["etat"]=="t"){echo "</s>";}
    avancement($ligne);
    echo "</h5>\n";
  }
 break;
 case "afficheplanning":
  echo "<h5 class=\"planning\">";
  menu_planning($ligne,$table,$x,$condition);
  if($ligne["etat_planning"]=="t"){echo "<s>";}
  echo "&nbsp;".$ligne["nom_planning"];
  if($ligne["etat_planning"]=="t"){echo "</s>";}
  avancement($ligne);
  echo "</h5>\n";
 break;
 }
}

function menu_planning($ligne,$table,$x,$condition){
 switch ($x) {
 default :
  if($condition == "archive"){
  echo "<img src=\"".$_SESSION["ico"]["menu"]."\" id=\"i14\" title=\"Menu !\" onclick=\"javascript:voir('m".$ligne["id_planning"]."');\">";
  echo "<span class=\"planning\" id=\"m".$ligne["id_planning"]."\" style=\"display:none;\">";
  echo "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=effaceligne&effaceligne=".$ligne["id_planning"]."\" title=\"Supprimer !\n\nAttention !\nCette action est d&eacute;finitive !\"><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i14\"></a>";
  echo "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=restaurer&restaurer=".$ligne["id_planning"]."\" title=\"Restaurer !\"><img src=\"".$_SESSION["ico"]["restaurer"]."\" id=\"i14\"></a>";
  echo "</span>";
  }
  //ico_terminer($ligne["id"],"planning");
 break;
 case "listeplanning":
 break;
 
 case "afficheplanning":
  echo "<img src=\"".$_SESSION["ico"]["menu"]."\" id=\"i14\" title=\"Menu !\" onclick=\"javascript:voir('m".$ligne["id_planning"]."');\">";
  echo "<span class=\"planning\" id=\"m".$ligne["id_planning"]."\" style=\"display:none;\">";
  if($ligne["id_planning"]<> $_SESSION["vid"]){echo "<a title=\"Afficher ce planning\" href=\"".$_SESSION["lien"]."?voir=p&vid=".$ligne["id_planning"]."\"><img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\"></a>";}
  if(@$ligne["etat_planning"]==""){
    echo "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=supprime&voir=&vid=&supprime=".$ligne["id_planning"]."\" title=\"Archiver !\"><img src=\"".$_SESSION["ico"]["archiver"]."\" id=\"i14\"></a>";
  }else{
    echo "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=restaurer&restaurer=".$ligne["id_planning"]."\" title=\"Restaurer !\"><img src=\"".$_SESSION["ico"]["restaurer"]."\" id=\"i14\"></a>";
  }
  //echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=modifierplanning&modifier=".$ligne["id"]."','surpopup');loadobjs();\"><img src=\"".$_SESSION["ico"]["modifier"]."\" id=\"i14\"></a>";

  echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=planning&acte=formulaire&formulaire=modifier&modifier=".$ligne["id_planning"]."','surpopup');loadobjs();\"><img src=\"".$_SESSION["ico"]["modifier"]."\" id=\"i14\"></a>";
  echo "<a title=\"Ajouter un élément\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=planning&acte=formulaire&formulaire=nouveau&xlien=".$ligne["id_planning"]."','surpopup');loadobjs();\"><img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"i14\"></a>";
  echo "<a title=\"Déplacer un élément\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=planning&acte=formulaire&formulaire=deplacer&deplacer=".$ligne["id_planning"]."','surpopup');loadobjs();\"><img src=\"".$_SESSION["ico"]["deplacer"]."\" id=\"i14\"></a>";
  if($ligne["etat_planning"]=="t"){echo ico_annuleterminer($ligne["id_planning"],"planning");}else{echo ico_terminer($ligne["id_planning"],"planning");}
  echo "</span>";
 break;
 }
}

function affiche_planning($echelle,$condition){
 $table = "planning";
 $_SESSION["table"] = $table;
 if($condition == "archive"){$condition = "and etat_planning !=''";}else{$condition="and etat_planning =''";}
 $sql = "select * from ".$table." where id_planning='".$_SESSION["vid"]."' ".$condition." order by id_planning desc";
 $result = mysql_query($sql);
 while ($ligne = mysql_fetch_array($result)){
 
 if($ligne["etat_planning"]=="x"){$pstyle="id=\"terminer\"";}else{$pstyle="";}
 echo "<div class=\"planning\" ".categorie($ligne,"t")." ".$pstyle.">";
 
 if($ligne["etat_planning"]=="t"){echo "<s>";}
 style_titre_planning($ligne,$table,"afficheplanning",$condition);
 if($ligne["info_planning"]!=""){echo "<p class=\"planning\">".nl2br($ligne["info_planning"]);}
  echo "<p class=\"planning\">";
  
  if($ligne["debut_planning"] <> 0){echo "["."Début: ".date("d/m/Y",strtotime($ligne["debut_planning"]))."] ";}
  if($ligne["fin_planning"] <> 0){echo "["."Fin: ".date("d/m/Y",strtotime($ligne["fin_planning"]))."]";}
  echo "</p>";
  if($ligne["etat_planning"]=="t"){echo "</s>";}
 //if($ligne["debut"]!=""){echo "<p class=\"planning\">["."Début: ".date_num($ligne["debut"])."] ["."Fin: ".date_num($ligne["fin"])."]";}
 affiche_enfant_planning($ligne["id_planning"],$table,$echelle,$condition);

 echo "</div>\n";
 }
}

function affiche_enfant_planning($lien,$table,$echelle,$condition){
 if($condition == "archive"){$condition = "and etat_planning !=''";}else{$condition="and archive =''";}
 $sql = "select * from ".$table." where lien='".$lien."' ".$condition." order by nom_planning";
 $result = mysql_query($sql);
 while ($ligne = @mysql_fetch_array($result)){

 if($ligne["etat_planning"]=="x"){$pstyle="id=\"terminer\"";}else{$pstyle="";}
 echo "<div class=\"planning\" id=\"block\">";
 echo "<div class=\"planning\" ".$pstyle." ".categorie($ligne,"t").">";
 style_titre_planning($ligne,$table,"afficheplanning",$condition);
 if($ligne["info_planning"]!=""){echo "<p class=\"planning\">".nl2br($ligne["info_planning"]);}

  echo "<p class=\"planning\">";
  if($ligne["debut_planning"] <> 0){echo "["."Début: ".date("d/m/Y",strtotime($ligne["debut_planning"]))."] ";}
  if($ligne["fin_planning"] <> 0){echo "["."Fin: ".date("d/m/Y",strtotime($ligne["fin_planning"]))."]";}
  echo "</p>";
  
 affiche_enfant_planning($ligne["id_planning"],$table,$echelle,$condition);
 echo "</div>";
 echo "</div>\n";
  }
}

function compte_planning($condition){
 if($condition == "archive"){$condition = "and etat_planning !=''";}else{$condition="and etat_planning =''";}
 $sql = "select * from planning where id_user=".$_SESSION["userid"]." ".$condition." and type_planning='planning'";
 $result = mysql_query($sql);
 return mysql_num_rows($result);
}

function avancement($ligne){
  if($ligne["debut_planning"] <> 0 && $ligne["fin_planning"] <> 0){
    $m = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
    $etat = round(($m - strtotime($ligne["debut_planning"])) / (strtotime($ligne["fin_planning"]) - strtotime($ligne["debut_planning"]))*100);
    if($etat < 0){$etat = 0;}
    if($etat > 100){$etat = 100;}
    echo "<p class=\"planning\" style=\"padding:1px 1px 1px 1px;margin:0;font-weight:normal;\">Temps restant : ".(100 - $etat)." %</p>";
    echo "<div style=\"border:1px solid #eee;display:block;overflow:hidden;\">";
    echo "<div style=\"background-color:#eee;width:".$etat."%;\">";
    echo "<img src=\"images/pixel.gif\" style=\"width:".$etat."%;height:10px;\">";
    echo "</div>";
    echo "</div>\n";
  }
}

?>