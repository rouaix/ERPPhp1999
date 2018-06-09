<?php
if (file_exists("securite.php")){include("securite.php");}

$sql = "select * from z".$_SESSION["userid"]." where type='300'";   
$result = mysql_query($sql);    
$nb = mysql_num_rows($result);    

echo "<fieldset class=\"page\">";
echo "<legend class=\"page\">Tache".pluriel($nb)."</legend>";
echo "<a title=\"Créer une nouvelle tache\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=nouvelletache','surpopup');loadobjs();\">";
echo "<div class=\"menu\">Nouvelle tache</div>";
echo "</a>";

switch ($_SESSION["voir"]) {
  default :         
    $sql = "select * from z".$_SESSION["userid"]." where type='300' and archive='' order by id desc";   
    $result = mysql_query($sql);    
    if(mysql_num_rows($result)>0){
    echo "<div id=\"marge\">Tache".pluriel(mysql_num_rows($result))." active".pluriel(mysql_num_rows($result))."</div>";    
    while ($ligne = mysql_fetch_array($result)){              
      echo "<div ".style_categorie($ligne).">";              
      echo ico_archiver($ligne,"z".$_SESSION["userid"],"14","2","0");             
      echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=modifiertache&modifier=".$ligne["id"]."','surpopup');loadobjs();\"><img src=\"images/jpg/dialogue.jpg\" style=\"height:14px;\" border=\"0\" hspace=\"2\" vspace=\"2\"></a>";
      echo $ligne["nom"];  
      echo "<p id=\"juste\" style=\"padding:2px 2px 2px 20px\">";
      echo nl2br($ligne["contenu"]);      
      echo "<p id=\"droite\" style=\"font-size:10px;\">";
      echo "[<i>".$ligne["horloge"]."</i>]&nbsp;";
      echo "</div>";
      unset($style);
    } 
    $sql = "select * from z".$_SESSION["userid"]." where type='300' and archive!='' order by id desc";   
    $result = mysql_query($sql);    
    if(mysql_num_rows($result)>0){echo "<div id=\"marge\">Tache".pluriel(mysql_num_rows($result))." archivée".pluriel(mysql_num_rows($result))."</div>";}
    while ($ligne = mysql_fetch_array($result)){                  
      echo "<div ".style_categorie($ligne).">";
      echo ico_voir("div".$ligne["id"],"14","2","2");       
      echo ico_restaurer($ligne,"z".$_SESSION["userid"],"14","2","2");
      echo ico_supprimer($ligne,"z".$_SESSION["userid"],"12","20","0");
      //echo $ligne["tache"];
      echo limite_texte($ligne["nom"],"60");      
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

echo "</fieldset>";

function cherche_tache(){
  if(file_exists("scripts/inc.sql.php")){include("scripts/inc.sql.php");}
  $sql = "select * from z".$_SESSION["userid"]." where type='300' and archive='' order by debut,nom";
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