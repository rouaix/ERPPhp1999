<?php
if (file_exists("securite.php")){include("securite.php");}

$sql = "select * from tache where type='tache'";
$result = mysql_query($sql);    
$nb = mysql_num_rows($result);    

echo "<h3>";
echo "<a class=\"messagerie\" title=\"Nouvelle tache\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=tache&acte=formulaire&formulaire=nouveau','surpopup');\"><img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"image32\"></a>";
echo "&nbsp;Tache".pluriel($nb)."</h3>";


switch ($_SESSION["voir"]) {
  default :         
    $sql = "select * from tache where type='tache' and archive ='' and pere='".$_SESSION["userid"]."' order by id desc";
    $result = mysql_query($sql);    
    if(mysql_num_rows($result)>0){
    echo "<h4>Tache".pluriel(mysql_num_rows($result))." active".pluriel(mysql_num_rows($result))."</h4>";
    while ($ligne = mysql_fetch_array($result)){
      echo "<div ".categorie($ligne,"t").">";
      if($ligne["etat"]=="t"){echo ico_annuleterminer($ligne["id"],"tache");}else{echo ico_terminer($ligne["id"],"tache");}
      echo ico_archiver($ligne,"tache",0,0,0);
      echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=tache&acte=formulaire&formulaire=modifier&modifier=".$ligne["id"]."','surpopup');loadobjs();\"><img src=\"".$_SESSION["ico"]["modifier"]."\" id=\"image14\"></a>";
      if($ligne["etat"]=="t"){echo "<s>";}
      echo "&nbsp;".$ligne["nom"];
      if($ligne["contenu"]!=""){echo nl2br($ligne["contenu"]);}
      echo "<i class=\"tache\">[".$ligne["horloge"]."]&nbsp;</i>";
      if($ligne["etat"]=="t"){echo "</s>";}
      echo "</div>";
      unset($style);
    } 
    }
    
    $sql = "select * from tache where type='tache' and archive !='' and pere='".$_SESSION["userid"]."'";
    $result = mysql_query($sql);    
    if(mysql_num_rows($result)>0){
    echo "<h4>Tache".pluriel(mysql_num_rows($result))." archiv&eacute;e".pluriel(mysql_num_rows($result))."</h4>";
    while ($ligne = mysql_fetch_array($result)){                  
      echo "<div ".categorie($ligne,"t")." class=\"tache\">";
      echo ico_voir("div".$ligne["id"],0,0,0);
      echo ico_restaurer($ligne,"tache",0,0,0);
      echo ico_supprimer($ligne,"tache",0,0,0);
      //echo $ligne["tache"];
      echo "&nbsp;".limite_texte($ligne["nom"],"60");
      //if(strlen($ligne["tache"])>60){echo substr($ligne["tache"],0,60)." ...";}else{echo $ligne["tache"];}                  
      echo "</div>";
      echo "<div id=\"div".$ligne["id"]."\" style=\"display:none\">";
      echo "<p id=\"juste\" style=\"padding:2px 2px 2px 20px\">";
      if($ligne["contenu"]!=""){echo nl2br($ligne["contenu"]);} 
      echo "<p id=\"droite\" style=\"font-size:10px;\">";          
      echo ""."[<i>".$ligne["horloge"]."</i>]";
      //echo ico_supprimer($ligne,"tache","12","0","0");      
      echo "</div>";            
    } 
    }  
  break;
  
  case "a" :
    echo "<div id=\"cadre\">\n";  
    echo "</div>"."\n";
  break;
  
  case "b" :
    echo "<div id=\"cadre\">\n";
    echo "</div>"."\n";    
  break;

  case "c" :
    if(file_exists("../scripts/page.erreur.php")){include("../scripts/page.erreur.php");}
  break; 
}


function cherche_tache(){
  if(file_exists("scripts/inc.sql.php")){include("scripts/inc.sql.php");}
  $sql = "select * from tache where type='tache' and archive='' order by debut,nom";
  $result = mysql_query($sql);
  if($result){
    while ($ligne = mysql_fetch_array($result)){
        $liste[$ligne["id"]] = $ligne;
    }
  }
  unset($ligne);
  mysql_free_result($result);
  return @$liste;
}

?>