<?php
if (file_exists("securite.php")){include("securite.php");}

if(utilisateur()){ 
  switch ($_SESSION["voir"]) {
  default :
    $sqla = "select * from groupe where type='200' and pere='".$_SESSION["userid"]."' and archive='' order by nom";   
    $resulta = mysql_query($sqla); 
    echo "<fieldset class=\"page\">";
    echo "<legend class=\"page\">Groupe".pluriel(mysql_num_rows($resulta))."</legend>";
    
    echo "<a title=\"Créer un nouveau groupe\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=nouveaugroupe','surpopup');loadobjs();\">";
    echo "<div class=\"menu\">Créer un nouveau groupe</div>";
    echo "</a>"; 

    $sqla = "select * from groupe where type='200' and pere='".$_SESSION["userid"]."' and archive='' order by nom";   
    $resulta = mysql_query($sqla);         
    while ($lignea = mysql_fetch_array($resulta)){      
      $sql = "select * from groupe where nom='".$lignea["id"]."' and type='201' and archive='Inscription'";   
      $result = mysql_query($sql);
      if(mysql_num_rows($result)>0){
        echo "<div id=\"marge\">Liste des demandes d'inscription à vos groupes</div>";
      }                
      while ($ligne = mysql_fetch_array($result)){                    
        $sqly = "select id,user,prenom,nom from user where id='".$ligne["lien_id"]."' and archive=''";   
        $resulty = mysql_query($sqly);   
        $ligney = mysql_fetch_array($resulty);      
        echo "<div id=\"cadre\">\n";
        echo "<p><b>";
        echo ico_refuser($ligne["id"],"groupe","12","2","0");
        echo ico_accepter($ligne["id"],$ligne["nom"],$ligne["lien_id"],"12","2","0");
        echo ucfirst($lignea["nom"]);
        echo "</b>";
        echo " [<i id=\"rouge\">".ucfirst($ligney["prenom"])." ".strtoupper($ligney["nom"])."</i>]";
        echo "</div>"; 
      }
    }
    
    $sql = "select * from groupe where type='200' and pere='".$_SESSION["userid"]."' and archive='' order by nom";   
    $result = mysql_query($sql);
    if(mysql_num_rows($result)>0){echo "<div id=\"marge\">Liste de vos groupes</div>";}      
    while ($ligne = mysql_fetch_array($result)){
      echo "<div id=\"cadre\">\n";
      echo "<p><b>";
      echo ico_modifier("modifiergroupe",$ligne["id"],"12","2","0");
      echo ico_inscription_groupe($ligne["id"],$_SESSION["userid"],"12","2","0");
      echo ico_effacer($ligne["id"],"groupe","12","2","0");
      echo ucfirst($ligne["nom"]);
      echo "</b>";
      if($ligne["contenu"]!=""){echo "<p style=\"padding:2px 2px 2px 18px\">".nl2br($ligne["contenu"]);}
      echo "</div>"; 
    }
    
    $sql = "select * from groupe where type='201' and lien_id='".$_SESSION["userid"]."' order by nom";   
    $result = mysql_query($sql);
    if(mysql_num_rows($result)>0){echo "<div id=\"marge\">Liste des groupes auxquels vous participez</div>";}      
    while ($ligne = mysql_fetch_array($result)){ 
      $sqlx = "select * from groupe where id ='".$ligne["nom"]."' and type='200' and archive='' order by nom";   
      $resultx = mysql_query($sqlx);   
      $lignex = mysql_fetch_array($resultx);
      
      echo "<div id=\"cadre\">\n";
      echo "<p><b>";
      echo ico_quitter($ligne,"groupe","12","2","0");
      echo ucfirst($lignex["nom"]);
      echo "</b>";
      if($ligne["archive"]!=""){
        if($ligne["archive"]=="Inscription"){
          echo "<p id=\"rouge\" style=\"margin-left:18px;\"><i>"."Demande d'inscription en attente de validation par l'administrateur du groupe !</i>";
        }      
      }else{
        if($lignex["contenu"]!=""){echo "<p style=\"padding:2px 2px 2px 18px\">".nl2br($lignex["contenu"]);}
      }
      echo "</div>"; 
    }
        
    $sql = "select * from groupe where pere !=".$_SESSION["userid"]." and type='200' and archive='' order by nom";   
    $result = mysql_query($sql);
    if(mysql_num_rows($result)>0){echo "<div id=\"marge\">Liste des groupes</div>";}      
    while ($ligne = mysql_fetch_array($result)){
      echo "<div id=\"cadre\">\n";
      echo "<p><b>";
      $sqlx = "select id from groupe where lien_id='".$_SESSION["userid"]."' and id='".$ligne["id"]."'";   
      $resultx = mysql_query($sqlx);
      if(mysql_num_rows($resultx)<1){
        echo ico_inscription_groupe($ligne["id"],$_SESSION["userid"],"12","2","0");
      }      
      echo ucfirst($ligne["nom"]);
      echo "</b>";
      if($ligne["contenu"]!=""){echo "<p style=\"padding:2px 2px 2px 18px\">".nl2br($ligne["contenu"]);}
      echo "</div>"; 
    }         
    echo "</fieldset>";
  break;
  case "a" :
    echo "<div id=\"cadre\">\n";  
    echo "</div>"."\n";
  break;  
  } 
}
?>