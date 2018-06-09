<?php
if (file_exists("securite.php")){include("securite.php");}
$sql = "select * from memoire where type='memoire' and archive='' order by nom";
$result = mysql_query($sql);    
$nb = mysql_num_rows($result);

echo "<h3>";
echo "<a class=\"memoire\" title=\"Ajouter un aide m&eacute;moire\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=memoire&acte=formulaire&formulaire=nouveau','surpopup');\"><img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"image32\"></a>";

echo "&nbsp;Aide".pluriel($nb)." m&eacute;moire</h3>";
    
switch ($_SESSION["voir"]) {
  default :  
    $sql = "select * from memoire where type='memoire' and pere='".$_SESSION["userid"]."' and archive='' order by nom";
    $result = mysql_query($sql);    
    if(mysql_num_rows($result)>0){
    echo "<h4>Aide".pluriel(mysql_num_rows($result))." m&eacute;moire actif".pluriel(mysql_num_rows($result))."</h4>";
    while ($ligne = mysql_fetch_array($result)){            
      echo "<div class=\"memoire\" ".categorie($ligne,"t").">";
      echo ico_voir("div".$ligne["id"],0,0,0);
      echo ico_archiver($ligne,"memoire",0,0,0);
      echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=memoire&acte=formulaire&formulaire=modifier&modifier=".$ligne["id"]."','surpopup');loadobjs();\"><img src=\"".$_SESSION["ico"]["modifier"]."\" id=\"image14\"></a>";
      if($ligne["etat"]=="t"){echo ico_annuleterminer($ligne["id"],"memoire");}else{echo ico_terminer($ligne["id"],"memoire");}
      if($ligne["etat"]=="t"){echo "<s>";}
      echo "&nbsp;".$ligne["nom"];
      echo "<div id=\"div".$ligne["id"]."\" style=\"display:none\">";
      echo "<p>";
      echo nl2br($ligne["contenu"]);      
      echo "<p>";
      echo "[<i>".$ligne["horloge"]."</i>]";
      if($ligne["etat"]=="t"){echo "</s>";}
      echo "</div>";
      echo "</div>\n";
    } 
    }

    $sql = "select * from memoire where type='memoire' and pere='".$_SESSION["userid"]."' and archive!='' order by nom";
    $result = mysql_query($sql);    
    if(mysql_num_rows($result)>0){echo "<h4>Aide".pluriel(mysql_num_rows($result))." m&eacute;moire archiv&eacute;".pluriel(mysql_num_rows($result))."</h4>";}

    while ($ligne = mysql_fetch_array($result)){                  
      echo "<div class=\"memoire\" ".categorie($ligne,"t").">";
      echo ico_voir("div".$ligne["id"],"14","2","2");       
      echo ico_restaurer($ligne,"memoire",0,0,0);
      echo ico_supprimer($ligne,"memoire",0,0,0);
      //echo limite_texte($ligne["memoire"],"60");
      echo "&nbsp;".$ligne["nom"];
      echo "</b>";
      echo "<div id=\"div".$ligne["id"]."\" style=\"display:none\">";
      echo "<p>";
      if($ligne["contenu"]!=""){echo nl2br($ligne["contenu"]);} 
      echo "<p>";          
      echo ""."[<i>".$ligne["horloge"]."</i>]";   
      echo "</div>";
      echo "</div>\n";
    }
  break;
  
  case "a" :
    echo "<div class=\"memoire\">\n";
    echo "</div>"."\n";
  break;
  
  case "b" :
    echo "<div class=\"memoire\">\n";
    echo "</div>"."\n";    
  break;

  case "c" :
    if(file_exists("../scripts/page.erreur.php")){include("../scripts/page.erreur.php");}
  break; 
}
?>