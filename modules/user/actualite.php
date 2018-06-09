<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

if(isset($_SESSION["userid"]) && utilisateur($_SESSION["userid"])){
  $ok = false;
  echo "<div class=\"module\" id=\"titre\">Votre actualit&eacute;</div>\n";
  if($result = mysql_query("select * from messagerie where type_messagerie='message' and etat_messagerie ='' and destinataire_messagerie='".$_SESSION["userid"]."' order by id_messagerie desc")){
  $nb = @mysql_num_rows($result);
  
  if(@$nb <> 0){
    echo "<ul>\n";
      echo "<li ".style_cherche('','messagerie','couleur').">";
      echo "<a href=\"".$_SESSION["lien"]."?page=messagerie\" title=\"Lire\"><img class=\"module\" src=\"".module_icone("messagerie")."\"></a>";
      echo "Vous avez ".nombre_longueur($nb,3)." Message".pluriel($nb).".";
      echo "</li>\n";
    echo "</ul>\n";
    $ok = true;
  }
  }
  
  if($result = mysql_query("select * from tache where type_tache='tache' and id_user='".$_SESSION["userid"]."' order by id_tache desc")){
  $nb = @mysql_num_rows($result);
  
  if(@$nb <> 0){
    echo "<ul>\n";
      echo "<li><b>Tache".pluriel(@$nb)." en cours .</b></li>";
      while ($ligne = @mysql_fetch_array($result)){
        echo "<li ".style_cherche('','tache','couleur').">";
        echo "<b>".$ligne["nom"]."</b> ".$ligne["contenu"]." <i>".$ligne["horloge"]."</i>";
        echo "</li>\n";
      }
    echo "</ul>\n";
    $ok = true;
  }
  }
  if(!$ok){echo "<ul>\n<li><i>Rien &agrave; signaler.</i></li></ul>\n";}
}
?>