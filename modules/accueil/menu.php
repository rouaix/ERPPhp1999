<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

if(@$_SESSION["page"] == ""){$_SESSION["page"] = "accueil";}

if(!utilisateur(@$_SESSION["userid"])){
  if(isset($_SESSION["modules"]["24"]) && is_array($_SESSION["modules"]["24"])){
    echo "<div class=\"module\" id=\"titre\">Espace Public</div>\n";
    echo "<table class=\"icones\"><tr>\n";    
    reset($_SESSION["modules"]["24"]);
    while(list($key, $val) = each($_SESSION["modules"]["24"])){
      $ok = false;
      if(is_string($key)){
        if(isset($_SESSION["modules"]["24"][$key])){
          echo "<td>";
          echo "<a href=\"".$_SESSION["lien"]."?page=".$key."\">";
          if(isset($_SESSION["modules"]["icone"][$key]) && $key != "accueil"){
            echo "<img title=\"\" src=\"".$_SESSION["modules"]["icone"][$key]."\" class=\"module\" id=\"i48\">";
            echo "<br>";
        if(isset($_SESSION["modules"]["info"][$key]) && $_SESSION["modules"]["info"][$key]!=""){echo $_SESSION["modules"]["info"][$key];}
        elseif(isset($_SESSION["modules"]["nom"][$key]) && $_SESSION["modules"]["nom"][$key]!=""){echo ucfirst($_SESSION["modules"]["nom"][$key]);}
        else{echo ucfirst($key);}
          }
          echo "</td>\n";
        }
      }
    }
    echo "</tr></table>\n";
  }  
}

if(utilisateur(@$_SESSION["userid"])){
  if(isset($_SESSION["modules"]["19"]) && is_array($_SESSION["modules"]["19"])){
    echo "<div class=\"module\" id=\"titre\">Espace Utilisateur</div>\n";
    echo "<table class=\"icones\"><tr>\n";    
    reset($_SESSION["modules"]["19"]);
    while(list($key, $val) = each($_SESSION["modules"]["19"])){
      $ok = false;
      if(is_string($key)){
        if(isset($_SESSION["modules"]["19"][$key])){
          echo "<td>";
          echo "<a href=\"".$_SESSION["lien"]."?page=".$key."\">";
          if(isset($_SESSION["modules"]["icone"][$key]) && $key != "accueil"){
            echo "<img title=\"\" src=\"".$_SESSION["modules"]["icone"][$key]."\" class=\"module\" id=\"i48\">";
            echo "<br>";
        if(isset($_SESSION["modules"]["info"][$key]) && $_SESSION["modules"]["info"][$key]!=""){echo $_SESSION["modules"]["info"][$key];}
        elseif(isset($_SESSION["modules"]["nom"][$key]) && $_SESSION["modules"]["nom"][$key]!=""){echo ucfirst($_SESSION["modules"]["nom"][$key]);}
        else{echo ucfirst($key);}
          }
          echo "</td>\n";
        }
      }
    }
    echo "</tr></table>\n";
  }  
}
?>


