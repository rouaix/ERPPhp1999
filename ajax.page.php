<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("securite.php")){include("securite.php");}
if(file_exists("inc.config.php")){include("inc.config.php");}

if(!isset($_SESSION["page"])){$_SESSION["page"]="accueil";}else{if($_SESSION["page"]==""){$_SESSION["page"]="accueil";}}
if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
if(isset($_SESSION["voir"])){if($_SESSION["voir"]==""){$_SESSION["voir"]="default";}}else{$_SESSION["voir"]="default";}
?>

<table class="page" cellpadding="0" cellspacing="0" border="0" align="left" valign="middle" style="width:100%;height:100%;">
<tr>
<td class="logo"><a href="<?php 
echo $_SESSION["location"];
?>scripts/index.php?page=accueil" title="Site en cours de développement"><img src="images/logo/logo10.png" border="0" class="logo"></a></td>
<td class="logo" align="right">
<i>Version Bêta</i>
<img onclick="voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=afficherradio','surpopup');loadobjs();" src="images/png/casque.png" title="Ecouter la radio" class="logo" id="menu">
<img src="images/png/mobile.png" class="logo" id="menu" title="Version mobile (En construction)">
</td>
</tr>
<tr>
<td colspan="2" align="left" valign="top" height="100%">
<div class="login"><?php login(); ?></div>
<div id="centre" style="display:block;margin-bottom:10px;">
<?php if(file_exists("inc.menu.haut.php")){include("inc.menu.haut.php");} ?>
</div>
<?php 
if (isset($_SESSION["alerte"])){
  if($_SESSION["alerte"]!=""){echo "\n<div id=\"alerte\"><h2 id=\"centre\">Message d'information</h2><hr>".$_SESSION["alerte"]."</div>\n"; }
  unset($_SESSION["alerte"]);
}
echo "\n<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">\n";
echo "<tr>\n";
echo "<td valign=\"top\" align=\"left\">";

