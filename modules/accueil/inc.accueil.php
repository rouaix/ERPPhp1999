<?php
//if (file_exists("securite.php")){include("securite.php");}
if(!isset($_SESSION["inc"]) or @$_SESSION["inc"]==""){$_SESSION["inc"]="information";}
if (file_exists("scripts/inc.".$_SESSION["page"].".".$_SESSION["inc"].".php")){include("scripts/inc.".$_SESSION["page"].".".$_SESSION["inc"].".php");}
?>