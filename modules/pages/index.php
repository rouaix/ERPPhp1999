<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
echo "<div style=\"color:#".@$_SESSION["modules"]["couleurtexte"][$_SESSION["page"]].";background-color:#".@$_SESSION["modules"]["couleurfond"][$_SESSION["page"]].";\">";
      echo "<div class=\"admin\" id=\"fixe\">";
      //echo "<a class=\"admin\" title=\"Ajouter une Nouvelle\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=nouveauformulaire&table=news','surpopup');loadobjs();\">";
      echo "<a class=\"admin\" title=\"Ajouter une page\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?acte=formulaire&formulaire=nouveau&table=pages','surpopup');loadobjs();\">";
      echo "<img class=\"admin\" src=\"".$_SESSION["ico"]["voir"]."\">";
      echo "<b>Ajouter une page</b>";
      echo "</a>";
      echo "</div>\n";
      $sql ="select * from pages order by nom asc";
      $result = mysql_query($sql)or die("erreur ".$_SESSION["table"]." !");
      while ($ligne = mysql_fetch_array($result)) {
      echo "<div class=\"admin\" id=\"fixe\">";
      echo "<a class=\"admin\" href=\"".$_SESSION["lien"]."?table=pages&action=effaceligne&effaceligne=".$ligne["id"]."\" title=\"Supprimer !\">";
      echo "<img src=\"".$_SESSION["ico"]["rouge"]."\" id=\"image10\"></a>\n";
      echo "&nbsp;&nbsp;&nbsp;";
      echo "<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"image14\" title=\"Afficher !\" onclick=\"javascript:voir('pa".$ligne["id"]."');\">";
      if($ligne["etat"]=="t"){echo ico_annuleterminer($ligne["id"],"pages");}else{echo ico_terminer($ligne["id"],"pages");}
      echo "&nbsp;&nbsp;&nbsp;";
      if($ligne["etat"]=="t"){echo "<s>";}
      echo "<a class=\"admin\" title=\"Modifier !\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=pages&acte=formulaire&formulaire=modifier&modifier=".$ligne["id"]."','surpopup');loadobjs();\">";
      echo "<b>".$ligne["nom"]."</b>";
      echo "</a>\n";
      if($ligne["etat"]=="t"){echo "</s>";}
      echo "</div>\n";
      echo "<div class=\"admin\" id=\"pa".$ligne["id"]."\" style=\"display:none;\">";
      echo "<p>".nl2br($ligne["contenu"])."<p>".nl2br($ligne["info"])."<p><i style=\"float:right;\">".$ligne["horloge"]."</i>";
      echo "</div>\n";
      }
echo "</div>";


?>