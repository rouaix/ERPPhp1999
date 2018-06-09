<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

      echo "<div class=\"module\" id=\"ligne\"><a href=\"".$_SESSION["lien"]."?table=&montre=\" title=\"Retour !\">";
      echo "<img src=\"".$_SESSION["ico"]["retour"]."\" class=\"module\"><b>Liste des tables</b></a></div>\n";
      echo "<div class=\"module\" id=\"ligne\" style=\"text-align:center;\">";
      echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";
      echo "<input type=\"hidden\" name=\"action\" value=\"creationtable\">";
      echo "<label>Nouvelle table</label>";
      echo "Nom<input id=\"inline\" type=\"text\" name=\"creationtable\" value=\"\">";
      echo "<input type=\"image\" src=\"".$_SESSION["ico"]["valider"]."\" value=\"Valider\"  id=\"i16\" title=\"Cliquez pour valider\">";
      //echo "<br><input type=\"image\" value=\"Valider\" id=\"image16\" style=\"margin:5px;\" src =\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
      echo "</form>";
      echo "</div>\n";
    $result = mysql_query("SHOW TABLE STATUS FROM ".$_SESSION["base"]);
    while($ligne = mysql_fetch_assoc($result)){$status[$ligne["Name"]]=$ligne["Comment"];}
    $sql = "SHOW TABLES FROM ".$_SESSION["base"];
    $result = mysql_query($sql);
    while ($row = mysql_fetch_row($result)){
      $nresult = mysql_query("SELECT * FROM ".$row[0]."");
      $num_rows = mysql_num_rows($nresult);
      echo "<div class=\"module\" id=\"ligne\">";
      echo "<a href=\"".$_SESSION["lien"]."?effacetable=".$row[0]."&action=effacetable&retourtable=".@$_SESSION["table"]."\" title=\"Supprimer !\">";
      echo "<img src=\"".$_SESSION["ico"]["supprimer"]."\" class=\"module\"></a>\n";
      echo "";
      if($num_rows > 0){
        echo "<a title=\"Voir le contenu de la table !\" href=\"".$_SESSION["lien"]."?table=$row[0]&montre=contenutable\"><b>".ucfirst($row[0])."</b> [".$num_rows."]</a>";
        echo "<i> (".$status[$row[0]].")</i>";
      }else{
        //echo "<a class=\"admin\" href=\"".$_SESSION["lien"]."?table=".$row[0]."&montre=nouvelleligne\" title=\"Ajouter !\"><img src=\"".$_SESSION["ico"]["ajouter"]."\" class=\"admin\"></a>";
        echo "<a title=\"Ajouter\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=".$row[0]."&acte=formulaire&formulaire=nouveau','surpopup');\">";
        echo "<img src=\"".$_SESSION["ico"]["ajouter"]."\" class=\"module\">";
        echo "<b>".ucfirst($row[0])."</b></a>";
      }
      echo "</div>\n";
    }
    unset($status);
?>