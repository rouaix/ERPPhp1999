<?php

if(!isset($_SESSION)){session_start();}

if(count($_GET)){
   while (list($key, $val) = each($_GET)){
      if($val!=""){$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');}else{unset($_SESSION[$key]);}
   }
}

if(count($_POST)){
   while (list($key, $val) = each($_POST)){
      if($val!=""){$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');}else{unset($_SESSION[$key]);}
   }
}

unset($_GET);
unset($_POST);


//echo $_SESSION["location"].$_SESSION["image"];

$lien = "onClick=\"javascript:voir('".$_SESSION["origine"]."');\"";
echo "<center><img src=\"".$_SESSION["location"].$_SESSION["image"]."\" ".$lien." style=\"cursor:pointer;\" title=\"Fermer\"></center>";


  
unset($_SESSION["image"]);
unset($_SESSION["origine"]);
?>