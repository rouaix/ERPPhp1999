<?php 
//if (file_exists("securite.php")){include("securite.php");}

if(file_exists("scripts/modules/agenda/fonctions.php")){include("scripts/modules/agenda/fonctions.php");}else{erreur_404("Agenda Fonctions");}
  
echo "<div class=\"module\" id=\"titre\">";
echo "<a class=\"module\" id=\"titre\" href=\"".$_SESSION["lien"]."?page=agenda&mpage=preferences&inc=hv\" title=\"Modifer les horaires variables\">Modifer les horaires variables</a>";
texte_separe();
echo "<a class=\"module\" href=\"".$_SESSION["lien"]."?page=agenda&mpage=preferences&inc=hf\" title=\"Modifer les horaires fixes\">Modifer les horaires fixes</a>";
echo "</div>";

switch (@$_SESSION["inc"]) {
  default :
    echo "<div class=\"module\" id=\"titre\">Horaires fixes</div>";
    //echo "<div class=\"module\" id=\"titre\">Tous les jours</div>";    
    affiche_horaire("","hf");
  break;

  case "hv":
    if(isset($_SESSION["semaine"]) && @$_SESSION["semaine"] != ""){$_SESSION["jour"] = mktime (0,0,0,01,(01+($_SESSION["semaine"]*7)),date("Y",$_SESSION["jour"]));}
    echo "<div class=\"module\" id=\"titre\">Horaires variables";
    if(isset($_SESSION["semaine"])){
      echo " - Semaine ".date("W",$_SESSION["jour"]);
      $t = mktime(0, 0, 0, date("m",$_SESSION["jour"]), ((date("j",$_SESSION["jour"])- date("N",$_SESSION["jour"]))+1), date("Y",$_SESSION["jour"]));
      echo " - du ".date("d/m/Y",$t);
      $t = mktime(0, 0, 0, date("m",$_SESSION["jour"]), ((date("j",$_SESSION["jour"])- date("N",$_SESSION["jour"]))+7), date("Y",$_SESSION["jour"]));
      echo " au ".date("d/m/Y",$t);
    }
    echo "</div>";
    
    $nbsemaine = semaine_nombre(date("Y")); 
    echo "<div class=\"module\">";
    echo "<form name=\"formsemaine\" enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";
    echo "<select name=\"semaine\" style=\"width:300px;margin-bottom:5px;\" onchange=\"submit(this);\">";
    echo "<option value=\"\">Choisir le N° de semaine</option>";
    for ($x = 1; $x <= $nbsemaine; $x++){
      //$x = str_pad($x, 2, "0", STR_PAD_LEFT);
      $lien = "";
      echo "<option value=\"".$x."\" ";
      if(isset($_SESSION["semaine"])){
        if($_SESSION["semaine"] == $x){echo "selected";}
      }
      echo ">Semaine N° ".str_pad($x, 2, "0", STR_PAD_LEFT)."</option>\n";      
    }   
    echo "</select>";
    echo "<input type=\"hidden\" name=\"inc\" value=\"hv\">";
    echo "<input type=\"hidden\" name=\"page\" value=\"agenda\">";
    echo "<input type=\"hidden\" name=\"mpage\" value=\"preferences\">";
    echo "</form>";
    echo "</div>"; 
    if(isset($_SESSION["semaine"]) && @$_SESSION["semaine"] != ""){
      affiche_horaire($_SESSION["semaine"],"hv");
    }
    unset($lien);
  break;
}

//affiche_horaire("");

