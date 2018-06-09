<?php
//if (file_exists("securite.php")){include("securite.php");}

if(isset($_SESSION["userid"]) && utilisateur($_SESSION["userid"])){
  echo "<div class=\"zone\" id=\"titre\">Espace Utilisateur</div>\n";
  echo "<table class=\"icones\"><tr>\n";
  echo "";
  echo "";
  echo "";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=agenda\" title=\"Agenda\"><img class=\"icones\" src=\"images/icones/agenda.png\"><label>Agenda</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=organiseur\" title=\"Organiseur\"><img class=\"icones\" src=\"images/icones/organiseur.png\" class=\"site\"><label>Organiseur</label></a></td>\n";
  
  echo "<td><a href=\"".$_SESSION["lien"]."?page=organiseur&voir=memoire\" title=\"Notes\"><img class=\"icones\" src=\"images/icones/memoire.png\" class=\"site\"><label>Notes</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=organiseur&voir=message\" title=\"Messagerie\"><img class=\"icones\" src=\"images/icones/message.png\" class=\"site\"><label>Messagerie</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=organiseur&voir=tache\" title=\"T&acirc;ches\"><img class=\"icones\" src=\"images/icones/tache.png\" class=\"site\"><label>T&acirc;ches</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=organiseur&voir=fichier\" title=\"Fichiers\"><img class=\"icones\" src=\"images/icones/fichier.png\" class=\"site\"><label>Fichiers</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=organiseur&voir=groupe\" title=\"Groupes\"><img class=\"icones\" src=\"images/icones/couple.png\" class=\"site\"><label>Groupes</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=organiseur&voir=preference\" title=\"Pr&eacute;f&eacute;rences\"><img class=\"icones\" src=\"images/icones/preference.png\" class=\"site\"><label>Pr&eacute;f&eacute;rences</label></a></td>\n";
  
  echo "<td><a href=\"".$_SESSION["lien"]."?page=planning\" title=\"Planning\"><img class=\"icones\" src=\"images/icones/planning.png\" class=\"site\"><label>Planning</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=gestion\" title=\"\"><img class=\"icones\" src=\"images/icones/gestion.png\" class=\"site\"><label>Gestion</label></a></td>\n";
  echo "<td><a href=\"javascript:voir('leformulaire');ajaxpage(rootdomain+'scripts/inc.radio.php','leformulaire');loadobjs();\" title=\"Ecouter la radio\"><img class=\"icones\" src=\"images/icones/radio.png\" class=\"site\"><label>Radio</label></a></td>\n";
  echo "";
  echo "";
  echo "";
  echo "</tr></table>\n";
}

