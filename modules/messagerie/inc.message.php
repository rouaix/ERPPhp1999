<?php
@session_start(); 
if (file_exists("securite.php")){include("securite.php");}

if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
if(isset($_SESSION["voir"])){if($_SESSION["voir"]==""){$_SESSION["voir"]="default";}}else{$_SESSION["voir"]="default";}
    
switch ($_SESSION["voir"]) {
  default :
    $sql = "select * from z".$_SESSION["userid"]." where type='400' and archive ='' order by id desc";
    $result = mysql_query($sql);  
     
    echo "<h3>Message".pluriel(mysql_num_rows($result))."</h3>";    

    $sql = "select * from z".$_SESSION["userid"]." where type='400' and archive ='' order by id desc";
    $result = mysql_query($sql);       
    if(mysql_num_rows($result)>0){echo "<div id=\"marge\">Message".pluriel(mysql_num_rows($result))." reçu".pluriel(mysql_num_rows($result))."</div>";}  
       
    while ($ligne = mysql_fetch_array($result)){            
      echo "<div ".style_categorie($ligne).">";            
      //echo ico_voir("div".$ligne["id"],"14","2","2");
      echo ico_archiver($ligne,"z".$_SESSION["userid"],"14","2","2");      
      echo "<a title=\"Répondre\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=reponsemessage&modifier=".$ligne["pere"]."','surpopup');\"><img src=\"images/jpg/fd.jpg\" style=\"height:14px;vertical-align:middle\" border=\"0\" hspace=\"2\" vspace=\"2\"></a>";           
      echo $ligne["nom"];      
      //echo "<div id=\"div".$ligne["id"]."\" style=\"display:none\">";      
      echo "<p id=\"juste\" style=\"padding:2px 2px 2px 20px\">";
      echo nl2br($ligne["contenu"]);      
      echo "<p id=\"droite\" style=\"font-size:10px;\">";      
      $lignex = cherche_user_message($ligne["pere"]);
      echo ucfirst($lignex["prenom"])." ".strtoupper($lignex["nom"])."&nbsp;"; 
      echo "[<i>".$ligne["horloge"]."</i>]";                 
      //echo "</div>";
      echo "</div>";
      unset($lignex);
    }       
    
    
    //if(!isset($_SESSION["categorie"])){cherche_categorie();}   
    $sql = "select * from z".$_SESSION["userid"]." where type='400' and archive !='' order by id";
    $result = mysql_query($sql);
    
    if(mysql_num_rows($result)>0){echo "<div id=\"marge\">Message".pluriel(mysql_num_rows($result))." archivé".pluriel(mysql_num_rows($result))."</div>";}
    
     
    while ($ligne = mysql_fetch_array($result)){
      echo "<div ".style_categorie($ligne).">";  
      //echo "<div id=\"\">";            
      echo "<p><b>";
      echo ico_voir("div".$ligne["id"],"14","2","2"); 
      echo ico_restaurer($ligne,"z".$_SESSION["userid"],"14","0","0");      
      echo "<a title=\"Répondre\" href=\"javascript:voir('leformulaire');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=reponsemessage&modifier=".$ligne["pere"]."','leformulaire');\"><img src=\"images/jpg/fd.jpg\" style=\"height:14px;vertical-align:middle\" border=\"0\" hspace=\"2\" vspace=\"2\"></a>";                
      echo ico_supprimer($ligne,"z".$_SESSION["userid"],"12","20","0");
      //echo $ligne["message"];
      echo limite_texte($ligne["nom"],"60");
      //if(strlen($ligne["message"])>60){echo substr($ligne["message"],0,60)." ...";}else{echo $ligne["message"];}
      echo "</b>";
      
      echo "<div id=\"div".$ligne["id"]."\" style=\"display:none\">";
      echo "<p id=\"juste\" style=\"padding:2px 2px 2px 20px\">";
      if($ligne["contenu"]!=""){echo nl2br($ligne["contenu"]);}
      echo "<p id=\"droite\" style=\"font-size:10px;\">";                 
      $lignex = cherche_user_message($ligne["pere"]);
      echo ucfirst($lignex["prenom"])." ".strtoupper($lignex["nom"])."&nbsp;"; 
      echo "&nbsp;"."[<i>".$ligne["horloge"]."</i>]";
      //echo ico_supprimer($ligne,"message","12","0","0");      
      
      //echo "</div>";      
      echo "</div>";
      echo "</div>";
      unset($lignex);
    }       
    
    
    echo "</div>"."\n";
    //unset($_SESSION["categorie"]);   
  break;

  case "c" :
    if(file_exists("../scripts/page.erreur.php")){include("../scripts/page.erreur.php");}
  break; 
}

function cherche_message(){
  if(file_exists("scripts/inc.sql.php")){include("scripts/inc.sql.php");}
  $sql = "select * from z.".$_SESSION["userid"]." where type='400' and archive=''";
  $result = mysql_query($sql);
  if($result){
    while ($ligne = mysql_fetch_array($result)){$liste[$ligne["id"]] = $ligne;}
  }
  unset($ligne);
  mysql_free_result($result);
  return @$liste;
}

?>