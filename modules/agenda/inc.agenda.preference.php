<?php 
if (file_exists("securite.php")){include("securite.php");}

echo "<br><br>";
echo "<a class=\"agenda\" href=\"".$_SESSION["lien"]."?page=agenda&voir=preference&inc=hv\" title=\"Modifer les horaires variables\">Modifer les horaires variables</a>";
echo "<span class=\"separe\">|</span>";
echo "<a class=\"agenda\" href=\"".$_SESSION["lien"]."?page=agenda&voir=preference&inc=hf\" title=\"Modifer les horaires fixes\">Modifer les horaires fixes</a>";
echo "<br><br>";

switch (@$_SESSION["inc"]) {
  default :
  break;

  case "*hf":
    //echo "<h4>Horaires fixes</h4>";
    affiche_horaire("");                   
  break;

  case "*hv":
    //echo "<h4>Horaires variables</h4>";
    $nbsemaine = date('W',mktime(0, 0, 0, "12","31", date("Y")));    
    echo "<form class=\"agenda\" name=\"formsemaine\" enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";
    echo "<select class=\"agenda\" name=\"semaine\" style=\"width:300px;margin-bottom:5px;\" onchange=\"submit(this);\">";
    echo "<option class=\"agenda\" value=\"\">Choisir le N° de semaine</option>";
    for ($x = 1; $x <= $nbsemaine; $x++){
      $x = str_pad($x, 2, "0", STR_PAD_LEFT);
      $lien = "";
      echo "<option class=\"agenda\" value=\"".$x."\" ";
      if(isset($_SESSION["semaine"])){
        if($_SESSION["semaine"] == $x){echo "selected";}
      }
      echo ">Semaine N° ".$x."</option>\n";      
    }   
    echo "</select>";
    echo "<input type=\"hidden\" name=\"inc\" value=\"hv\">";
    echo "<input type=\"hidden\" name=\"page\" value=\"agenda\">";
    echo "<input type=\"hidden\" name=\"voir\" value=\"preference\">";
    echo "</form>"; 
    if(isset($_SESSION["semaine"]) && @$_SESSION["semaine"] != ""){
      affiche_horaire($_SESSION["semaine"]);
    }
    unset($lien);
  break;
}

affiche_horaire("");

