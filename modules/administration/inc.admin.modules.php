<?php
if (file_exists("securite.php")){include("securite.php");}
    modules_droits();
    echo "<table width=\"100%\"><tr>";

    echo "<td>";
    echo "<div class=\"admin\" id=\"fixe\" style=\"text-align:center;\">";
    echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";
    echo "<input type=\"hidden\" name=\"action\" value=\"creationmodule\">";
    echo "<label>Nouveau module</label>";
    echo "<input type=\"text\" name=\"creationmodule\" value=\"\">";
    echo "</form>";
    echo "</div>\n";
    echo "</td>";
    
    echo "<td>";
    echo "<div class=\"admin\" id=\"fixe\" style=\"text-align:center;\">";
    echo "<form enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";
    echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
    echo "<input type=\"hidden\" name=\"table\" value=\"modules\">";
    echo "<input type=\"hidden\" name=\"form_horloge\" value=\"\">";
    echo "<input type=\"hidden\" name=\"form_pere\" value=\"\">";
    echo "<input type=\"hidden\" name=\"form_contenu\" value=\"\">";
    echo "<input type=\"hidden\" name=\"form_droits\" value=\"module\">";
    echo "<input type=\"hidden\" name=\"form_type\" value=\"droits\">";
    echo "<input type=\"hidden\" name=\"form_systeme\" value=\"\">";
    echo "<input type=\"hidden\" name=\"retourtable\" value=\"".@$_SESSION["table"]."\">";
    echo "<label>Ajouter un droit</label>";
    echo "<input type=\"text\" name=\"form_nom\" value=\"\">";
    echo "</form>";
    echo "</div>\n";
    echo "</td>";
    
    echo "</tr></table>";
    
    echo "<div class=\"admin\">";
    echo "<table>\n";
    echo "<tr>\n";
      echo "<td class=\"admin\" id=\"droits\" style=\"width:200px;vertical-align:top;\">";
      echo "<img src=\"".$_SESSION["ico"]["gris"]."\" class=\"admin\" id=\"image10\">";
      echo "<b>Liste des Modules</b>";
      echo "<hr>";
      echo "</td>\n";

      $droits = cherche_liste_droit_modules();
      reset($droits);
      while (list($key, $val) = each($droits)){
        echo "<td class=\"admin\" id=\"droits\" style=\"width:120px;vertical-align:top;\">";
        echo lien_supprimer($val["id"]);

        echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=modules&acte=formulaire&formulaire=modifier&modifier=".$val["id"]."','surpopup');loadobjs();\"><b>".ucfirst($key)."</b></a>";
        echo "<hr>";
        if($val["info"] != ""){echo "<i>".$val["info"]."</i>";}
        echo "";
        echo "</td>\n";
      }
    echo "</tr>\n";
    $r = mysql_query("select * from modules where type='module' order by nom asc");
    while ($mod = @mysql_fetch_array($r)){
      echo "<tr class=\"admin\">\n";
        echo "<td class=\"admin\" id=\"droits\" style=\"text-align:left;\">";
        echo lien_kill($mod);
        if(isset($mod["icone"]) && $mod["icone"] != ""){echo "<img src=\"".$mod["icone"]."\" id=\"image32\">";}
        echo lien_supprimer($mod["id"]);
        echo lien_editer($mod);
        //--------------------------
        
        echo "</td>\n";
        reset($droits);
        while (list($keydroit, $valdroit) = each($droits)){
          echo "<td class=\"admin\" id=\"droits\">";
          $s = mysql_query("select * from modules where nom='".$mod["nom"]."' and droits='".$keydroit."' and type='droits' order by id desc");
          $l = mysql_fetch_array($s);
          if(isset($l) && $l != ""){
            echo "<a class=\"admin\" href=\"".$_SESSION["lien"]."?table=modules&retourtable=modules&action=effaceligne&effaceligne=".$l["id"]."\" title=\"Annuler !\">";
            echo "<img src=\"".$_SESSION["ico"]["vert"]."\" class=\"admin\">";
            echo "</a>";
          }else{
            echo "<a class=\"admin\" href=\"".$_SESSION["lien"]."?table=modules&retourtable=modules&form_type=droits&action=sauvedata&form_droits=".$keydroit."&form_nom=".$mod["nom"]."&form_pere=".$mod["id"]."\" title=\"Autoriser !\">";
            echo "<img src=\"".$_SESSION["ico"]["gris"]."\" class=\"admin\">";
            echo "</a>";
          }
          echo "</td>\n";
        }
      echo "</tr>\n";
    }
    echo "</table>\n";
    echo "</div>\n";
    unset($droits);

function lien_kill($val){
  return "<a title=\"Tout supprimer (Table, fichiers, Dossier, Etc.)\" href=\"".$_SESSION["lien"]."?table=modules&action=supprimermodule&supprimermodule=".$val[1]."&supprimermoduleid=".$val[0]."\"><img src=\"images/jpg/interdit.jpg\" id=\"image10\"></a>&nbsp;&nbsp;&nbsp;";
}

function lien_editer($val){
  return "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=modules&acte=formulaire&formulaire=modifier&modifier=".$val[0]."','surpopup');loadobjs();\"><b>".ucfirst($val[1])."</b>&nbsp;</a>";
}

function lien_supprimer($id){
  return "<a class=\"admin\" href=\"".$_SESSION["lien"]."?table=modules&action=effaceligne&effaceligne=".$id."\" title=\"Supprimer !\"><img src=\"".$_SESSION["ico"]["rouge"]."\" id=\"image10\"></a>&nbsp;&nbsp;&nbsp;";
}

function cherche_liste_droit_modules(){
  $x = array();
  $result = mysql_query("select * from modules where droits='module' and type='droits' order by nom asc");
  while ($ligne = @mysql_fetch_array($result)){
    $x[$ligne["nom"]]= $ligne;
  }
  return $x;
}

?>
