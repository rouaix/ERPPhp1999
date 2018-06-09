<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

    echo "<div class=\"module\" id=\"ligne\"><a href=\"".$_SESSION["lien"]."?table=&montre=\" title=\"Retour !\"><img src=\"".$_SESSION["ico"]["retour"]."\" class=\"module\"><b>Droits des tables</b></a></div>\n";
      echo "<div class=\"module\" id=\"ligne\" style=\"text-align:center;\">";
      echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";
      echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
      echo "<input type=\"hidden\" name=\"table\" value=\"droits\">";
      echo "<input type=\"hidden\" name=\"retourtable\" value=\"".@$_SESSION["table"]."\">";      
      echo "<label>Ajouter un type de droit</label>";      
      echo "Nom<input id=\"inline\" type=\"text\" name=\"form_nom_droits\" value=\"\" title=\"Nom\">";                     
      echo "<input type=\"hidden\" name=\"form_etat_droits\" value=\"\">"; 
      echo "<input type=\"hidden\" name=\"form_type_droits\" value=\"table\">";     
      echo "<input type=\"hidden\" name=\"form_nom_table\" value=\"\">";           
      echo "<input type=\"hidden\" name=\"form_nom_champs\" value=\"\">";
      echo "<input type=\"hidden\" name=\"form_id_droits\" value=\"\">";
      echo "<input type=\"hidden\" name=\"form_id_user\" value=\"\">";
      echo "<input type=\"hidden\" name=\"form_id_groupe\" value=\"\">";
      echo "<input type=\"hidden\" name=\"form_id_categorie\" value=\"\">";
      echo "<input type=\"hidden\" name=\"form_id_societe\" value=\"\">";
      echo "<input type=\"image\" src=\"".$_SESSION["ico"]["valider"]."\" value=\"Valider\"  id=\"i16\" title=\"Cliquez pour valider\">";      
      echo "</form>";
    echo "</div>\n";
    
    echo "<div class=\"module\">";
    echo "<table>\n";
    echo "<tr>\n";
    echo "<td id=\"milieu\"><b>Tables</b></td>\n";
    
    @reset($liste_droits_tables);
    
    while (list(,$val) = @each($liste_droits_tables)){
      echo "<td class=\"module\" id=\"droits\">";      
      echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=droits&acte=formulaire&formulaire=modifier&modifier=".$val["id_droits"]."','surpopup');loadobjs();\">";
      echo "<b>".ucfirst($val["nom_droits"])."</b>";
      echo "</a>";
      echo "<hr>";
      echo "<a href=\"".$_SESSION["lien"]."?table=droits&retourtable=".@$_SESSION["table"]."&action=effaceligne&effaceligne=".$val["id_droits"]."\" title=\"Supprimer !\"><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i10\"></a>";      
      echo "<br>N° ".$val["id_droits"]."";     
      if($val["info_droits"] != ""){echo "<hr><i class=\"module\">".nl2br($val["info_droits"])."</i>";}
      echo "</td>\n";
    }
    echo "</tr>\n";
    $result = mysql_query("SHOW TABLES FROM ".$_SESSION["base"]);
    while ($ligne = mysql_fetch_row($result)){
      echo "<tr id=\"hover\">\n";
      echo "<td class=\"module\" id=\"nom\">";
      echo "<a title=\"Droits des champs !\" href=\"".$_SESSION["lien"]."?table=".$ligne[0]."&montre=droitsdeschamps\">";
      echo "<img src=\"".$_SESSION["ico"]["voir"]."\" class=\"module\">";
      echo "<b>".ucfirst($ligne[0])."</b>\n";
      echo "</a>";
      echo "</td>\n";
      @reset($liste_droits_tables);
      while (list(,$liste_tables) = @each($liste_droits_tables)){
        $ok = "";
        reset($droits);
        while(list($te,$tes) = each($droits)){          
          if(
          $tes["nom_table"] == $ligne[0] &&
          $tes["nom_droits"] == "droits" &&
          $tes["valeur_droits"] == $liste_tables["id_droits"]
          )
          {$ok = $tes;}
        }
        echo "<td class=\"module\" id=\"droits\">";
        if($ok > 0){
          echo "<a href=\"".$_SESSION["lien"]."?";
          echo "table=droits&retourtable=".$ligne[0];
          echo "&action=effaceligne";
          echo "&effaceligne=".$ok["id_droits"];
          echo "\" title=\"Annuler !\">";
          echo "<img src=\"".$_SESSION["ico"]["actif"]."\" class=\"module\">";
          echo "</a>";
        }else{
          echo "<a href=\"".$_SESSION["lien"]."?";
          echo "table=droits";
          echo "&retourtable=".$ligne[0];          
          echo "&form_nom_droits=droits";          
          echo "&form_type_droits=table";          
          echo "&form_nom_table=".$ligne[0];
          echo "&form_valeur_droits=".$liste_tables["id_droits"];          
          echo "&action=sauvedata";
          //echo "&form_contenu=".$liste_tables["nom"];
          echo "\" title=\"Autoriser !\">";
          echo "<img src=\"".$_SESSION["ico"]["inactif"]."\" class=\"module\">";
          echo "</a>";
        }
        echo "</td>\n";
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
    echo "</div>\n";
    unset($temp);

?>