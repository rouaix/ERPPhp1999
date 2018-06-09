<?php
//if (file_exists("securite.php")){include("securite.php");}

if(isset($_SESSION["action"]))
{
switch ($_SESSION["action"]) {
  default :
     unset($_SESSION["action"]);
  break;

  case "copier":
    if(isset($_SESSION["copier"]) && isset($_SESSION["fichier"])  && isset($_SESSION["dir"])){
    if(administrateur($_SESSION["userid"]) && $_SESSION["page"] == "fichiers"){
      $racine = '';
    }else{
      $racine = 'fichiers/users/'.$_SESSION["userid"].'/';
    }
    if($_SESSION["copier"] == "/"){$_SESSION["copier"]="";}
      $_SESSION["dir"] = '../'.$_SESSION["dir"];
      $_SESSION["copier"] = '../'.$racine.$_SESSION["copier"];

      copier($_SESSION["dir"].$_SESSION["fichier"],$_SESSION["copier"].$_SESSION["fichier"]);
             
      unset($_SESSION["fichier"]);
      unset($_SESSION["dir"]);
      unset($_SESSION["copier"]);      
    }
    unset($_SESSION["action"]);
  break;
    
  case "deplacer":
    if(isset($_SESSION["deplacer"]) && isset($_SESSION["fichier"])  && isset($_SESSION["dir"])){
    if(administrateur($_SESSION["userid"]) && $_SESSION["page"] == "fichiers"){
      $racine = '';
    }else{
      $racine = 'fichiers/users/'.$_SESSION["userid"].'/';
    }
    if($_SESSION["deplacer"] == "/"){$_SESSION["deplacer"]="";}
      $_SESSION["dir"] = '../'.$_SESSION["dir"];
      $_SESSION["deplacer"] = '../'.$racine.$_SESSION["deplacer"];

      renommer($_SESSION["dir"].$_SESSION["fichier"],$_SESSION["deplacer"].$_SESSION["fichier"]);
             
      unset($_SESSION["fichier"]);
      unset($_SESSION["dir"]);
      unset($_SESSION["deplacer"]);      
    }
    unset($_SESSION["action"]);
  break;
  
  case "renommer":
    if(isset($_SESSION["renommer"]) && isset($_SESSION["fichier"])  && isset($_SESSION["dir"])){
      $_SESSION["renommer"] = filtre_nom_fichier($_SESSION["renommer"]);
      $_SESSION["dir"] = '../'.$_SESSION["dir"];
           
      if(is_dir($_SESSION["dir"].$_SESSION["fichier"])){
        renommer($_SESSION["dir"].$_SESSION["fichier"],$_SESSION["dir"].$_SESSION["renommer"]);
      }else{
        $nom = substr_replace($_SESSION["fichier"],'',strlen(pathinfo($_SESSION["dir"].$_SESSION["fichier"], PATHINFO_FILENAME)));  
        $ext = explode('.',$_SESSION["fichier"]);
        $ext = $ext[count($ext)-1];          
        $x = $_SESSION["dir"].$_SESSION["renommer"].'.'.$ext;       
        renommer($_SESSION["dir"].$_SESSION["fichier"],$x);
      }          
      unset($_SESSION["fichier"]);
      unset($_SESSION["dir"]);
      unset($_SESSION["renommer"]);       
    }
    unset($_SESSION["action"]);
  break;
  
  case "creationmodule":
    if(!isset($_SESSION["creationmodule"])){
      $_SESSION["creationmodule"]="Bug";
    }else{
      module_creation($_SESSION["creationmodule"]);
    }
    unset($_SESSION["creationmodule"]);
    unset($_SESSION["action"]);
  break;
  
  case "supprimermodule":
    if(isset($_SESSION["supprimermodule"])){module_supprimer();}
    unset($_SESSION["supprimermodule"]);
    unset($_SESSION["supprimermoduleid"]);
    unset($_SESSION["action"]);
  break;

  case "erreur":
    if(!isset($_SESSION["erreur"])){$_SESSION["erreur"]="Bug";}   
    //module("erreurs","fonction");
    erreurs();
    unset($_SESSION["erreur"]);
    unset($_SESSION["action"]);
  break;
  
  case "login":
    login();
  break;

  case "logout" :
    $sqly = "delete from hit where id_user='".$_SESSION["userid"]."' && session_hit='".session_id()."'";
    $resulty = mysql_query($sqly);
    $r = mysql_query("INSERT INTO `hit` (`id_hit`,`id_user`,`nom_hit`,`horloge_hit`,`session_hit`) VALUES ('','".$_SESSION["userid"]."','Logout','".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))."','');");
    while (list($key, $val) = each($_SESSION)){unset($_SESSION[$key]);}
    @session_destroy();
    $temp = "location:http://".getenv("HTTP_HOST")."/?scripts/index.php";
    @header($temp);
    exit();
  break;

  case "usersecour" :  
    if(isset($_SESSION["form_login_user"])){
      $sql = "select * from user where login_user='".$_SESSION["form_login_user"]."'";
    }else{
      if(isset($_SESSION["form_email_user"])){
        $sql = "select * from user where email_user='".$_SESSION["form_email_user"]."' and nom_user='".$_SESSION["form_nom_user"]."' and prenom_user='".$_SESSION["form_prenom_user"]."' ";
      }else{$_SESSION["alerte"] .= "Utilisateur inconnu !";}
    }
    $result = mysql_query($sql);    
    @$ligne = mysql_fetch_array($result);
    if($ligne){
      $x = motdepasse_generation();
      $liste = "id_user='".$ligne["id_user"]."'";      
      $liste .= ", motdepasse_user='".sha1($x)."'";
      $_SESSION["email"]["message"] = "Vos informations."."\r\n";
      $_SESSION["email"]["message"] .= "Veuillez conserver ce message."."\r\n";
      $_SESSION["email"]["message"] .= "\r\n";   
      $_SESSION["email"]["email"] = $ligne["email_user"];
      $_SESSION["email"]["message"] .= "Votre nouveau mot de passe : ".$x."\r\n";
      $_SESSION["email"]["message"] .= "Votre identifiant : ".$ligne["login_user"]."\r\n";      
      $_SESSION["email"]["titre"] = "www.rouaix.com (Vos informations)";                            
      $sqlx = "update user set ".$liste." where id_user=".$ligne["id_user"]."";
      if(!$resultx = mysql_query($sqlx)){echo "<p>".mysql_errno()." : ".mysql_error()."<p>Erreur dans usersecour";}
      email_envoyer();
    }else{
      $_SESSION["alerte"] .= "Utilisateur inconnu !";
    }
    unset($_SESSION["action"]);
    unset($_SESSION["form_email_user"]);
    unset($_SESSION["form_nom_user"]);
    unset($_SESSION["form_prenom_user"]);
    unset($_SESSION["form_login_user"]);
  break;
  
  case "sauveuser" :
    $ok = true;
    $sql = "select id,user from user where user='".@$_SESSION["form_user"]."'";
    $result = mysql_query($sql)or die("erreur dans Inscription !");
    $ligne = mysql_fetch_array($result);
    if($ligne["id"] != @$_SESSION["form_id"]){
      $ok = false;
      $_SESSION["alerte"] .= "Cet identifiant est d&iacute;j&agrave; utilis&iacute; !";
    }
    
    if(!validation_email(@$_SESSION["form_email"])){
      $_SESSION["alerte"] .= "Adresse email invalide.";
      $ok = false; 
    }    
    if(strlen(@$_SESSION["form_user"])<3){
      $_SESSION["alerte"] .= "Votre identifant est trop court.";
      $ok = false; 
    }       
    if(strlen(@$_SESSION["form_prenom"])<1){
      $_SESSION["alerte"] .= "Veuillez saisir votre pr&eacute;nom.";
      $ok = false; 
    }
    if(strlen(@$_SESSION["form_nom"])<1){
      $_SESSION["alerte"] .= "Veuillez saisir votre nom.";
      $ok = false; 
    }  
    if(@$_SESSION["form_motdepasse"]==""){
      unset($_SESSION["form_motdepasse"]);
      unset($_SESSION["form_confirmationmotdepasse"]);
    }
    if(@$_SESSION["form_nouveaumotdepasse"]!=""){
      if(strlen(@$_SESSION["form_nouveaumotdepasse"])<5){
        $_SESSION["alerte"] .= "Votre mot de passe est trop court.";
        $ok = false; 
      }else{
        if(@$_SESSION["form_nouveaumotdepasse"] <> @$_SESSION["form_confirmationmotdepasse"]){
          $_SESSION["alerte"] .= "Mot de passe diff&eacute;rent de votre confirmation.";
          $ok = false; 
        }else{
          $_SESSION["form_motdepasse"]=sha1($_SESSION["form_nouveaumotdepasse"]);

          $_SESSION["email"]["message"] = "Vous avez modifi&eacute; vos informations."."\r\n";
          $_SESSION["email"]["message"] .= "Veuillez conserver ce message."."\r\n";
          $_SESSION["email"]["message"] .= "\n"."\n";   
          $_SESSION["email"]["email"] = $_SESSION["form_email"];
          //$_SESSION["email"]["message"] .= "Votre identifiant de connexion : ".$_SESSION["form_user"]."\r\n";
          $_SESSION["email"]["message"] .= "Votre nouveau mot de passe : ".$_SESSION["form_motdepasse"]."\r\n";
          $_SESSION["email"]["titre"] = "Rouaix.net (Changement de mot de passe)";    

          unset($_SESSION["form_nouveaumotdepasse"]);
          unset($_SESSION["form_confirmationmotdepasse"]);
          $_SESSION["alerte"] .= "Mot de passe modifi&iacute; !";
        }
      }
    }
    if($ok == true){            
      $_SESSION["form_prenom"]=ucfirst($_SESSION["form_prenom"]);
      $_SESSION["form_nom"]=strtoupper($_SESSION["form_nom"]);
      if(isset($_SESSION["userid"]) && $_SESSION["form_id"]!=""){
        $liste = "id='".$_SESSION["form_id"]."'";
        $sql = "select * from user where id='".$_SESSION["form_id"]."'";
        $result = mysql_query($sql)or die("erreur dans sauveuser 1 !");
        $ligne = mysql_fetch_array($result);
        while(list($key,$val) = each($ligne)){
          if(is_string($key)){
            $form_key="form_".$key;
            if(isset($_SESSION[$form_key])){
              if ($key!="id"){
                $liste .= ",".$key."='".$_SESSION[$form_key]."'";
                unset($_SESSION[$form_key]);
              }
            }else{
              //$liste .= ",".$key."=''";
            }
          }
        }
        $sql = "update user set ".$liste." where id=".$_SESSION["form_id"]."";
        if(!$result = mysql_query($sql)) {echo "<p>".mysql_errno()." : ".mysql_error()."<p>Erreur dans sauveuser 2";}
      }
      unset($_SESSION["form_id"]);
      unset($_SESSION["action"]);
      @mysql_free_result(@$result);
    }      
  break;
  
  case "testemail" :
    $_SESSION["email"]["email"] = "rouaix.daniel@wanadoo.fr";
    $_SESSION["email"]["titre"] = "Rouaix.net (Test Email)";
    $_SESSION["alerte"] .= "Message de test"."\r\n";
    envoyer_mail();
    unset($_SESSION["action"]);
  break;
    
  case "inscription" :
    $ok = true;
    
    $sql = "select id_user,login_user from user where login_user='".@$_SESSION["form_login_user"]."'";
    $result = mysql_query($sql)or die("erreur dans Inscription !");
    $ligne = mysql_fetch_array($result);
    
    if($ligne["login_user"] == @$_SESSION["form_login_user"]){
      $_SESSION["alerte"] .= "<p>Identifant : ".@$_SESSION["form_login_user"]." D&eacute;j&agrave; utilis&eacute;";
      $ok = false;      
    }

    if(strlen(@$_SESSION["form_login_user"])<3){
      $_SESSION["alerte"] .= "<p>Votre identifant ".@$_SESSION["form_login_user"]." est trop court.";
      $ok = false; 
    }
    if(!email_validation(@$_SESSION["form_email_user"])){
      $_SESSION["alerte"] .= "<p>Adresse email invalide.";
      $ok = false; 
    }

    if(strlen(@$_SESSION["form_motdepasse_user"])<5){
      $_SESSION["alerte"] .= "<p>Votre mot de passe est trop court.";
      $ok = false; 
    }else{
      if(@$_SESSION["form_motdepasse_user"] <> @$_SESSION["form_confirmationmotdepasse"]){
        $_SESSION["alerte"] .= "<p>Mot de passe diff&eacute;rent de votre confirmation.";
        $ok = false; 
      }
    }
    if(strlen(@$_SESSION["form_prenom_user"])<1){
      $_SESSION["alerte"] .= "<p>Veuillez saisir votre pr&eacute;nom.";
      $ok = false; 
    }
    if(strlen(@$_SESSION["form_nom_user"])<1){
      $_SESSION["alerte"] .= "<p>Veuillez saisir votre nom.";
      $ok = false; 
    }
    
    if($ok == true){            
    $_SESSION["email"]["message"] = "Merci pour votre inscription."."\r\n";
    $_SESSION["email"]["message"] .= "Veuillez conserver ce message."."\r\n";
    $_SESSION["email"]["message"] .= "\n"."\n";   
    $_SESSION["email"]["email"] = $_SESSION["form_email_user"];
    $_SESSION["email"]["message"] .= "Votre identifiant de connexion : ".$_SESSION["form_login_user"]."\r\n";
    $_SESSION["email"]["message"] .= "Votre mot de passe : ".$_SESSION["form_motdepasse_user"]."\r\n";
    $_SESSION["email"]["titre"] = "Rouaix.com (Inscription de ".$_SESSION["form_prenom_user"]." ".$_SESSION["form_nom_user"].")";

    $_SESSION["form_motdepasse_user"]=sha1($_SESSION["form_motdepasse_user"]);
    unset($_SESSION["form_confirmationmotdepasse"]);
    $_SESSION["form_prenom_user"]=ucfirst($_SESSION["form_prenom_user"]);
    $_SESSION["form_nom_user"]=strtoupper($_SESSION["form_nom_user"]);

    $_SESSION["form_systeme"]=" ";
    $_SESSION["form_type_user"]="user";
    
    //---
    $champs = "`id_user`";
    $valeurs = "''";
    $result = mysql_query("SHOW COLUMNS FROM user");
    if (mysql_num_rows($result) > 0) {
      while ($row = mysql_fetch_array($result)) {
        if(is_string($row[0])){
          $fkey="form_".$row[0];
          if ($row[0] != "id_user"){
            if(isset($_SESSION[$fkey])){
              if($_SESSION[$fkey] == " "){$_SESSION[$fkey] = "";}
              $champs .= ",`".$row[0]."`";
              $valeurs .= ",'".$_SESSION[$fkey]."'";
              unset($_SESSION[$fkey]);
            }else{
              $champs .= ",`".$row[0]."`";
              $valeurs .= ",''";
            }
          }
        }
      }
    }


    $sql = "INSERT INTO `user` (".$champs.") VALUES (".$valeurs.");";
    if(!$result = mysql_query($sql)) {
      $_SESSION["alerte"] .= "<p>".$sql;
      $_SESSION["alerte"] .= "<p>".mysql_errno()." : ".mysql_error()."<p>Erreur 002";
    }else{
      $_SESSION["alerte"] .= "<p><b>Inscription r&eacute;ussie.</b><p>Un email de confirmation vous a &eacute;t&eacute; envoy&eacute;. Veuillez v&eacute;rifier votre bo&icirc;te &agrave; lettres <i>(Regardez aussi dans vos courriers ind&eacute;sirables.)</i>";
      email_envoyer();
      unset($l);
    }
    
    unset($champs);
    unset($valeurs);
    unset($fkey);
    unset($row);

    unset($_SESSION["action"]);
    unset($_SESSION["inc"]);
    $_SESSION["page"]="accueil";
  }else{
    $_SESSION["inc"]="inscription";
    $_SESSION["page"]="accueil";
  }

  unset($_SESSION["action"]);
  break;
  
   case "effaceligne":
    switch ($_SESSION["table"]) {
      default :
        $sql = "delete from ".$_SESSION["table"]." where id_".$_SESSION["table"]."='".$_SESSION["effaceligne"]."' limit 1";
        $result = mysql_query($sql);      
      break;
      case "groupe":
        $sql = "delete from ".$_SESSION["table"]." where id_".$_SESSION["table"]."='".$_SESSION["effaceligne"]."'";
        $result = mysql_query($sql);           
        $sql = "delete from ".$_SESSION["table"]." where id_".$_SESSION["table"]."='".$_SESSION["effaceligne"]."' limit 1";
        $result = mysql_query($sql);              
      break;
      case "planning":
        les_enfants($_SESSION["effaceligne"],"planning");
          while (list($key,$val) = each($_SESSION["enfants"])){
            if($val <> 0){
              $sql = "delete from ".$_SESSION["table"]." where id_".$_SESSION["table"]."='".$val."' limit 1";
              $result = mysql_query($sql);
            }
          }

        unset($_SESSION["enfants"]);
        $sql = "delete from ".$_SESSION["table"]." where id_".$_SESSION["table"]."='".$_SESSION["effaceligne"]."' limit 1";
        $result = mysql_query($sql);
      break;
    }
    unset($_SESSION["effaceligne"]);
    unset($_SESSION["action"]);
   break;

  case "supprime":
    $ligne = les_enfants_liste($_SESSION["supprime"]);
    if(is_array($ligne)){
      while (list($key, $val) = each($ligne)){
        $liste = "etat_".$_SESSION["table"]."='a'";
        $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$ligne[$key]."";
        if(!$result = mysql_query($sql)) {$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie 011-a !";}     
      }
    }
    
    $liste = "etat_".$_SESSION["table"]."='a'";
    $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["supprime"]."";
    if(!$result = mysql_query($sql)) {$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie 011-b !";}
    unset($ligne);    
    unset($_SESSION["supprime"]);
    unset($_SESSION["action"]);
   break;
  
  case "restaurer":
    $ligne = les_enfants_liste($_SESSION["restaurer"]);
    if(is_array($ligne)){
      while (list($key, $val) = each($ligne)){
        $liste = "etat_".$_SESSION["table"]."=''";
        $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$ligne[$key]."";
        $result = mysql_query($sql);
        //if(!$result = mysql_query($sql)) {$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie 021-a !";}     
      }
    }
    
    if(existe_id_lien($_SESSION["restaurer"],$_SESSION["table"])==false){
      $liste = "lien_id_".$_SESSION["table"]."=''";
      $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["restaurer"]."";
      $result = mysql_query($sql);
      //if(!$result = mysql_query($sql)) {$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie 021-b !";}     
    }
    
    if(est_archive_id_lien($_SESSION["restaurer"],$_SESSION["table"])==true){
      $liste = "lien_id_".$_SESSION["table"]."=''";
      $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["restaurer"]."";
      $result = mysql_query($sql);
      if(file_exists("scripts/inc.menu.droit.php")){include("scripts/inc.menu.droit.php");} 
    }
      
    $liste = "etat_".$_SESSION["table"]."=''";
    $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["restaurer"]."";
    $result = mysql_query($sql);
    unset($ligne);    
    unset($_SESSION["restaurer"]);
    unset($_SESSION["action"]);
  break;
  
  case "sauvedata":
    datas_filtres();
    sauve();
    unset($_SESSION["action"]);
  break;

  case "deplacer":
    $_SESSION["temp"] = "ok";
    sauve();
    unset($_SESSION["action"]);
  break;

  case "effacefichier":
    if (utilisateur($_SESSION["userid"])){
      unlink("../".$_SESSION["dir"]."".$_SESSION["doc"]);
      $_SESSION["alerte"] .= "<p>Effacement du fichier : ";
      $_SESSION["alerte"] .= @$_SESSION["dir"]."".@$_SESSION["doc"];
    }
      unset($_SESSION["action"]);
      unset($_SESSION["dir"]);
      unset($_SESSION["doc"]);
  break;
  
  case "creationtable":
    if(@$_SESSION["creationtable"]<>""){table_creation($_SESSION["creationtable"]);}
    unset($_SESSION["action"]);
    unset($_SESSION["creationtable"]);
  break;

  case "effacetable":
    connexionmysql();
    $query = "DROP TABLE IF EXISTS `".$_SESSION["effacetable"]."`";
    $temp = mysql_query($query);
    unset($temp);
    unset($_SESSION["action"]);
    unset($_SESSION["effacetable"]);
  break;
  
  case "terminer" :
    les_enfants($_SESSION["terminer"],$_SESSION["table"]);
    while (list($key,$val) = each($_SESSION["enfants"])){
      if($val <> 0){
        $liste = "id_".$_SESSION["table"]."='".$val."'";
        $liste .= ",etat_".$_SESSION["table"]."='t'";
        $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$val."";
        if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Terminer !";}
      }
    }
    unset($_SESSION["enfants"]);
    
    $liste = "id_".$_SESSION["table"]."='".$_SESSION["terminer"]."'";
    $liste .= ",etat_".$_SESSION["table"]."='t'";
    $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["terminer"]."";
    if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Terminer !";}

    unset($liste);
    unset($_SESSION["terminer"]);
    unset($_SESSION["action"]);
    //unset($_SESSION["table"]);
   break;

  case "hs" :   
    $liste = "id_".$_SESSION["table"]."='".$_SESSION["hs"]."'";
    $liste .= ",etat_".$_SESSION["table"]."='hs'";
    $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["hs"]."";
    if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Hs !";}
    unset($liste);
    unset($_SESSION["hs"]);
    unset($_SESSION["action"]);
   break;

  case "annulehs" :   
    $liste = "id_".$_SESSION["table"]."='".$_SESSION["hs"]."'";
    $liste .= ",etat_".$_SESSION["table"]."=''";
    $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["hs"]."";
    if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Hs !";}
    unset($liste);
    unset($_SESSION["hs"]);
    unset($_SESSION["action"]);
   break;
      
   case "annuleterminer" :
    $sql = "select * from ".$_SESSION["table"]." where id_".$_SESSION["table"]."='".$_SESSION["annuleterminer"]."' limit 1";
    if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Terminer !";}

    while(@$ligne = mysql_fetch_array($result)){
        les_parents($ligne["lien"],$_SESSION["table"]);
    while (list($key,$val) = each($_SESSION["parents"])){
      if($val <> 0){
        $liste = "id_".$_SESSION["table"]."='".$val."'";
        $liste .= ",etat_".$_SESSION["table"]."=''";
        $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$val."";
        if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Terminer !";}
      }
    }
    }
    unset($_SESSION["parents"]);
    unset($ligne);
    
    $liste = "id_".$_SESSION["table"]."='".$_SESSION["annuleterminer"]."'";
    $liste .= ",etat_".$_SESSION["table"]."=''";
    $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["annuleterminer"]."";
    if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Terminer !";}
    unset($liste);
    unset($_SESSION["annuleterminer"]);
    unset($_SESSION["action"]);
    //unset($_SESSION["table"]);
   break;
}
}
?>
