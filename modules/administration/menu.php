<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

if(administrateur(@$_SESSION["userid"])){
  if(isset($_SESSION["modules"]["23"]) && is_array($_SESSION["modules"]["23"])){
    echo "<div class=\"module\" id=\"titre\">Espace Administration</div>\n";
    echo "<table class=\"icones\"><tr>\n";
    reset($_SESSION["modules"]["23"]);
    while(list($key, $val) = each($_SESSION["modules"]["23"])){
      $ok = false;
      if(is_string($key)){
        if(isset($_SESSION["modules"]["23"][$key])){
          echo "<td>";
          echo "<a href=\"".$_SESSION["lien"]."?page=".$key."\">";
          if(isset($_SESSION["modules"]["icone"][$key]) && $key != "accueil"){
            echo "<img title=\"\" src=\"".$_SESSION["modules"]["icone"][$key]."\" class=\"module\" id=\"i48\">";
          }
          echo "<br>";
        if(isset($_SESSION["modules"]["info"][$key]) && $_SESSION["modules"]["info"][$key]!=""){echo $_SESSION["modules"]["info"][$key];}
        elseif(isset($_SESSION["modules"]["nom"][$key]) && $_SESSION["modules"]["nom"][$key]!=""){echo ucfirst($_SESSION["modules"]["nom"][$key]);}
        else{echo ucfirst($key);}
          echo "</td>\n";
        }
      }
    }
    echo "</tr></table>\n";
  }
}
?>