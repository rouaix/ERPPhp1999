<?php
if (file_exists("securite.php")){include("securite.php");}
$sql = "select * from z".$_SESSION["userid"]." where type='700' and archive='' order by nom";   
$result = mysql_query($sql);    
$nb = mysql_num_rows($result);

echo "<fieldset class=\"page\">";
echo "<legend class=\"page\">Aide".pluriel($nb)." mémoire</legend>";

echo "<a title=\"Créer un aide mémoire\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=nouveaumemoire','surpopup');loadobjs();\">";
echo "<div class=\"menu\">Créer un aide mémoire</div>";
echo "</a>";
    
switch ($_SESSION["voir"]) {
  default :  
    $sql = "select * from z".$_SESSION["userid"]." where type='700' and archive='' order by nom";   
    $result = mysql_query($sql);    
    if(mysql_num_rows($result)>0){
    echo "<div id=\"marge\">Aide".pluriel(mysql_num_rows($result))." mémoire actif".pluriel(mysql_num_rows($result))."</div>";    
    while ($ligne = mysql_fetch_array($result)){            
      echo "<div ".style_categorie($ligne).">";           
      echo ico_voir("div".$ligne["id"],"14","2","2");
      echo ico_archiver($ligne,"z".$_SESSION["userid"],"14","2","0");             
      echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=modifiermemoire&modifier=".$ligne["id"]."','surpopup');loadobjs();\"><img src=\"images/jpg/valider.jpg\" style=\"height:14px;vertical-align:middle\" border=\"0\" hspace=\"2\" vspace=\"2\"></a>";     
      echo $ligne["nom"]; 
            
      echo "<div id=\"div".$ligne["id"]."\" style=\"display:none\">";
      echo "<p id=\"juste\" style=\"padding:2px 2px 2px 20px\">";
      echo nl2br($ligne["contenu"]);      
      echo "<p id=\"droite\" style=\"font-size:10px;\">";
      echo "[<i>".$ligne["horloge"]."</i>]&nbsp;";                 
      echo "</div>";
      echo "</div>";
    } 
    }

    $sql = "select * from z".$_SESSION["userid"]." where type='700' and archive!='' order by nom";   
    $result = mysql_query($sql);    
    if(mysql_num_rows($result)>0){echo "<div>Aide".pluriel(mysql_num_rows($result))." mémoire archivé".pluriel(mysql_num_rows($result))."</div>";}    

    while ($ligne = mysql_fetch_array($result)){                  
      echo "<div ".style_categorie($ligne).">";
      echo ico_voir("div".$ligne["id"],"14","2","2");       
      echo ico_restaurer($ligne,"z".$_SESSION["userid"],"14","2","2");
      echo ico_supprimer($ligne,"z".$_SESSION["userid"],"12","20","0");
      //echo limite_texte($ligne["memoire"],"60");
      echo $ligne["nom"];
      echo "</b>";
      echo "<div id=\"div".$ligne["id"]."\" style=\"display:none\">";
      echo "<p id=\"juste\" style=\"padding:2px 2px 2px 20px\">";
      if($ligne["contenu"]!=""){echo nl2br($ligne["contenu"]);} 
      echo "<p id=\"droite\" style=\"font-size:10px;\">";          
      echo ""."[<i>".$ligne["horloge"]."</i>]";   
      echo "</div>";
      echo "</div>";             
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
?>