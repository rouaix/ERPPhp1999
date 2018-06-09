<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

      echo "<div class=\"module\"><b>Liste des utilisateurs</b></div>\n";
      $sql ="select * from user order by prenom_user,nom_user,id_user asc";
      $result = mysql_query($sql)or die("erreur User !");
      while ($ligne = mysql_fetch_array($result)){
        echo "<div class=\"module\" id=\"ligne\">";
        echo "<a href=\"".$_SESSION["lien"]."?table=user&action=effaceligne&effaceligne=".$ligne["id_user"]."\" title=\"Supprimer !\">";
        echo "<img class=\"module\" src=\"".$_SESSION["ico"]["rouge"]."\" id=\"i10\"></a>";
        if(utilisateur_banni($ligne["id_user"])){
          echo "<a href=\"".$_SESSION["lien"]."?table=user&form_id_user=".$ligne["id_user"]."&form_type_user=user&action=sauvedata\" title=\"Banni. Cliquez pour autoriser\">";
          echo "<img class=\"module\" src=\"".$_SESSION["ico"]["orange"]."\"></a>";
        }else{
          if(administrateur($ligne["id_user"])){
            echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?table=user&form_id_user=".$ligne["id_user"]."&form_systeme_user= &action=sauvedata\" title=\"Administrateur. Cliquez pour supprimmer ces droits.\">";
            echo "<img class=\"module\" src=\"".$_SESSION["ico"]["bleu"]."\"></a>";
          }else{
            if(utilisateur($ligne["id_user"])){
              echo "<a href=\"".$_SESSION["lien"]."?table=user&form_id_user=".$ligne["id_user"]."&form_type_user=banni&action=sauvedata\" title=\"Utlisateur. Cliquez pour bannir\">";
              echo "<img class=\"module\" src=\"".$_SESSION["ico"]["vert"]."\"></a>";
              echo "<a href=\"".$_SESSION["lien"]."?table=user&form_id_user=".$ligne["id_user"]."&form_systeme_user=A&action=sauvedata&form_controle=1\" title=\"Utlisateur. Cliquez pour devenir administrateur\">";
              echo "<img class=\"module\" src=\"".$_SESSION["ico"]["bleu"]."\"></a>";

            }
          }
        }
        echo "<b>".ucfirst($ligne["prenom_user"])." ".strtoupper($ligne["nom_user"])."</b>";
        echo "<p class=\"module\">";
        echo " Connexions r&eacute;centes ";
        $r = mysql_query("select * from hit where id_user='".$ligne["id_user"]."' order by id_hit desc limit 1000");
        $cpte = 0;
        $somme = 0;
        $unite = array('Seconde','Minute','Heure');
        while ($c = mysql_fetch_array($r)){
          if($somme == 0){$somme = $c["horloge_hit"];}
          if($c["nom_hit"] == "Login"){
            if($cpte < 3){
              $size = $somme - $x;
              $s = @round($size/pow(60,($i=floor(log($size,60)))),0);
              echo "<span> | </span>";
              echo "".date("d/m/Y H:i",$c["horloge_hit"])." ";
              echo "<i style=\"color:#666;\"> (Dur&eacute;e ".@$s." ".@$unite[$i].@pluriel($s).")</i> ";
              $somme = 0;
              $cpte ++;
            }
          }
          $x = $c["horloge_hit"];
        }
        echo "<span> | </span> ";
        echo "</div>\n";
      }

?>