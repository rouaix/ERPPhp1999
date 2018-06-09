<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

       //echo "<div class=\"module\" id=\"ligne\">";

      //module_titre("icones","");
       
      $sql ="select * from icones order by nom_icones asc";
      if($result = mysql_query($sql)){
    //$nb = nombre_longueur(mysql_num_rows($result),3);
    //echo "<div class=\"module\" id=\"titre\">".$nb." Enregistrement".pluriel($nb)."</div>\n";
      
      while ($ligne = mysql_fetch_array($result)) {
      echo "<div class=\"module\" id=\"ligne\">";
      
      echo ico_supprimer($ligne,"icones");
      if(isset($ligne["lien_icones"])){echo "<img class=\"module\" src=\"".$ligne["lien_icones"]."\" height=\"32px\">\n";}
      echo ico_termine($ligne,"icones");      

      if($ligne["etat_icones"]=="t"){echo "<s>";}
      echo "<a title=\"Modifier !\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=icones&acte=formulaire&formulaire=modifier&modifier=".$ligne["id_icones"]."','surpopup');loadobjs();\">";
      echo "<b>".ucfirst($ligne["nom_icones"])."</b>";
      
      if(isset($ligne["info_icones"]) && $ligne["info_icones"] != ""){
        echo " (".$ligne["info_icones"].")";
      }
      echo "</a>\n";
      if($ligne["etat_icones"]=="t"){echo "</s>";}
      echo "</div>\n";
    }
    }
//echo "</div>";

unset($_SESSION["ico"]);
?>