function affiche_horaire($semaine){
  cherche_heure_travail();
  echo "<h3>Jours travaill&eacute;s</h3>";
  
  for($x=1;$x<7;$x++){

    echo "<b>".jour_texte_num($x)."</b>";
    echo "<div>";

    $result = mysql_query("select * from preference where nom='".strtolower(jour_texte_num($x))."' and type='hf' and pere='".$_SESSION["userid"]."' and archive='' order by id,debut");
    if($result){
      while ($ligne = mysql_fetch_array($result)){
        echo "<div class=\"agenda\">";
        echo "<form class=\"pref\" name=\"fdx".$ligne["id"]."\" enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";

        echo ""."D&eacute;but"."";
        echo "<input class=\"pref\" id=\"dheurex".$ligne["id"]."\" type=\"text\" name=\"form_debut\" value=\"".date("H:i",strtotime($ligne["debut"]))."\">";
        $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=dheurex".$ligne["id"]."','surpop');loadobjs();\"";
        echo "<img src=\"".$_SESSION["ico"]["gris"]."\" id=\"image14\" ".$lien." style=\"margin-right:5px;\">";

        echo ""."Fin"."";
        echo "<input class=\"pref\" id=\"fheurex".$ligne["id"]."\" type=\"text\" name=\"form_fin\" value=\"".date("H:i",strtotime($ligne["fin"]))."\">";
        $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=fheurex".$ligne["id"]."','surpop');loadobjs();\"";
        echo "<img src=\"".$_SESSION["ico"]["gris"]."\" id=\"image14\" ".$lien." style=\"margin-right:5px;\">";

        echo "<input type=\"image\" src=\"".$_SESSION["ico"]["vert"]."\" id=\"image14\" title=\"Valider\" name=\"submit\" onClick=\"submit();\">";

        echo "<a style=\"margin-left:10px;\" href=\"".$_SESSION["lien"]."?table=preference&action=effaceligne&effaceligne=".$ligne["id"]."\" title=\"Supprimer !\n\nAttention !\nCette action est d&eacute;finitive !\"><img src=\"".$_SESSION["ico"]["rouge"]."\" id=\"image10\"></a>";

        echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
        echo "<input type=\"hidden\" name=\"table\" value=\"preference\">";

        echo "<input type=\"hidden\" name=\"form_jour\" value=\"".mktime(0, 0, 0, date("m",$_SESSION["jour"]), ((date("j",$_SESSION["jour"])- date("N",$_SESSION["jour"]))+$x), date("Y",$_SESSION["jour"]))."\">";
        echo "<input type=\"hidden\" name=\"form_id\" value=\"".$ligne["id"]."\">";
        echo "<input type=\"hidden\" name=\"form_nom\" value=\"".$ligne["nom"]."\">";
        echo "<input type=\"hidden\" name=\"form_pere\" value=\"".$_SESSION["userid"]."\">";
        echo "<input type=\"hidden\" name=\"form_type\" value=\"hf\">";

        echo "<input type=\"hidden\" name=\"page\" value=\"agenda\">";
        echo "<input type=\"hidden\" name=\"voir\" value=\"preference\">";
        echo "</form>";
        echo "</div>";
      }
    }

    echo "<form class=\"pref\" name=\"ff".jour_texte_num($x).$x."\" enctype=\"multipart/form-data\" method=\"post\" action=\"".$_SESSION["lien"]."\">\n";

    echo ""."D&eacute;but"."";
    echo "<input class=\"pref\" id=\"dheu".$x."\" type=\"text\" name=\"form_debut\" value=\"00:00\">";
    $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=dheu".$x."','surpop');loadobjs();\"";
    echo "<img src=\"".$_SESSION["ico"]["gris"]."\" id=\"image14\" ".$lien." style=\"margin-right:5px;\">";

    echo ""."Fin"."";
    echo "<input class=\"pref\" id=\"fheu".$x."\" type=\"text\" name=\"form_fin\" value=\"00:00\">";
    $lien = "title=\"Choix de l'heure\" onClick=\"javascript:voir('pop');ajaxpage(rootdomain+'scripts/inc.pop.heure.php?origine=fheu".$x."','surpop');loadobjs();\"";
    echo "<img src=\"".$_SESSION["ico"]["gris"]."\" id=\"image14\" ".$lien." style=\"margin-right:5px;\">";


    echo "<input type=\"image\" src=\"".$_SESSION["ico"]["vert"]."\" id=\"image14\" title=\"Valider\" name=\"submit\" onClick=\"submit();\">";

    echo "<input type=\"hidden\" name=\"action\" value=\"sauvedata\">";
    echo "<input type=\"hidden\" name=\"table\" value=\"preference\">";

    echo "<input type=\"hidden\" name=\"form_jour\" value=\"".mktime(0, 0, 0, date("m",$_SESSION["jour"]), ((date("j",$_SESSION["jour"])- date("N",$_SESSION["jour"]))+$x), date("Y",$_SESSION["jour"]))."\">";
    echo "<input type=\"hidden\" name=\"form_nom\" value=\"".strtolower(jour_texte_num($x))."\">";
    echo "<input type=\"hidden\" name=\"form_pere\" value=\"".$_SESSION["userid"]."\">";
    echo "<input type=\"hidden\" name=\"form_type\" value=\"hf\">";
    
    echo "<input type=\"hidden\" name=\"page\" value=\"agenda\">";
    echo "<input type=\"hidden\" name=\"voir\" value=\"preference\">";
    echo "</form>";
    
    echo "</div>";
  }
  

  //unset($liste);
}
?>