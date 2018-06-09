<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
if(!isset($_SESSION["voir"])){$_SESSION["voir"]=" ";}

$sql = "select * from note where type_note='note' and id_user='".$_SESSION["userid"]."' and etat_note !='a' order by nom_note";
if($result = mysql_query($sql)){
  //module_titre($_SESSION["page"],'');
  $nb = nombre_longueur(mysql_num_rows($result),3);
  if($nb >0){
    echo "<a href=\"".$_SESSION["lien"]."?voir=active\" title=\"Afficher\">";
    echo "<div class=\"module\" id=\"titre\">";
    echo "<img src=\"".$_SESSION["ico"]["note"]."\" class=\"module\">";
    echo $nb." Note".pluriel(mysql_num_rows($result))." active".pluriel(mysql_num_rows($result));    
    echo "</div></a>";
  
    if($_SESSION["voir"] == "active"){ 
      while ($ligne = mysql_fetch_array($result)){            
        echo "<div class=\"module\">";
        echo ico_voir("div".$ligne["id_note"]);
        echo ico_archive($ligne,"note");
        echo ico_termine($ligne,"note");
        echo ico_modifier("note",$ligne["id_note"]);
        if($ligne["etat_note"]=="t"){echo "<s>";}
        echo $ligne["nom_note"];
        echo "<div id=\"div".$ligne["id_note"]."\" style=\"display:none\">";
        echo "<p>";
        echo nl2br($ligne["info_note"]);      
        echo "<p id=\"droite\">";
        echo "<i>".$ligne["horloge_note"]."</i>";
        if($ligne["etat_note"]=="t"){echo "</s>";}
        echo "</div>";
        echo "</div>\n";
      } 
    }  
  }else{
    echo "<div class=\"module\">";
    echo "Aucune note";
    echo "</div>\n";
  }

}

$sql = "select * from note where type_note='note' and id_user='".$_SESSION["userid"]."' and etat_note ='a' order by nom_note";
if($result = mysql_query($sql)){
  $nb = nombre_longueur(mysql_num_rows($result),3);    
  if ($nb > 0){
    echo "<a href=\"".$_SESSION["lien"]."?voir=archive\" title=\"Afficher\">";
    echo "<div class=\"module\" id=\"titre\">";
    echo "<img src=\"".$_SESSION["ico"]["note"]."\" class=\"module\">";
    echo $nb." Note".pluriel(mysql_num_rows($result))." archiv&eacute;e".pluriel(mysql_num_rows($result));
    echo "</div>";

    if($_SESSION["voir"] == "archive"){ 
      while ($ligne = mysql_fetch_array($result)){            
        echo "<div class=\"module\">";
        echo ico_effacer($ligne["id_note"],"note");
        echo ico_voir("div".$ligne["id_note"]);
        echo ico_archive($ligne,"note");
        echo ico_modifier("note",$ligne["id_note"]);
        if($ligne["etat_note"]=="t"){echo "<s>";}
        echo $ligne["nom_note"];
        echo "<div id=\"div".$ligne["id_note"]."\" style=\"display:none\">";
        echo "<p>";
        echo nl2br($ligne["info_note"]);      
        echo "<p id=\"droite\">";
        echo "<i>".$ligne["horloge_note"]."</i>";
        if($ligne["etat_note"]=="t"){echo "</s>";}
        echo "</div>";
        echo "</div>\n";
      } 
    }  
  }

}

?>