switch ($_SESSION["page"]) {
  default :
    chargement(); 
  break;
  case "carte":
    if (file_exists("inc.".$_SESSION["page"].".php")){include("inc.".$_SESSION["page"].".php");} 
  break;   
  case "accueil":    
    if (utilisateur()){
    echo "\n<fieldset class=\"page\">\n";
    echo "<legend class=\"page\">Site en cours de développement</legend>\n";
    ?>
    <table class="page" cellpadding="0" cellspacing="0" border="0" align="left" valign="middle" style="width:100%;height:100%;">
    <tr>
    <td width="40%" align="center" valign="middle"><img src="images/png/borne.png" height="128px" title="Site en construction" border="0" vspace="10" hspace="2"></td>    
    <td width="30%" align="center" valign="bottom"><fieldset class="page"><legend class="page">Modules de Gestion</legend><div class="menus">Business plan</div><div class="menus">Gestion de projet</div><div class="menus">Gestion de temps</div><div class="menus">Gestion de Stock</div><div class="menus">Facturation</div></fieldset></td>
    <td width="30%" align="center" valign="bottom"><fieldset class="page"><legend class="page">Fonctions</legend><div class="menus">Agenda</div><div class="menus">Planning</div><div class="menus">Taches</div><div class="menus">Aide mémoire</div><div class="menus">Messages</div><div class="menus">Groupes</div></fieldset></td>
    </tr>
    </table>
    <?php
    echo "</fieldset>\n"; 
    }else{
      echo "<center><img src=\"images/png/borne.png\" title=\"Site en construction\" height=\"128px\" border=\"0\" vspace=\"10\" hspace=\"2\"></center>";
    }
    echo "<fieldset class=\"page\">\n";
    echo "<legend class=\"page\">Actualité (Flux Rss Google)</legend>\n";
    echo "<div class=\"rss\" id=\"fluxx\">\n";
    echo "</div>\n";
    echo "<script language=\"Javascript\">ajaxpage(rootdomain+'inc.rss.php','fluxx');</script>\n"; 
    echo "</fieldset>\n";       
  break;
  case "user":
    switch (@$_SESSION["inc"]) {
      default :
        if(utilisateur()){
          if(isset($_SESSION["inc"])){  
            if (file_exists("inc.".$_SESSION["page"].".".$_SESSION["inc"].".php")){include("inc.".$_SESSION["page"].".".$_SESSION["inc"].".php");}        
          }
        }
      break;  
      case "inscription":
        if (file_exists("scripts/inc.".$_SESSION["page"].".".$_SESSION["inc"].".php")){include("inc.user.".$_SESSION["inc"].".php");} 
      break; 
      case "secour":
        if (file_exists("inc.".$_SESSION["page"].".".$_SESSION["inc"].".php")){include("inc.user.".$_SESSION["inc"].".php");}  
      break;
    }    
  break;
  case "agenda":
    if(isset($_SESSION["voir"])){if($_SESSION["voir"]==""){$_SESSION["voir"]="jour";}}else{$_SESSION["voir"]="jour";}
    chargement();
  break;
  case "message":
    if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
    if(isset($_SESSION["voir"])){if($_SESSION["voir"]==""){$_SESSION["voir"]="default";}}else{$_SESSION["voir"]="default";}
    chargement();
  break;
  case "preference":    
    if (file_exists("inc.preference.agenda.php")){include("inc.preference.agenda.php");}
    if (file_exists("inc.preference.categorie.php")){include("inc.preference.categorie.php");}
  break;
  case "admin":
    if (administrateur()){   
      echo "<fieldset class=\"page\">\n";
      echo "<legend class=\"page\">Gestion des tables</legend>\n";           
      if(file_exists("inc.admin.func.php")){include("inc.admin.func.php");}
      echo "</fieldset>\n";
           
      echo "<fieldset class=\"page\">\n";
      echo "<legend class=\"page\">Session</legend>\n";      
      while (list($key, $val) = each($_SESSION)){
        if(!is_array($_SESSION[$key])){
          echo "<div class=\"menus\">".$key." = ".$val."</div>\n";
        }else{
          echo "<div class=\"menus\">".$key." = ";          
          reset($_SESSION[$key]);
          while (list(, $value) = each($_SESSION[$key])) {
            echo "[".$value."] ";
          }
          echo "</div>\n";
        }        
      }
      echo "</fieldset>\n";
            
      echo "<fieldset class=\"page\">\n";
      echo "<legend class=\"page\">Php Infos</legend>\n";      
      echo "<a title=\"Afficher les infos Php\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=phpinfo','surpopup');\"><img src=\"images/jpg/question.jpg\" style=\"height:24px;vertical-align:middle;\" border=\"0\" hspace=\"0\"></a>";
      echo "<a href=\"".$_SESSION["lien"]."?action=testemail\"><img height=\"24px\" hspace=\"5\" border=\"0\" src=\"../images/jpg/dialogue.jpg\" style=\"cursor:pointer\" title=\"Test Email\"></a>\n";       
      echo "</fieldset>\n";                                                      
    }else{
      echo "<fieldset class=\"page\">\n";
      echo "<legend class=\"page\">Information</legend>\n";
      echo "<h2>";
      echo "Vous n'avez pas d'autorisation !";
      echo "</h2>\n";
      echo "</fieldset>\n";
    }
    unset($_SESSION["montre"]);
  break;    
}
echo "</td>\n";
if(utilisateur()){
  $exclusion_page = array("","test");  
  if(!in_array ($_SESSION["page"], $exclusion_page)){
    echo "<td valign=\"top\" align=\"left\" id=\"borddroit\">";
    if(file_exists("inc.menu.droit.php")){include("inc.menu.droit.php");}   
    echo "</td>\n"; 
  }
}
echo "</tr></table>\n";
?>
</td>
</tr>
<tr>
<td colspan="2" class="signe">&copy; 1999-2011 ROUAIX.COM <a href="mailto:webmaster@rouaix.com" title="Ecrire au concepteur"><img src="images/jpg/dialogue.jpg" border="0" class="signe"></a></td>
</tr>
</table>