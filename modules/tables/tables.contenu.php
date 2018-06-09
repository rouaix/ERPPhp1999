<?php
if(file_exists("../../securite.php")){include("../../securite.php");}


    $result = mysql_query("SHOW FULL COLUMNS FROM ".@$_SESSION["table"]);
    while($ligne = mysql_fetch_assoc($result)){$status[$ligne["Field"]] = $ligne['Comment'];}
    echo "<div class=\"module\" id=\"ligne\">";
    if(@$_SESSION["table"]!=""){
      echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?table=".@$_SESSION["table"]."&montre=listedestables\" title=\"Retour !\"><img src=\"".$_SESSION["ico"]["retour"]."\" class=\"module\"></a>\n";
    }
    
    echo "<a title=\"Ajouter\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=".@$_SESSION["table"]."&acte=formulaire&formulaire=nouveau','surpopup');\">";
    
    //echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?table=".@$_SESSION["table"]."&montre=nouvelleligne\" title=\"Ajouter !\">";
    echo "<img src=\"".$_SESSION["ico"]["ajouter"]."\" class=\"module\"></a>\n";
    echo "Contenu de la table (".@$_SESSION["table"].")";
    echo "</div>\n";
    $sql ="select * from ".@$_SESSION["table"]." order by id_".$_SESSION["table"]." desc";
    $result = mysql_query($sql)or die("erreur ".@$_SESSION["table"]." !");
    while ($ligne = mysql_fetch_array($result)) {
      echo "<div class=\"module\" id=\"ligne\">";
      echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?table=".@$_SESSION["table"]."&retourtable=".@$_SESSION["table"]."&action=effaceligne&effaceligne=".$ligne["id_".$_SESSION["table"]]."\" title=\"Supprimer !\">";
      echo "<img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"image10\"></a>\n";
      echo "&nbsp;&nbsp;&nbsp;";
      echo lien_editer($ligne);
      echo "</a>\n";
      echo "</div>\n";
    }
    unset($status);
?>