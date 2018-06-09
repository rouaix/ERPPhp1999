<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

    echo "<div class=\"module\" id=\"ligne\"><a href=\"".$_SESSION["lien"]."?table=".@$_SESSION["table"]."&montre=droitsdestables\" title=\"Retour !\"><img src=\"".$_SESSION["ico"]["retour"]."\" class=\"module\"><b>Droits des champs</b></a> (".ucfirst(@$_SESSION["table"]).")</div>\n";
      echo "<div class=\"module\" id=\"ligne\" style=\"text-align:center;\">";
      echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";
      echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
      echo "<input type=\"hidden\" name=\"table\" value=\"droits\">";
      echo "<input type=\"hidden\" name=\"retourtable\" value=\"".@$_SESSION["table"]."\">";
      echo "<input type=\"hidden\" name=\"form_type_droits\" value=\"champs\">";
      echo "<label>Ajouter un type de droit</label>";      
      echo "Nom<input id=\"inline\" type=\"text\" name=\"form_nom_droits\" value=\"\" title=\"Nom\">";     
      echo "<input type=\"image\" src=\"".$_SESSION["ico"]["valider"]."\" value=\"Valider\"  id=\"i16\" title=\"Cliquez pour valider\">";
      echo "</form>";
      echo "</div>\n";
    echo "<div class=\"module\">";

    $result = mysql_query("SHOW FULL COLUMNS FROM ".@$_SESSION["table"]);
    while($ligne = mysql_fetch_assoc($result)){
      $champs[$ligne["Field"]] = $ligne['Comment'];
    }

    echo "<table>\n";
    echo "<tr>\n";
    echo "<td id=\"milieu\"><b>Champs</b></td>\n";

    @reset($liste_droits_champs);
    while (list($key, $val) = @each($liste_droits_champs)){
      echo "<td class=\"module\" id=\"droits\">";
      echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=droits&acte=formulaire&formulaire=modifier&modifier=".$val["id_droits"]."','surpopup');loadobjs();\">";
      echo "<b>".ucfirst($val["nom_droits"])."</b>";
      echo "</a>";      
      //echo "<hr>";
      //echo "<b>".$val["id"]."</b>";
      echo "<hr>";
      echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?table=droits&retourtable=".@$_SESSION["table"]."&action=effaceligne&effaceligne=".$val["id_droits"]."\" title=\"Supprimer !\"><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"image10\"></a>";      
      
      echo "<br>N° ".$val["id_droits"]."";
      if($val["info_droits"] != ""){echo "<hr><i>".nl2br($val["info_droits"])."</i>";}
      echo "</td>\n";
    }
    echo "</tr>\n";

    while (list($k_champs, $val) = each($champs)){
      echo "<tr>\n";
      echo "<td class=\"module\" id=\"nom\"><b>".ucfirst($k_champs)."</b></td>\n";      
      
      @reset($liste_droits_champs);
      while (list(, $liste) = @each($liste_droits_champs)){     
        echo "<td class=\"module\" id=\"droits\">";
        $ok = "" ;
        
        reset($droits);
        while(list($te,$tes) = each($droits)){          
          if(
          $tes["nom_table"] == $_SESSION["table"] &&
          $tes["nom_droits"] == "droits" &&
          $tes["nom_champs"] == $k_champs &&
          $tes["valeur_droits"] == $liste["id_droits"]
          )
          {$ok = $tes;}
        }
                
        if (is_array($ok)){
          echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?table=droits&retourtable=".@$_SESSION["table"]."&action=effaceligne&effaceligne=".$ok["id_droits"]."\" title=\"Annuler !\">";
          echo "<img src=\"".$_SESSION["ico"]["actif"]."\" class=\"module\">";
          echo "</a>";
        }else{
          echo "<a class=\"module\" href=\"".$_SESSION["lien"];
          echo "?table=droits";
          echo "&form_type_droits=champs";
          
          echo "&form_nom_droits=droits";
          echo "&form_nom_champs=".$k_champs;
          
          echo "&action=sauvedata";
          echo "&form_nom_table=".@$_SESSION["table"];
          
          echo "&retourtable=".@$_SESSION["table"];
          echo "&form_valeur_droits=".$liste["id_droits"];
          //echo "&form_nom_table=".$liste["nom"];
          
          echo "\" title=\"Autoriser !\">";
          echo "<img src=\"".$_SESSION["ico"]["inactif"]."\" class=\"module\">";
          echo "</a>";
        }
        echo "</td>\n";
      }

      //----------------------
      echo "</tr>\n";
    }
    echo "</table>\n";
    echo "</div>";

    unset($x);
    unset($champs);
    unset($listedroits);

?>