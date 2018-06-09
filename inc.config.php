<?php

//if (file_exists("securite.php")){include("securite.php");}
date_default_timezone_set('Europe/Paris');

if(!isset($_SESSION["alerte"])){$_SESSION["alerte"] = "";}

if(!isset($_SESSION["navigation"])){
  $_SESSION["navigation"] = array();
  array_push($_SESSION["navigation"], 'login');
}


if(file_exists("inc.fonction.php")){include("inc.fonction.php");}
if(file_exists("scripts/inc.fonction.php")){include("scripts/inc.fonction.php");}

if(!isset($_SESSION["page"])){$_SESSION["page"]="accueil";}else{if($_SESSION["page"]==""){$_SESSION["page"]="accueil";}}
if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
if(isset($_SESSION["voir"])){if($_SESSION["voir"]==""){$_SESSION["voir"]="default";}}else{$_SESSION["voir"]="default";}

//--------------------------------
  $_SESSION["web"] = "standard";
  connexionmysql();
  //  Chargement des préférences
  //    Web
  if(!isset($_SESSION["location"])){webmachine();}
  //    Couleurs
  //    Icones
  if(!isset($_SESSION["ico"]) or !is_array($_SESSION["ico"])){icones_liste();}        
  //  Chargement des droits
  //    Utilisateur
  //    Tables
  //    Modules
  if(!isset($_SESSION["modules"])){modules_droits();}
  //  Chargement
  //  Chargement
  //  Chargement
//--------------------------------
//unset($_SESSION["modules"]);

?>