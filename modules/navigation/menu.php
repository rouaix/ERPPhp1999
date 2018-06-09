<?php
//if(file_exists("../../securite.php")){include("../../securite.php");}
  
  echo "<ul class=\"site\" id=\"m\">";
  
  reset($_SESSION["modules"]["24"]);

  while(list($key, $val) = each($_SESSION["modules"]["24"])){
    $ok = false;
    if(is_string($key)){       
      if(!utilisateur(@$_SESSION["userid"])){
        if(isset($_SESSION["modules"]["24"][$key])){$ok = true;}
      }
      if($ok){
        echo "<li><a href=\"".$_SESSION["lien"]."?page=".$key."\"";
        if($_SESSION["page"] == $key){echo " class=\"site\" id=\"ma\"";}
        echo ">";
        if(isset($_SESSION["modules"]["icone"][$key]) && $key == "accueil"){
          echo "<img title=\"Accueil\" src=\"".$_SESSION["modules"]["icone"][$key]."\" class=\"site\" id=\"m\">";
        }
        if(isset($_SESSION["modules"]["info"][$key]) && $_SESSION["modules"]["info"][$key]!=""){echo $_SESSION["modules"]["info"][$key];}
        elseif(isset($_SESSION["modules"]["nom"][$key]) && $_SESSION["modules"]["nom"][$key]!=""){echo ucfirst($_SESSION["modules"]["nom"][$key]);}
        else{echo ucfirst($key);}
        echo "</a></li>\n";
      }
    }
  }
      
  while(list($key, $val) = each($_SESSION["modules"]["19"])){
    $ok = false;
    if(is_string($key)){       
      if(utilisateur(@$_SESSION["userid"])){
        if(isset($_SESSION["modules"]["19"][$key])){$ok = true;}
      }  
      if($ok){
        echo "<li><a href=\"".$_SESSION["lien"]."?page=".$key."\"";
        if($_SESSION["page"] == $key){echo " class=\"site\" id=\"ma\"";}
        echo ">";
        if(isset($_SESSION["modules"]["icone"][$key]) && $key == "accueil"){
          echo "<img title=\"Accueil\" src=\"".$_SESSION["modules"]["icone"][$key]."\" class=\"site\" id=\"m\">";
        }
        if(isset($_SESSION["modules"]["info"][$key]) && $_SESSION["modules"]["info"][$key]!=""){echo $_SESSION["modules"]["info"][$key];}
        elseif(isset($_SESSION["modules"]["nom"][$key]) && $_SESSION["modules"]["nom"][$key]!=""){echo ucfirst($_SESSION["modules"]["nom"][$key]);}
        else{echo ucfirst($key);}
        echo "</a>";
        echo "</li>\n";
      }
    }
  }
  
  echo "</ul>";


if(isset($_SESSION["modules"]["23"]) && is_array($_SESSION["modules"]["23"])){
  reset($_SESSION["modules"]["23"]);
  echo "<ul class=\"site\" id=\"m\" style=\"text-align:right;padding-right:5px;\">";
  while(list($key, $val) = each($_SESSION["modules"]["23"])){
    $ok = false;
    if(is_string($key)){
      if(isset($_SESSION["modules"]["23"][$key])){
        if(administrateur(@$_SESSION["userid"])){$ok = true;}
      }
      if($ok){
        echo "<li><a href=\"".$_SESSION["lien"]."?page=".$key."\"";
        if($_SESSION["page"] == $key){echo " class=\"site\" id=\"ma\"";}
        echo ">";
        if(isset($_SESSION["modules"]["info"][$key]) && $_SESSION["modules"]["info"][$key]!=""){echo $_SESSION["modules"]["info"][$key];}
        elseif(isset($_SESSION["modules"]["nom"][$key]) && $_SESSION["modules"]["nom"][$key]!=""){echo ucfirst($_SESSION["modules"]["nom"][$key]);}
        else{echo ucfirst($key);}
        echo "</a></li>\n";
      }
    }
  }
  echo "</ul>";
}
?>