<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
echo "<div style=\"color:#".@$_SESSION["modules"]["couleurtexte"][$_SESSION["page"]].";background-color:#".@$_SESSION["modules"]["couleurfond"][$_SESSION["page"]].";\">";
      echo "<div class=\"admin\" id=\"fixe\">";
      //echo "<a class=\"admin\" title=\"Ajouter une Nouvelle\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=nouveauformulaire&table=news','surpopup');loadobjs();\">";
      echo "<a class=\"admin\" title=\"Ajouter du Contenu R&eacute;dactionnel\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?acte=formulaire&formulaire=nouveau&table=redactionnel','surpopup');loadobjs();\">";
      echo "<img class=\"admin\" src=\"".$_SESSION["ico"]["voir"]."\">";
      echo "<b>Ajouter du contenu</b>";
      echo "</a>";
      echo "</div>\n";
      $sql ="select * from redactionnel order by id asc";
      $result = mysql_query($sql)or die("erreur ".$_SESSION["table"]." !");
      while ($ligne = mysql_fetch_array($result)) {
      echo "<div class=\"admin\" id=\"fixe\">";
      echo "<a class=\"admin\" href=\"".$_SESSION["lien"]."?table=redactionnel&action=effaceligne&effaceligne=".$ligne["id"]."\" title=\"Supprimer !\">";
      echo "<img src=\"".$_SESSION["ico"]["rouge"]."\" id=\"image10\"></a>\n";
      echo "&nbsp;&nbsp;&nbsp;";
      if($ligne["etat"]=="t"){echo ico_annuleterminer($ligne["id"],"redactionnel");}else{echo ico_terminer($ligne["id"],"redactionnel");}
      echo "&nbsp;&nbsp;&nbsp;";
      if($ligne["etat"]=="t"){echo "<s>";}
      echo "<a class=\"admin\" title=\"Modifier !\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=redactionnel&acte=formulaire&formulaire=modifier&modifier=".$ligne["id"]."','surpopup');loadobjs();\">";
      echo "<b>".$ligne["nom"]."</b> (".$ligne["contenu"].") <i style=\"float:right;\">".$ligne["horloge"]."</i>";
      echo "</a>\n";
      if($ligne["etat"]=="t"){echo "</s>";}
      echo "</div>\n";
      }
echo "</div>";


?>