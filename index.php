<?php

if(!isset($_SESSION)){session_start();}
//if (file_exists("securite.php")){include("securite.php");}

if(file_exists("inc.config.php")){include("inc.config.php");}
if(file_exists("scripts/inc.config.php")){include("scripts/inc.config.php");}

//  Variables
variables_session();
if(!isset($_SESSION["alerte"])){$_SESSION["alerte"] = "";}

if(isset($_SESSION["navigation"]) && @count($_SESSION["navigation"]) > 2){
  if($_SESSION["navigation"][count($_SESSION["navigation"])-1] != $_SESSION["page"]){
    if(isset($_SESSION["rep"])){unset($_SESSION["rep"]);}
    if(isset($_SESSION["arbre"])){unset($_SESSION["arbre"]);}
    if(isset($_SESSION["type"]["mime"])){unset($_SESSION["type"]["mime"]);}
    if(isset($_SESSION["preferences"]["horaire"])){unset($_SESSION["preferences"]["horaire"]);}
  }
}

//  Modules
module_action($_SESSION["page"]);

//  Actions
if(file_exists("inc.action.php")){include("inc.action.php");}

//  ReDirection
echo "<script type=\"text/javascript\">\n";
echo "window.location = \"http://".getenv("HTTP_HOST")."/\"\n";
echo "</script>\n";

//@header('location:http://'.$_SESSION["machine"].'/');
//exit();

?>