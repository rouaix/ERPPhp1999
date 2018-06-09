<?php
if (file_exists("securite.php")){include("securite.php");}

if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
if(isset($_SESSION["voir"])){if($_SESSION["voir"]==""){$_SESSION["voir"]="default";}}else{$_SESSION["voir"]="default";}
    
switch ($_SESSION["voir"]) {
  default :
    $sql = "select * from messagerie where type='message' and archive ='' and destinataire='".$_SESSION["userid"]."' order by id desc";
    $result = mysql_query($sql);  
    echo "<h3>";
    echo "<a class=\"messagerie\" title=\"Envoyer un message\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=messagerie&acte=formulaire&formulaire=nouveau','surpopup');\"><img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"image32\"></a>";
    echo "&nbsp;Messagerie interne</h3>\n";
    //if(mysql_num_rows($result)>0){
    echo "<div class=\"messagerie\"><h4>Message".pluriel(mysql_num_rows($result))." reçu".pluriel(mysql_num_rows($result))."</h4></div>\n";
    //}
    while ($ligne = mysql_fetch_array($result)){            
      echo "<div class=\"messagerie\" id=\"message\" ".categorie($ligne,"t").">";
      echo ico_archiver($ligne,"messagerie",0,0,0);
      echo "&nbsp;";
      //echo "<a class=\"messagerie\" title=\"Répondre\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=reponsemessage&reponse=".$ligne["pere"]."','surpopup');\"><img src=\"images/jpg/fd.jpg\" id=\"image14\"></a>";
      echo "<a class=\"messagerie\" title=\"Répondre\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=messagerie&acte=formulaire&formulaire=repondre&repondre=".$ligne["pere"]."','surpopup');\"><img src=\"".$_SESSION["ico"]["droite"]."\" id=\"image14\"></a>";
      echo "&nbsp;";
      echo "<b>".$ligne["nom"]."</b>";
      echo "<p class=\"messagerie\" id=\"message\">".nl2br($ligne["contenu"]);
      echo "<p class=\"messagerie\" id=\"droite\">";
      $lignex = cherche_user_message($ligne["pere"]);
      echo ucfirst($lignex["prenom"])." ".strtoupper($lignex["nom"])."&nbsp;"; 
      echo "[<i class=\"messagerie\">".$ligne["horloge"]."</i>]";
      echo "</div>\n";
      unset($lignex);
    }
           
    $sql = "select * from messagerie where type='message' and destinataire='".$_SESSION["userid"]."' and archive !='' order by id DESC";
    $result = mysql_query($sql);
    //if(mysql_num_rows($result)>0){
    echo "<div class=\"messagerie\">";
    echo "<a class=\"messagerie\" title=\"Afficher\" href=\"javascript:voir('archives');\">".ico_voir($ligne["id"],0,0,0)."</a>";
    echo "&nbsp;Message".pluriel(mysql_num_rows($result))." archiv&eacute;".pluriel(mysql_num_rows($result))."</div>\n";
    //}
    echo "<div id=\"archives\" style=\"display:none;\">\n";
    while ($ligne = mysql_fetch_array($result)){
      echo "<div class=\"messagerie\" id=\"archive\">";
      echo ico_voir($ligne["id"],0,0,0);
      echo "&nbsp;";
      echo ico_restaurer($ligne,"messagerie","0","0","0");
      echo "&nbsp;";
      //echo "<a class=\"messagerie\" title=\"Répondre\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=reponsemessage&reponse=".$ligne["pere"]."','surpopup');\"><img src=\"images/jpg/fd.jpg\" id=\"image14\"></a>";
      echo "<a class=\"messagerie\" title=\"Répondre\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=messagerie&acte=formulaire&formulaire=repondre&repondre=".$ligne["pere"]."','surpopup');\"><img src=\"".$_SESSION["ico"]["droite"]."\" id=\"image14\"></a>";
      echo "&nbsp;";
      echo ico_supprimer($ligne,"messagerie","0","0","0");
      echo "&nbsp;";
      echo "<b>".$ligne["nom"]."</b>";
      echo "<div id=\"".$ligne["id"]."\" style=\"display:none;\">";
      echo "<p class=\"messagerie\" id=\"message\">".nl2br($ligne["contenu"]);
      echo "<p class=\"messagerie\" id=\"droite\">";
      $lignex = cherche_user_message($ligne["pere"]);
      echo ucfirst($lignex["prenom"])." ".strtoupper($lignex["nom"])."&nbsp;";
      echo "[<i class=\"messagerie\">".$ligne["horloge"]."</i>]";
      echo "</div>\n";
      echo "</div>\n";
    }       
    echo "</div>\n";


    $sql = "select * from messagerie where type='message_e' and pere='".$_SESSION["userid"]."' order by id DESC";
    $result = mysql_query($sql);
    //if(mysql_num_rows($result)>0){
    echo "<div class=\"messagerie\">";
    echo ico_voir("envois",0,0,0);
    echo "&nbsp;Message".pluriel(mysql_num_rows($result))." envoy&eacute;".pluriel(mysql_num_rows($result))."</div>\n";
    //}
    echo "<div id=\"envois\" style=\"display:none;\">";
    while ($ligne = mysql_fetch_array($result)){
      echo "<div class=\"messagerie\" id=\"archive\">";
      echo ico_voir($ligne["id"],0,0,0);
      echo "&nbsp;";
      echo ico_supprimer($ligne,"messagerie","0","0","0");
      echo "&nbsp;";
      echo "<b>".$ligne["nom"]."</b>";
      echo "<div id=\"".$ligne["id"]."\" style=\"display:none;\">";
      
      $lignex = cherche_user_message($ligne["destinataire"]);
      echo ucfirst($lignex["prenom"])." ".strtoupper($lignex["nom"])."&nbsp;";
      echo "<p class=\"messagerie\" id=\"message\">".nl2br($ligne["contenu"]);
      echo "<p class=\"messagerie\" id=\"droite\">";
      $lignex = cherche_user_message($ligne["pere"]);
      echo ucfirst($lignex["prenom"])." ".strtoupper($lignex["nom"])."&nbsp;";
      echo "[<i class=\"messagerie\">".$ligne["horloge"]."</i>]";
      echo "</div>\n";
      echo "</div>\n";
    }
    echo "</div>\n";
  break;

  case "c" :
    if(file_exists("../scripts/page.erreur.php")){include("../scripts/page.erreur.php");}
  break; 
}

function cherche_message(){
  if(file_exists("scripts/inc.sql.php")){include("scripts/inc.sql.php");}
  $sql = "select * from messagerie where type='message' and archive=''";
  $result = mysql_query($sql);
  if($result){
    while ($ligne = mysql_fetch_array($result)){$liste[$ligne["id"]] = $ligne;}
  }
  unset($ligne);
  mysql_free_result($result);
  return @$liste;
}

?>