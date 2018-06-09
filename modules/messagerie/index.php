<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
if(!isset($_SESSION["voir"])){$_SESSION["voir"]=" ";}
//module_titre($_SESSION["page"],'');
$sql = "select * from messagerie where type_messagerie='message' and etat_messagerie ='' and destinataire_messagerie='".$_SESSION["userid"]."' order by id_messagerie desc";
if($result = mysql_query($sql)){  
  $nb = nombre_longueur(mysql_num_rows($result),3);    
  if($nb >0){
    
    echo "<a href=\"".$_SESSION["lien"]."?voir=reception\" title=\"Afficher\"><div class=\"module\" id=\"titre\">";
    echo "<img src=\"".$_SESSION["ico"]["message"]."\" class=\"module\">";
    echo $nb." Message".pluriel(mysql_num_rows($result))." reçu".pluriel(mysql_num_rows($result));
    echo "</div></a>\n";    
    if($_SESSION["voir"] == "reception"){
      while ($ligne = mysql_fetch_array($result)){            
        echo "<div class=\"module\" id=\"ligne\">";      
        echo ico_supprimer($ligne,"messagerie");
        echo ico_voir("m".$ligne["id_messagerie"]);      
        echo ico_archive($ligne,"messagerie");
        echo ico_repondre($ligne,"messagerie");            
        echo "<b>".$ligne["nom_messagerie"]."</b>";
        echo "<div id=\"m".$ligne["id_messagerie"]."\" style=\"display:none;\">";      
        echo "<p class=\"module\" id=\"message\">".nl2br($ligne["info_messagerie"]);
        echo "<p class=\"module\" id=\"droite\">";
        $lignex = utilisateur_info($ligne["expediteur_messagerie"]);
        echo ucfirst($lignex["prenom_user"])." ".strtoupper($lignex["nom_user"])."&nbsp;"; 
        echo "[<i class=\"module\">".$ligne["horloge_messagerie"]."</i>]";
        echo "</div>";
        echo "</div>\n";
        unset($lignex);
      }
    }    
  }
}

$sql = "select * from messagerie where type_messagerie='message' and etat_messagerie ='a' and destinataire_messagerie='".$_SESSION["userid"]."' order by id_messagerie desc";
$result = mysql_query($sql);
if($result){
  $nb = nombre_longueur(mysql_num_rows($result),3);
  if($nb >0){
    echo "<a href=\"".$_SESSION["lien"]."?voir=archive\" title=\"Afficher\"><div class=\"module\" id=\"titre\">";
    echo "<img src=\"".$_SESSION["ico"]["message_archive"]."\" class=\"module\">";
    echo $nb." Message".pluriel(mysql_num_rows($result))." archiv&eacute;".pluriel(mysql_num_rows($result));    
    echo "</div></a>\n";
    if($_SESSION["voir"] == "archive"){
      while ($ligne = mysql_fetch_array($result)){            
        echo "<div class=\"module\" id=\"ligne\">";      
        echo ico_supprimer($ligne,"messagerie");
        echo ico_voir("m".$ligne["id_messagerie"]);      
        echo ico_archive($ligne,"messagerie");
        echo ico_repondre($ligne,"messagerie");            
        echo "<b>".$ligne["nom_messagerie"]."</b>";
        echo "<div id=\"m".$ligne["id_messagerie"]."\" style=\"display:none;\">";      
        echo "<p class=\"module\" id=\"message\">".nl2br($ligne["info_messagerie"]);
        echo "<p class=\"module\" id=\"droite\">";
        $lignex = utilisateur_info($ligne["expediteur_messagerie"]);
        echo ucfirst($lignex["prenom_user"])." ".strtoupper($lignex["nom_user"])."&nbsp;"; 
        echo "[<i class=\"module\">".$ligne["horloge_messagerie"]."</i>]";
        echo "</div>";
        echo "</div>\n";
        unset($lignex);
      }
    }  
  }      
}
    
$sql = "select * from messagerie where type_messagerie='message_e' and expediteur_messagerie='".$_SESSION["userid"]."' order by id_messagerie desc";
$result = mysql_query($sql);  
if($result){    
    $nb = nombre_longueur(mysql_num_rows($result),3);
    if($nb >0){
      echo "<a href=\"".$_SESSION["lien"]."?voir=envoye\" title=\"Afficher\"><div class=\"module\" id=\"titre\">";
      echo "<img src=\"".$_SESSION["ico"]["message_archive"]."\" class=\"module\">";
      echo $nb." Message".pluriel(mysql_num_rows($result))." envoy&eacute;".pluriel(mysql_num_rows($result));
      echo "</div></a>\n";
      if($_SESSION["voir"] == "envoye"){
        while ($ligne = mysql_fetch_array($result)){            
          echo "<div class=\"module\" id=\"ligne\">";      
          echo ico_supprimer($ligne,"messagerie");
          echo ico_voir("m".$ligne["id_messagerie"]);      
          echo "<b>".$ligne["nom_messagerie"]."</b>";
          echo "<div id=\"m".$ligne["id_messagerie"]."\" style=\"display:none;\">";      
          echo "<p class=\"module\" id=\"message\">".nl2br($ligne["info_messagerie"]);
          echo "<p class=\"module\" id=\"droite\">";
          $lignex = utilisateur_info($ligne["expediteur_messagerie"]);
          echo ucfirst($lignex["prenom_user"])." ".strtoupper($lignex["nom_user"])."&nbsp;"; 
          echo "[<i class=\"module\">".$ligne["horloge_messagerie"]."</i>]";
          echo "</div>";
          echo "</div>\n";
          unset($lignex);
        }
      }    
    }
}      
?>