function affiche_horaire($semaine,$type){
  for($x=1;$x<8;$x++){
    echo "<div class=\"module\" id=\"titre\">".jour_texte($x)."</div>";
    
    echo "<div class=\"module\" id=\"block\">";
    echo "<form name=\"ff".jour_texte($x).$x."\" enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";
    echo "<label class=\"module\" id=\"ligne\">"."D&eacute;but"."</label>";
    echo "<input id=\"dheu".$x."\" type=\"text\" name=\"form_debut_preferences\" value=\"00:00\">";
    $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=dheu".$x."','surpop');loadobjs();\"";
    echo "<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\" ".$lien." style=\"margin-right:5px;margin-left:5px;\">";
    echo "<label class=\"module\" id=\"ligne\">"."Fin"."</label>";
    echo "<input id=\"fheu".$x."\" type=\"text\" name=\"form_fin_preferences\" value=\"00:00\">";
    $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=fheu".$x."','surpop');loadobjs();\"";
    echo "<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\" ".$lien." style=\"margin-right:5px;margin-left:5px;\">";
    echo "<input type=\"image\" src=\"".$_SESSION["ico"]["valider"]."\" id=\"i14\" title=\"Valider\" name=\"submit\" onClick=\"submit();\">";
    echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
    echo "<input type=\"hidden\" name=\"table\" value=\"preferences\">";
    echo "<input type=\"hidden\" name=\"form_jour_preferences\" value=\"".mktime(0, 0, 0, date("m",$_SESSION["jour"]), ((date("j",$_SESSION["jour"])- date("N",$_SESSION["jour"]))+$x), date("Y",$_SESSION["jour"]))."\">";
    echo "<input type=\"hidden\" name=\"form_nom_preferences\" value=\"".strtolower(jour_texte($x))."\">";
    echo "<input type=\"hidden\" name=\"form_id_user\" value=\"".$_SESSION["userid"]."\">";
    echo "<input type=\"hidden\" name=\"form_type_preferences\" value=\"".$type."\">";
    echo "<input type=\"hidden\" name=\"page\" value=\"agenda\">";
    echo "<input type=\"hidden\" name=\"mpage\" value=\"preferences\">";
    echo "</form>";
    echo "</div>";
        
    $result = mysql_query("select * from preferences where nom_preferences='".strtolower(jour_texte($x))."' and type_preferences='".$type."' and id_user='".$_SESSION["userid"]."' and etat_preferences='' order by debut_preferences");
    if($result){
      while ($ligne = mysql_fetch_array($result)){
        
        if($type == "hv"){
          if(date("W",strtotime($ligne["debut_preferences"])) == $semaine){
            echo "<div class=\"module\" id=\"block\">";
            echo "<form class=\"module\" name=\"fdx".$ligne["id_preferences"]."\" enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";        
            echo "<a style=\"float:right;\" href=\"".$_SESSION["lien"]."?table=preferences&action=effaceligne&effaceligne=".$ligne["id_preferences"]."\" title=\"Supprimer !\n\nAttention !\nCette action est d&eacute;finitive !\"><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i14\"></a>";
            echo "<label class=\"module\" id=\"ligne\">"."D&eacute;but"."</label>";
            echo "<input id=\"dheurex".$ligne["id_preferences"]."\" type=\"text\" name=\"form_debut_preferences\" value=\"".date("H:i",strtotime($ligne["debut_preferences"]))."\">";
            $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=dheurex".$ligne["id_preferences"]."','surpop');loadobjs();\"";
            echo "<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\" ".$lien." style=\"margin-right:5px;margin-left:5px;\">";
            echo "<label class=\"module\" id=\"ligne\">"."Fin"."</label>";
            echo "<input id=\"fheurex".$ligne["id_preferences"]."\" type=\"text\" name=\"form_fin_preferences\" value=\"".date("H:i",strtotime($ligne["fin_preferences"]))."\">";
            $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=fheurex".$ligne["id_preferences"]."','surpop');loadobjs();\"";
            echo "<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\" ".$lien." style=\"margin-right:5px;margin-left:5px;\">";
            echo "<input type=\"image\" src=\"".$_SESSION["ico"]["valider"]."\" id=\"i14\" title=\"Valider\" name=\"submit\" onClick=\"submit();\">";
            echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
            echo "<input type=\"hidden\" name=\"table\" value=\"preferences\">";
            echo "<input type=\"hidden\" name=\"form_jour_preferences\" value=\"".mktime(0, 0, 0, date("m",$_SESSION["jour"]), ((date("j",$_SESSION["jour"])- date("N",$_SESSION["jour"]))+$x), date("Y",$_SESSION["jour"]))."\">";
            echo "<input type=\"hidden\" name=\"form_id_preferences\" value=\"".$ligne["id_preferences"]."\">";
            echo "<input type=\"hidden\" name=\"form_nom_preferences\" value=\"".$ligne["nom_preferences"]."\">";
            echo "<input type=\"hidden\" name=\"form_id_user\" value=\"".$_SESSION["userid"]."\">";
            echo "<input type=\"hidden\" name=\"form_type_preferences\" value=\"".$type."\">";
            echo "<input type=\"hidden\" name=\"page\" value=\"agenda\">";
            echo "<input type=\"hidden\" name=\"mpage\" value=\"preferences\">";
            echo "</form>";
            echo "</div>";          
          }
        }else{
          echo "<div class=\"module\" id=\"block\">";
          echo "<form class=\"module\" name=\"fdx".$ligne["id_preferences"]."\" enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";        
          echo "<a style=\"float:right;\" href=\"".$_SESSION["lien"]."?table=preferences&action=effaceligne&effaceligne=".$ligne["id_preferences"]."\" title=\"Supprimer !\n\nAttention !\nCette action est d&eacute;finitive !\"><img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"i14\"></a>";
          echo "<label class=\"module\" id=\"ligne\">"."D&eacute;but"."</label>";
          echo "<input id=\"dheurex".$ligne["id_preferences"]."\" type=\"text\" name=\"form_debut_preferences\" value=\"".date("H:i",strtotime($ligne["debut_preferences"]))."\">";
          $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=dheurex".$ligne["id_preferences"]."','surpop');loadobjs();\"";
          echo "<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\" ".$lien." style=\"margin-right:5px;margin-left:5px;\">";
          echo "<label class=\"module\" id=\"ligne\">"."Fin"."</label>";
          echo "<input id=\"fheurex".$ligne["id_preferences"]."\" type=\"text\" name=\"form_fin_preferences\" value=\"".date("H:i",strtotime($ligne["fin_preferences"]))."\">";
          $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=fheurex".$ligne["id_preferences"]."','surpop');loadobjs();\"";
          echo "<img src=\"".$_SESSION["ico"]["voir"]."\" id=\"i14\" ".$lien." style=\"margin-right:5px;margin-left:5px;\">";
          echo "<input type=\"image\" src=\"".$_SESSION["ico"]["valider"]."\" id=\"i14\" title=\"Valider\" name=\"submit\" onClick=\"submit();\">";
          echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
          echo "<input type=\"hidden\" name=\"table\" value=\"preferences\">";
          echo "<input type=\"hidden\" name=\"form_jour_preferences\" value=\"".mktime(0, 0, 0, date("m",$_SESSION["jour"]), ((date("j",$_SESSION["jour"])- date("N",$_SESSION["jour"]))+$x), date("Y",$_SESSION["jour"]))."\">";
          echo "<input type=\"hidden\" name=\"form_id_preferences\" value=\"".$ligne["id_preferences"]."\">";
          echo "<input type=\"hidden\" name=\"form_nom_preferences\" value=\"".$ligne["nom_preferences"]."\">";
          echo "<input type=\"hidden\" name=\"form_id_user\" value=\"".$_SESSION["userid"]."\">";
          echo "<input type=\"hidden\" name=\"form_type_preferences\" value=\"".$type."\">";
          echo "<input type=\"hidden\" name=\"page\" value=\"agenda\">";
          echo "<input type=\"hidden\" name=\"mpage\" value=\"preferences\">";
          echo "</form>";
          echo "</div>";        
        }
      }
    }
  }
}
?>