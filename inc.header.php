<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Site Rouaix</title>
<meta name="keywords" content="Assistant, Gestion, Stock, Facturation, Agenda, Rendez-vous, Rdv" />
<meta name="description" content="ROUAIX.COM" />
<meta name="Auteur" content="Daniel ROUAIX" />
<?php switch (@$_SESSION["web"]) {
  default :
    ?>
    <link rel="stylesheet" href="styles/style.css" type="text/css" media="screen" /> 
    <?php
    if(isset($_SESSION["page"])){
      //if (file_exists("styles/".$_SESSION["page"].".css")){echo "<link rel=\"stylesheet\" href=\"styles/".$_SESSION["page"].".css\" type=\"text/css\" media=\"screen\" />";}
    }       
  break;
  case "mobile":
    ?>
    <link rel="stylesheet" href="styles/style.mobile.css" type="text/css" />
    <?php
  break;  
} ?>
<link rel="SHORTCUT ICON" href="http://www.rouaix.com/favicon.ico">
<script type="text/javascript" src="scripts/java.js"></script>
<script type="text/javascript" src="scripts/jscolor/jscolor.js"></script>
<script type="text/javascript" src="scripts/flashobject.js"></script>
<?php 
$machine = getenv("HTTP_HOST");
if ($machine == "127.0.0.1" or $machine == "localhost"  or $machine == "192.168.1.3"){
?>
<script type="text/javascript" src="scripts/ajax.local.js"></script>
<?php } else {?>
<script type="text/javascript" src="scripts/ajax.js"></script>
<?php 
} 
?>