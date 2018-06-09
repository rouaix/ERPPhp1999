<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("securite.php")){include("securite.php");}

charge("inc.logo","logo","logo","a");
//charge("inc.logo","droite","logo","b");
charge("inc.login","l","login","");
chargement("inc.menu.haut","menuhautmapage");

if (isset($_SESSION["alerte"])){
  if($_SESSION["alerte"]!=""){echo "\n<div id=\"alerte\"><h2 id=\"centre\">Message d'information</h2><hr>".$_SESSION["alerte"]."</div>\n"; }
  unset($_SESSION["alerte"]);
}
switch ($_SESSION["page"]) {
  default :
    chargement("inc.".$_SESSION["page"],"mapage"); 
  break;
  case "carte":
    if (file_exists("scripts/inc.".$_SESSION["page"].".php")){include("scripts/inc.".$_SESSION["page"].".php");} 
  break; 
  case "preference":
    if (file_exists("scripts/inc.preference.agenda.php")){include("scripts/inc.preference.agenda.php");}
    if (file_exists("scripts/inc.preference.categorie.php")){include("scripts/inc.preference.categorie.php");}
  break;  
  case "accueil":    
    echo "<div id=\"centre\" class=\"page\">";   
    echo "<img src=\"images/png/borne.png\" title=\"Site en construction\" height=\"128px\" border=\"0\" vspace=\"10\" hspace=\"2\">";
    echo "<br>Site en cours de développement";
    echo "</div>\n";       
  break; 
  case "admin":
    if (administrateur()){   
      echo "<fieldset class=\"page\">\n";
      echo "<legend class=\"page\">Gestion des tables</legend>\n";           
      if(file_exists("scripts/inc.admin.func.php")){include("scripts/inc.admin.func.php");}
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

?>
<center><a href="mailto:webmaster@rouaix.com" title="Ecrire au concepteur" class="signe">&copy; 1999-2011 ROUAIX.COM</a></center>
<?php charge("inc.logo","sico","signe","b"); ?>