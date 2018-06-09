<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

if(isset($_SESSION["userid"]) && administrateur($_SESSION["userid"])){
  echo "<div class=\"module\" id=\"titre\">En ligne</div>\n";
  $sql = "select user.id_user,user.prenom_user,user.nom_user,hit.session_hit from user,hit where user.id_user = hit.id_user and hit.session_hit !=''";
  if($result = mysql_query($sql)){
    echo "<ul>";
    echo "<li ".style_cherche('','user','couleur').">".@$_SESSION["visiteur"]["inconnu"]." Visiteur".pluriel(@$_SESSION["visiteur"]["inconnu"])."";
    echo " & ".@$_SESSION["visiteur"]["connu"]." Membre".pluriel(@$_SESSION["visiteur"]["connu"])." sur ".@$_SESSION["visiteur"]["membre"]."</li>";
    while ($ligne = mysql_fetch_array($result)){
      echo "<li>".style_cherche('','user','icone').ucfirst($ligne["prenom_user"])." ".strtoupper($ligne["nom_user"])."</li>";
    }
    echo "</ul>\n";
  }
}

?>