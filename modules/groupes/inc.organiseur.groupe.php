<?php
if (file_exists("securite.php")){include("securite.php");}

if(utilisateur($_SESSION["userid"])){
  switch ($_SESSION["voir"]) {
  default :
    $sqla = "select * from groupe where type='groupe' and pere='".$_SESSION["userid"]."' and archive='' order by nom";
    $resulta = mysql_query($sqla); 
    echo "<h3>";
    echo "<a class=\"messagerie\" title=\"Nouveau Groupe\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=groupe&acte=formulaire&formulaire=nouveau','surpopup');\"><img src=\"".$_SESSION["ico"]["ajouter"]."\" id=\"image32\"></a>";
    echo "&nbsp;Groupe".pluriel(mysql_num_rows($resulta))."</h3>";

    $sqla = "select * from groupe where type='groupe' and pere='".$_SESSION["userid"]."' and archive='' order by nom";
    $resulta = mysql_query($sqla);         
    while ($lignea = mysql_fetch_array($resulta)){      
      $sql = "select * from groupe where lien='".$lignea["id"]."' and type='user' and archive='Inscription'";
      $result = mysql_query($sql);
      if(mysql_num_rows($result)>0){
        echo "<h4>Liste des demandes d'inscription à vos groupes</h4>";
      }                
      while ($ligne = mysql_fetch_array($result)){                    
        $sqly = "select id,user,prenom,nom from user where id='".$ligne["nom"]."' and archive=''";
        $resulty = mysql_query($sqly);   
        $ligney = mysql_fetch_array($resulty);      
        echo "<div id=\"cadre\">\n";
        echo "<p><b>";
        echo ico_refuser($ligne["id"],"groupe","12","2","0");
        echo ico_accepter($ligne["id"],$ligne["lien"],$ligne["nom"],"12","2","0");
        echo "&nbsp;".ucfirst($lignea["nom"]);
        echo "</b>";
        echo " [<i id=\"rouge\">".ucfirst($ligney["prenom"])." ".strtoupper($ligney["nom"])."</i>]";
        echo "</div>"; 
      }
    }
    
    $sql = "select * from groupe where type='groupe' and pere='".$_SESSION["userid"]."' and archive='' order by nom";
    $result = mysql_query($sql);
    if(mysql_num_rows($result)>0){echo "<h4>Liste de vos groupes</h4>";}
    while ($ligne = mysql_fetch_array($result)){
      echo "<div id=\"cadre\">\n";
      echo "<p><b>";
      echo ico_modifier("modifiergroupe",$ligne["id"],"12","2","0");
      $sqlx = "select * from groupe where nom =".$_SESSION["userid"]." and type='user' and lien='".$ligne["id"]."' and archive='' order by nom";
      $resultx = mysql_query($sqlx);
      if(mysql_num_rows($resultx)<1){
        echo ico_inscription_groupe($ligne["id"],$_SESSION["userid"],"12","2","0");
      }
      echo ico_effacer($ligne["id"],"groupe","12","2","0");
      echo "&nbsp;".ucfirst($ligne["nom"]);
      echo "</b>";
      if($ligne["contenu"]!=""){echo "<p style=\"padding:2px 2px 2px 18px\">".nl2br($ligne["contenu"]);}
      echo "</div>"; 
    }
    
    $sql = "select * from groupe where type='user' and nom='".$_SESSION["userid"]."' order by id DESC";
    $result = mysql_query($sql);
    if(mysql_num_rows($result)>0){echo "<h4>Liste des groupes auxquels vous participez</h4>";}
    while ($ligne = mysql_fetch_array($result)){ 
      $sqlx = "select * from groupe where id='".$ligne["lien"]."' and type='groupe' and archive='' order by nom ASC";
      $resultx = mysql_query($sqlx);   
      $lignex = mysql_fetch_array($resultx);
      
      echo "<div id=\"cadre\">\n";
      echo "<p><b>";
      echo ico_quitter($ligne,"groupe","12","2","0");
      echo "&nbsp;".ucfirst($lignex["nom"]);
      echo "</b>";
      if($ligne["archive"]!=""){
        if($ligne["archive"]=="Inscription"){
          echo "&nbsp;<i>("."Demande d'inscription en attente de validation par l'administrateur du groupe !)</i>";
        }      
      }else{
        if($lignex["contenu"]!=""){echo "<p style=\"padding:2px 2px 2px 18px\">".nl2br($lignex["contenu"]);}
      }
      echo "</div>"; 
    }
        
    $sql = "select * from groupe where pere !=".$_SESSION["userid"]." and type='groupe' and archive='' order by nom";
    $result = mysql_query($sql);
    if(mysql_num_rows($result)>0){echo "<h4>Liste des groupes</h4>";}
    while ($ligne = mysql_fetch_array($result)){
      echo "<div id=\"cadre\">\n";
      echo "<p><b>";
      $sqlx = "select * from groupe where nom =".$_SESSION["userid"]." and type='user' and lien='".$ligne["id"]."' and archive='' order by nom";
      $resultx = mysql_query($sqlx);
      if(mysql_num_rows($resultx)<1){
        echo ico_inscription_groupe($ligne["id"],$_SESSION["userid"],"12","2","0");
      }      
      echo "&nbsp;".ucfirst($ligne["nom"]);
      echo "</b>";
      if($ligne["contenu"]!=""){echo "<p style=\"padding:2px 2px 2px 18px\">".nl2br($ligne["contenu"]);}
      echo "</div>"; 
    }         
  break;
  case "a" :
    echo "<div id=\"cadre\">\n";  
    echo "</div>"."\n";
  break;  
  } 
}
?>