if(isset($_SESSION["userid"]) && administrateur($_SESSION["userid"])){

  echo "<div class=\"zone\" id=\"titre\">Espace Administrateur</div>\n";
  echo "<table class=\"icones\"><tr>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin\" title=\"Administraton\"><img class=\"icones\" src=\"images/icones/admin.png\" class=\"site\"><label>Administration</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin&voir=nouvelles\" title=\"Nouvelles (Actualit&eacute; du site)\"><img class=\"icones\" src=\"images/icones/nouvelles.png\" class=\"site\"><label>Nouvelles</label></a></td>\n";

  echo "";
  echo "";

  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin&voir=utilisateurs\" title=\"Utilisateurs\"><img class=\"icones\" src=\"images/icones/user.png\" class=\"site\"><label>Utilisateurs</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin&voir=fichier\" title=\"Fichiers\"><img class=\"icones\" src=\"images/icones/fichiers.png\" class=\"site\"><label>Fichiers</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin&voir=pages\" title=\"Pages\"><img class=\"icones\" src=\"images/icones/pages.png\" class=\"site\"><label>Pages</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin&voir=redactionnel\" title=\"Contenu R&eacute;dactionnel\"><img class=\"icones\" src=\"images/icones/redactionnel.png\" class=\"site\"><label>R&eacute;dactionnel</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin&voir=tables\" title=\"Tables\"><img class=\"icones\" src=\"images/icones/tables.png\" class=\"site\"><label>Tables</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin&voir=erreur\" title=\"Erreurs\"><img class=\"icones\" src=\"images/icones/bug.png\" class=\"site\"><label>Erreurs</label></a></td>\n";
  echo "<td><a href=\"".$_SESSION["lien"]."?page=admin&voir=modules\" title=\"Modules\"><img class=\"icones\" src=\"images/icones/r2.png\" class=\"site\"><label>Modules</label></a></td>\n";
  echo "</tr></table>\n";
  
  echo "<div class=\"zone\" id=\"titre\">En ligne</div>\n";
  $sql = "select user.id,user.prenom,user.nom from user,connecte where user.id = connecte.co";
  $result = mysql_query($sql);
  echo "<ul>";
  echo "<li>".@$_SESSION["visiteur"]["inconnu"]." Visiteur".pluriel(@$_SESSION["visiteur"]["inconnu"])."";
  echo " & ".@$_SESSION["visiteur"]["connu"]." Membre".pluriel(@$_SESSION["visiteur"]["connu"])." sur ".@$_SESSION["visiteur"]["membre"]."</li>";
  while ($ligne = mysql_fetch_array($result)){
    echo "<li> <img src=\"images/icones/user.png\" id=\"image24\"> ".ucfirst($ligne["prenom"])." ".strtoupper($ligne["nom"])."</li>";
  }
  echo "</ul>\n";
}



if(isset($_SESSION["userid"]) && utilisateur($_SESSION["userid"])){
  $ok = false;
  echo "<div class=\"zone\" id=\"titre\">Votre actualit&eacute;</div>\n";
  $result = mysql_query("select * from messagerie where type='message' and archive ='' and destinataire='".$_SESSION["userid"]."' order by id desc");
  $nb = mysql_num_rows($result);
  if(@$nb <> 0){
    echo "<ul>\n";
      echo "<li>";
      echo "<b>Vous avez ".@$nb." Message".pluriel(@$nb).".</b>";
      echo "<a href=\"".$_SESSION["lien"]."?page=organiseur&voir=message\"><i> (Lire)</i></a>";
      echo "</li>\n";
    echo "</ul>\n";
    $ok = true;
  }
  $result = mysql_query("select * from tache where type='tache' and archive ='' and pere='".$_SESSION["userid"]."' order by id asc");
  $nb = mysql_num_rows($result);
  if(@$nb <> 0){
    echo "<ul>\n";
      echo "<li><b>Tache".pluriel(@$nb)." en cours .</b></li>";
      while ($ligne = @mysql_fetch_array($result)){
        echo "<li".categorie($ligne,"t").">";
        echo "<b>".$ligne["nom"]."</b> ".$ligne["contenu"]." <i>".$ligne["horloge"]."</i>";
        echo "</li>\n";
      }
    echo "</ul>\n";
    $ok = true;
  }
  if(!$ok){echo "<ul>\n<li><b>Rien &agrave; signaler.</b></li></ul>\n";}
}





echo "";
echo "<div class=\"zone\" id=\"titre\">Actualit&eacute; du site</div>\n";
if($result = mysql_query("select * from news where etat !='t' and archive= '' order by id DESC")){
  echo "<ul>\n";
  while ($ligne = @mysql_fetch_array($result)){
    echo "<li".categorie($ligne,"t").">";
      if($ligne["nom"]!=""){echo "<p><b>".$ligne["nom"]."</b>";}
      if($ligne["contenu"]!=""){echo "<br><i>".$ligne["contenu"]."</i>";}
      if($ligne["horloge"]!=""){echo "<br><i>".$ligne["horloge"]."</i>";}
    echo "</li>\n";
  }
  echo "</ul>\n";
}

echo "";
echo "<div id=\"fluxx\">\n";
echo "</div>\n";
echo "<script language=\"Javascript\">ajaxpage(rootdomain+'scripts/inc.rss.php','fluxx');</script>\n";

//echo "</div>\n";
?>


