<?php
//if (file_exists("securite.php")){include("securite.php");}

function menu_ligne_fichier($dir,$fichier){
  
  if(administrateur($_SESSION["userid"]) && $_SESSION["page"] == "fichiers"){
    $racine = './';
    $qui = "admin";
  }else{
    $racine = 'fichiers/users/'.$_SESSION["userid"].'/';
    $qui = "user";
  }
  if(is_dir($dir.$fichier)){$type = "d";}else{$type = "f";}  
  
  if($type == "f"){
    if(!isset($_SESSION["type"]["mime"])){
      $_SESSION["type"]["mime"] = array();
      $dir = "images/mime/";
      if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
          if($file != '.' && $file != '..' && $file != '.htacces' && $file != 'index.php') {
            $ext = strtolower(pathinfo($file, PATHINFO_FILENAME));
            array_push($_SESSION["type"]["mime"], $ext);
          }
        }
      }
      closedir($handle);    
    }
    
    $temp = explode(".",$fichier);
    $ext = strtolower($temp[count($temp)-1]);
    if(in_array($ext,$_SESSION["type"]["mime"])){$ico = $ext.".png";}else{$ico = "vide.png";}
      
    $image = array("png","jpg","gif","jpeg");
    $visible = array("pdf","txt","png","jpg","gif","jpeg");  
  }
          
  $temp = "";
  $temp .= "<ul class=\"info\">";
  
  if($type == "f"){
    $temp .= "<img src=\"images/mime/".$ico."\" id=\"i24\">";
  }else{
    $temp .= "<img src=\"".$_SESSION["ico"]["dossier"]."\" id=\"i24\">";
  }
    
  $temp .= ucfirst($fichier); 
  $temp .= "<span>";
    
  if($type == "f"){  
    if(in_array($ext, $visible)){$temp .= "<a target=\"Affichage\" href=\"".$dir.$fichier."\"><li>Afficher</li></a>";}
    if($ext == "mm"){$temp .= "<a href=\"".$_SESSION["lien"]."?page=cartes&carte=".$fichier."&rep=".$dir."\"><li>Afficher</li></a>";}    
    $temp .= "<a title=\"Chargement !\" href=\"".$_SESSION["location"]."scripts/inc.download.php?action=fdownload&fdownload=".$fichier."&fichier_type=x&fichier_dir=".$dir."\"><li>T&eacute;l&eacute;charger</li></a>";    
  }else{
    $temp .= "<a href=\"".$_SESSION["lien"]."?rep=".$dir.$fichier."/\"><li>Afficher</li></a>";
  }
  
  $temp .= "<a href=\"#\"><li>Renommer</li></a>";               
  $temp .= "<li>D&eacute;placer<div>";
    
  if($_SESSION["arbre"][$qui]){
    reset($_SESSION["arbre"][$qui]);
    sort($_SESSION["arbre"][$qui]);
    if($_SESSION["arbre"][$qui]!=""){
      foreach ($_SESSION["arbre"][$qui] as $key){
        $x = strlen($key) - strlen($racine);
        if($x == 0){$x = 1;}
        $texte = substr($key,- $x);
        if($key == $dir){            
          $temp .= "<p>".$texte."</p>";
        }else{
          $temp .= "<a href=\"123\"><p>".$texte."</p></a>";
        }
      }       
    }   
  }
  
  //unset($_SESSION["temp"]);
  $temp .= "</div></li>";
    
  if($type == "f"){   
    $size = @filesize($dir.$fichier);
    $unite = array('B','Kb','Mb','Gb');
    @$taille = round(@$size/pow(1024,($i=floor(log(@$size,1024)))),2).' '.@$unite[$i];    
    $temp .= "<p id=\"centre\">".ucfirst(substr_replace($fichier,'',strlen(pathinfo($dir.$fichier, PATHINFO_FILENAME))))."";
    $temp .= "<br><i>".$taille." - ".date("d/m/Y H:i", @filemtime($dir.$fichier))."</i></p>";            
    if(in_array($ext, $image)){$temp .= "<img width=\"100%\" src=\"".$dir.$fichier."\">";}        
    $temp .= "<a href=\"".$_SESSION["lien"]."?action=effacefichier&doc=".$fichier."&dir=".$dir."\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\">";
    $temp .= "<li id=\"droite\">Supprimer.</li></a>";
  }else{
    $temp .= "<a href=\"".$_SESSION["lien"]."?effacedossier=../".$dir.$fichier."\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\">";
    $temp .= "<li id=\"droite\">Supprimer.</li></a>";  
  }
  
  $temp .= "</span>";                    
  $temp .= "</ul>";    
  
  return $temp;   
}

function categorie($data,$x){
  if(!isset($_SESSION["categorie"]) or $x == "reload"){
    $_SESSION["categorie"] = "";
    $result = mysql_query("select id_categorie,nom_categorie,info_categorie,type_categorie,etat_categorie from categorie where id_user='".@$_SESSION["userid"]."' or type_categorie='sys' order by type_categorie,nom_categorie");
    while ($ligne = mysql_fetch_array($result)){
      $_SESSION["categorie"][$ligne["id_categorie"]] = $ligne;
    }
  }
}

function variables_session(){
  if(count($_GET)){
    while (list($key, $val) = each($_GET)){
      //if($val!=""){$_SESSION[$key]= $val ;}else{unset($_SESSION[$key]);}
      if($val!=""){
        $_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');
      }else{
        unset($_SESSION[$key]);
      }
    }
  }

  if(count($_POST)){
    while (list($key, $val) = each($_POST)){
      //if($val!=""){$_SESSION[$key]= $val ;}else{unset($_SESSION[$key]);}
      if($val!=""){
        //$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');
        $_SESSION[$key]= $val;
      }else{
        unset($_SESSION[$key]);
      }
    }
  }
  unset($_GET);
  unset($_POST);
}

function style_cherche($id_style,$nom_style,$type){
  //unset($_SESSION["style"]);
  $x = "";
  $t = "";
  $f = "";
  $b = "";  
  if(!isset($_SESSION["style"]) or !is_array($_SESSION["style"])){
    $result = mysql_query("select id_style,nom_style,texte_style,fond_style,icone_style,bord_style from style where type_style='style'");
    while ($y = mysql_fetch_array($result)){
      if($y["texte_style"]!=""){$_SESSION["style"][$y["id_style"]]["texte"] = $y["texte_style"];}
      if($y["fond_style"]!=""){$_SESSION["style"][$y["id_style"]]["fond"] = $y["fond_style"];}
      if($y["icone_style"]!=""){$_SESSION["style"][$y["id_style"]]["icone"] = $y["icone_style"];}
      if($y["bord_style"]!=""){$_SESSION["style"][$y["id_style"]]["bord"] = $y["bord_style"];}
      
      if($y["texte_style"]!=""){$_SESSION["style"][$y["nom_style"]]["texte"] = $y["texte_style"];}
      if($y["fond_style"]!=""){$_SESSION["style"][$y["nom_style"]]["fond"] = $y["fond_style"];}
      if($y["icone_style"]!=""){$_SESSION["style"][$y["nom_style"]]["icone"] = $y["icone_style"];}
      if($y["bord_style"]!=""){$_SESSION["style"][$y["nom_style"]]["bord"] = $y["bord_style"];}  
    }  
  } 
  
  if($type == "couleur"){ 
    if($id_style != ""){
      if(isset($_SESSION["style"][$id_style])){
        if(isset($_SESSION["style"][$id_style]["texte"])){$t = $_SESSION["style"][$id_style]["texte"];}  
        if(isset($_SESSION["style"][$id_style]["fond"])){$f = $_SESSION["style"][$id_style]["fond"];}
        if(isset($_SESSION["style"][$id_style]["bord"])){$b = $_SESSION["style"][$id_style]["bord"];}
      }
    }
    if($nom_style != ""){
      if(isset($_SESSION["style"][$nom_style])){
        if(isset($_SESSION["style"][$nom_style]["texte"])){$t = $_SESSION["style"][$nom_style]["texte"];}  
        if(isset($_SESSION["style"][$nom_style]["fond"])){$f = $_SESSION["style"][$nom_style]["fond"];}
        if(isset($_SESSION["style"][$nom_style]["bord"])){$b = $_SESSION["style"][$nom_style]["bord"];}    
      }  
    }
    
    $x .= " style=\"";        
    if($t != ""){$x .= "color:#".$t.";";}
    if($f != ""){$x .= "background-color:#".$f.";";}    
    if($b != ""){$x .= "border:1px solid #".$b.";";}
    $x .= "\"";
    
    if($t == "" && $f == "" && $b == ""){$x = "";} 
  }

  if($type == "fond"){ 
    if($id_style != ""){
      if(isset($_SESSION["style"][$id_style])){  
        if(isset($_SESSION["style"][$id_style]["fond"])){$f = $_SESSION["style"][$id_style]["fond"];}
      }
    }
    if($nom_style != ""){
      if(isset($_SESSION["style"][$nom_style])){ 
        if(isset($_SESSION["style"][$nom_style]["fond"])){$f = $_SESSION["style"][$nom_style]["fond"];}    
      }  
    }        
    if($t != ""){if($f != ""){$x .= " style=\"background-color:#".$f."\"";}}
  }
  
  if($type == "texte"){ 
    if($id_style != ""){
      if(isset($_SESSION["style"][$id_style])){
        if(isset($_SESSION["style"][$id_style]["texte"])){$t = $_SESSION["style"][$id_style]["texte"];}  
      }
    }
    if($nom_style != ""){
      if(isset($_SESSION["style"][$nom_style])){
        if(isset($_SESSION["style"][$nom_style]["texte"])){$t = $_SESSION["style"][$nom_style]["texte"];}      
      }  
    }
    if($t != ""){$x .= " style=\"color:#".$t.";\"";}
  }

  if($type == "bord"){ 
    if($id_style != ""){
      if(isset($_SESSION["style"][$id_style])){
        if(isset($_SESSION["style"][$id_style]["bord"])){$b = $_SESSION["style"][$id_style]["bord"];}  
      }
    }
    if($nom_style != ""){
      if(isset($_SESSION["style"][$nom_style])){
        if(isset($_SESSION["style"][$nom_style]["bord"])){$b = $_SESSION["style"][$nom_style]["bord"];}      
      }  
    }
    if($b != ""){$x .= " style=\"border:1px solid #".$b.";\"";}
  }
  
  if($type == "icone"){
    if($id_style != ""){
      if(isset($_SESSION["style"][$id_style])){
        if(isset($_SESSION["style"][$id_style]["icone"])){
          $x = "<img src=\"".$_SESSION["style"][$id_style]["icone"]."\" class=\"module\">";
        }  
      }
    }
    if($nom_style != ""){
      if(isset($_SESSION["style"][$nom_style])){
        if(isset($_SESSION["style"][$nom_style]["icone"])){
          $x = "<img src=\"".$_SESSION["style"][$nom_style]["icone"]."\" class=\"module\">";
        }     
      }  
    }   
  }
    
  return $x;
}

function repertoire_liste($path,$qui){
  if(!isset($_SESSION["arbre"][$qui])){
    $_SESSION["arbre"][$qui] = array();
    array_push($_SESSION["arbre"][$qui],$path); 
  } 
  if ($handle = opendir($path)) {
    while (false !== ($file = readdir($handle))){
      if($file != '.' && $file != '..' && $file != '.htacces' && $file != 'index.php') {
        $x= $path.$file.'/';
        if(is_dir($path.$file)){
          //if(!array_key_exists($x,$_SESSION["temp"])){
          if(!in_array($x,$_SESSION["arbre"][$qui])){
            array_push($_SESSION["arbre"][$qui],$x);
          }
          repertoire_liste($x,$qui);
        } 
      }      
    }
    closedir($handle);
    return true;
  }
}

function repertoire_creation($x){
  if(!is_dir('../fichiers/users')){
    mkdir ('../fichiers/users');
    fichier_index_vide('../fichiers/users/');
  }
  $target = "../fichiers/users/";
  if(!is_dir($target.$x)){
    @mkdir ($target.$x);
    fichier_index_vide($target.$x."/");
  }
}

function fichier_index_vide($target){
    if(!file_exists($target."index.php")){
      $Fnm = $target."index.php";
      $inF = fopen($Fnm,"w");
      $texte = "<"."?php"."\n";
      //$texte .= "if(file_exists(\"../../securite.php\")){include(\"../../securite.php\");}";
      $texte .= "\n"."?".">";
      fwrite($inF,$texte);
      fclose($inF);
      unset($texte);
    }
}

function repertoire_supprimer($path) {
    @$O = @dir($path);
    if(!is_object($O))
    return false;
    while($file = $O -> read()) {
        if($file != '.' && $file != '..') {
            if(is_file($path.'/'.$file))
            unlink($path.'/'.$file);
            else
              if(is_dir($path.'/'.$file))
              repertoire_supprimer($path.'/'.$file);
            }
        }
    $O -> close();
    rmdir($path);
    return true;
}

function date_heure(){
   $x = date("d/m/Y H:i");
   return($x);
}

function date_jour_texte($y){
   $x = date("N",$y);
   if ($x == "1"){$x = "Lundi";}
   if ($x == "2"){$x = "Mardi";}
   if ($x == "3"){$x = "Mercredi";}
   if ($x == "4"){$x = "Jeudi";}
   if ($x == "5"){$x = "Vendredi";}
   if ($x == "6"){$x = "Samedi";}
   if ($x == "7"){$x = "Dimanche";}
   return($x);
}

function date_texte($y){
   $x = date_jour_texte($y)."&nbsp;".date("d",$y)."&nbsp;".mois_texte($y)."&nbsp;".date("Y",$y);
   return($x);
}

function pluriel($x){
   if ($x > 1){$y ="s";}else{$y = "";}
   return $y;
}

function motdepasse_generation(){ 
  $chaine = "abcdefghijklmnopqrstuvwxyz.ABCDEFGHIJKLMNOPQRSTUVWXYZ-0123456789+@";
  $nb_caract = 8;
  $pass = "";
  for($u = 1; $u <= $nb_caract; $u++) {
    $nb = strlen($chaine);
    $nb = mt_rand(0,($nb-1));
    $pass.=$chaine[$nb];
  }
  return $pass;
}

function webmachine(){
  $_SESSION["machine"] = getenv("HTTP_HOST");
  if ($_SESSION["machine"] == "127.0.0.1" or $_SESSION["machine"] == "localhost"  or $_SESSION["machine"] == "192.168.1.3"){
    $_SESSION["location"] = "http://".$_SESSION["machine"]."/";
  } else {
    $_SESSION["location"] = "http://www.rouaix.com/";
  }
  $_SESSION["lien"] = $_SESSION["location"]."scripts/index.php";
  $_SESSION["provenance"] = cherche_provenance();
  $_SESSION["userip"] = cherche_ip();  
  //$_SESSION["repertoire"] = explode("/", $_SERVER["PHP_SELF"]); 
  //$_SESSION["self"] = $_SERVER["PHP_SELF"]; 
}

function connexionmysql(){    
  $machine = getenv("HTTP_HOST");
  if ($machine == "127.0.0.1" or $machine == "localhost"  or $machine == "192.168.1.3"){
    $_SESSION["base"]="rouaixnet";
    $db_serveur = $machine;
    $db_utilisateur = "root";
    $db_mot_de_passe = "371524253246";
  } else {
    $_SESSION["base"]="rouaixcom";
    $db_serveur = "sql.rouaix.com";
    $db_utilisateur = "rouaixcom";
    $db_mot_de_passe = "371524253246";
  }
  @$db = mysql_connect($db_serveur, $db_utilisateur, $db_mot_de_passe);
  if(!@mysql_select_db($_SESSION["base"],$db)){
    @$x = "location:http://".$machine."/scripts/404.php";
    header($x);
    exit();
  }
  unset($machine);
  unset($db_utilisateur);
  unset($db_mot_de_passe);
  unset($db_serveur); 
}

function cherche_provenance(){
   $HTTP_REFERER = getenv("HTTP_REFERER");
   $HTTP_HOST = getenv("HTTP_HOST");
   if ( !mb_eregi($HTTP_HOST,$HTTP_REFERER) ) {
      if ($HTTP_REFERER == "") {$temp = "Favori";}else{ $temp = $HTTP_REFERER;}
   }else{ $temp = "Ici";}
   return $temp;
}

function cherche_ip(){
   $ip = (getenv("HTTP_X_FORWARDED_FOR") ? getenv("HTTP_X_FORWARDED_FOR") : getenv("REMOTE_ADDR"));
   return $ip;
}

function sauve_hit(){
  if(isset($_SESSION["userid"])){
    if($_SESSION["userid"] != ""){
      $r = @$_SESSION["page"];
      $r = @mysql_query("INSERT INTO `hit` (`id_hit`,`id_user`,`nom_hit`,`horloge_hit`,`session_hit`) VALUES ('','".$_SESSION["userid"]."','".$_SERVER['PHP_SELF']."/page=".@$r."','".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))."','');");
    }
  }else{
    $r = @mysql_query("INSERT INTO `hit` (`id_hit`,`id_user`,`nom_hit`,`horloge_hit`,`session_hit`) VALUES ('','Visiteur','".$_SERVER['PHP_SELF']."/page=".@$_SESSION["page"]."','".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))."','');");
  }
}

function cherche_civilite($x){
  if($y = mysql_fetch_array(mysql_query("select nom_civilite from civilite where id_civilite='".$x."'"))){
  return $y["nom_civilite"];}
}

function date_numerique($y){
  if($y!="" && $y!=0){
   $x = @date("d/m/Y",$y);
   }else{$x="";}
   return($x);
}

function heure_numerique($y){
  if($y!="" && $y!=0){
   $x = @date("H:i",$y);
  }else{$x="";}
  return($x);
}

function jour_texte($y){
  if($y > 7 or $y == 0){
    $x = date("N",$y);
  }else{
    $x = $y;
  }
  if ($x == "1"){$x = "Lundi";}
  if ($x == "2"){$x = "Mardi";}
  if ($x == "3"){$x = "Mercredi";}
  if ($x == "4"){$x = "Jeudi";}
  if ($x == "5"){$x = "Vendredi";}
  if ($x == "6"){$x = "Samedi";}
  if ($x == "7"){$x = "Dimanche";}
  return($x);
}

function mois_texte($y){
   $x = date("m",$y);
   if ($x == "01"){$x = "Janvier";}
   if ($x == "02"){$x = "F&eacute;vrier";}
   if ($x == "03"){$x = "Mars";}
   if ($x == "04"){$x = "Avril";}
   if ($x == "05"){$x = "Mai";}
   if ($x == "06"){$x = "Juin";}
   if ($x == "07"){$x = "Juillet";}
   if ($x == "08"){$x = "Ao&ucirc;t";}
   if ($x == "09"){$x = "Septembre";}
   if ($x == "10"){$x = "Octobre";}
   if ($x == "11"){$x = "Novembre";}
   if ($x == "12"){$x = "D&eacute;cembre";}
   return($x);
}

function semaine_numero($y){
  if($y > 53){
    $x = $y;
  }else{
    $y = $_SESSION["jour"];
  }
  $x = date("W",$y);
  return($x);
}

function semaine_nombre($annee){
  $x = date("W",mktime(0, 0, 0, "12", "31", $annee));
  if ($x == 1){
    $x = date("W",mktime(0, 0, 0, "12", "24", $annee));
  }

  return($x);
}

function login(){
  if(isset($_SESSION["loguser"]) && isset($_SESSION["logpass"])){
      if($_SESSION["loguser"]!="" && $_SESSION["logpass"]!=""){
        $sql = "select * from user where login_user='".strtolower($_SESSION["loguser"])."'";
        if($result = mysql_query($sql)){
        $ligne = mysql_fetch_array($result);
        $pass=$ligne["motdepasse_user"];
        $test = strtolower($ligne["login_user"]);
        if($test == strtolower($_SESSION["loguser"]) && $pass == sha1($_SESSION["logpass"])){
           if($ligne["prenom_user"]!=""){
              $_SESSION["usernom"]=ucfirst($ligne["prenom_user"])." ".strtoupper($ligne["nom_user"]);
           }else{
              $_SESSION["usernom"]=strtoupper($ligne["nom_user"]);
           }
           if($ligne["id_civilite"]!=""){
              $_SESSION["usernom"] = cherche_civilite($ligne["id_civilite"])." ".$_SESSION["usernom"];
           }
           $_SESSION["username"]=$ligne["nom_user"];
           $_SESSION["userid"]=$ligne["id_user"];

           $r = mysql_query("INSERT INTO `hit` (`id_hit`,`id_user`,`nom_hit`,`horloge_hit`,`session_hit`) VALUES ('','".$_SESSION["userid"]."','Login','".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))."','');");
        }else{
           unset($_SESSION["username"]);
           unset($_SESSION["userid"]);
           unset($test);
           unset($pass);
        }
      }
     }
     unset($_SESSION["logpass"]);
    }
    unset($_SESSION["action"]);
}

function login_affiche(){
  $ok = 0;
  if(isset($_SESSION["usernom"])){
    if($_SESSION["usernom"]!=""){$ok = $ok + 1;}
  }
  if(isset($_SESSION["username"])){
    if($_SESSION["username"]!=""){$ok = $ok + 1;}
  }
  if(isset($_SESSION["userid"])){
    if($_SESSION["userid"]!=""){$ok = $ok + 1;}
  }
  echo "<div class=\"login\">";
  switch ($_SESSION["web"]) {
    default : 
    break;
    case "mobile":
      if($ok > 1){
        echo "<a class=\"logo\" href=\"".$_SESSION["lien"]."?page=user&mpage=information&userinfo=".$_SESSION["userid"]."\" title=\"Modifier mes informations\">".@$_SESSION["usernom"]."</a>";
        echo "</td><td class=\"logo\"><a class=\"logo\" href=\"".$_SESSION["lien"]."?action=logout\" title=\"D&eacute;connexion\"><img class=\"logo\" src=\"images/jgp/x.jpg\"></a>";
      }else{
        echo "<form class=\"login\" method=\"post\" action=\"".$_SESSION["lien"]."\">";
        echo "Veuillez vous identifier";
        echo "<br><input class=\"login\" tabindex=\"1\" type=\"text\" name=\"loguser\" value=\"".@$_SESSION["loguser"]."\" title=\"Identifiant\">";
        echo "<br><input class=\"login\" tabindex=\"2\" type=\"password\" name=\"logpass\" value=\"\" title=\"Mot de passe\">";
        echo "<br><input class=\"login\" id=\"image\" type=\"image\" tabindex=\"3\" src=\"images/png/ok-vert.png\" Value=\"Ok\" title=\"Valider\">";
        echo "<input type=\"hidden\" name=\"action\" value=\"login\"><input type=\"hidden\" name=\"page\" value=\"accueil\">";
        echo "</form>";
      }
    break;
    case "standard":
      if($ok > 1){
        echo "<table class=\"login\"><tr>";
        echo "<td>";
        //$p = utilisateur_cherche_photo($_SESSION["userid"]);        
        echo "<a class=\"login\" href=\"".$_SESSION["lien"]."?page=user&mpage=information&userinfo=".$_SESSION["userid"]."\" title=\"Modifier mes informations\">".@$_SESSION["usernom"];
        //if($p != ""){echo "<img src=\"".$p."\" id=\"i12\" style=\"margin-left:10px;background-color:#777;border:1px solid #999;\">";}
        echo "</a>";
        echo "</td>";
        echo "<td class=\"login\"><a class=\"login\" href=\"".$_SESSION["lien"]."?action=logout\" title=\"D&eacute;connexion\"><img class=\"login\" src=\"images/jpg/ico_exit.jpg\"></a></td>";
        echo "</tr></table>";
      }else{
        echo "<form class=\"login\" method=\"post\" action=\"".$_SESSION["lien"]."\">";
        echo "<table><tr>";
        echo "<td>Veuillez vous identifier</td>";
        echo "<td><input class=\"login\" tabindex=\"1\" type=\"text\" name=\"loguser\" value=\"".@$_SESSION["loguser"]."\" title=\"Identifiant\"></td>";
        echo "<td><input class=\"login\" tabindex=\"2\" type=\"password\" name=\"logpass\" value=\"\" title=\"Mot de passe\"></td>";
        echo "<td><input class=\"login\" id=\"image\" type=\"image\" tabindex=\"3\" src=\"images/jpg/ico_valider_v.jpg\" Value=\"Ok\" title=\"Valider\"></td>";
        echo "<td><a href=\"".$_SESSION["lien"]."?page=accueil&mpage=secour\" title=\"Identifiant ou mot de passe perdu ?\"><img class=\"login\" src=\"images/jpg/question.jpg\"></a></td>";
        echo "</tr></table>";
        echo "<input type=\"hidden\" name=\"action\" value=\"login\"><input type=\"hidden\" name=\"page\" value=\"accueil\">";
        echo "</form>";
      }
    break;  
  }
  echo "</div>";  
  connecte();
}

function page_en_construction(){
  $x = "scripts/page.construction.php";
  if (file_exists($x)){include($x);}
}


function connecte(){
  $deconnection = 180 ; // En secondes
  
  $verif = 0;
  $cpt = 0;
  $ok = false;
  
  if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}
  if(isset($_SESSION["userid"])){$_SESSION["co"] = $_SESSION["userid"];}else{$_SESSION["co"] = "Visiteur";} 
  $result = mysql_query("select * from hit where session_hit != ''");
  while ($l = @mysql_fetch_array($result)){
    $cpt ++;
    $xl[$cpt] = $l;
  }
  if($cpt != 0){
    @reset($xl);
    while (list($key, $ligne) = @each($xl)){
      if(isset($_SESSION["userid"]) && $ligne["id_user"] == $_SESSION["userid"]){
        $ok = true;
        $liste = "id_user='".$_SESSION["co"]."',horloge_hit='".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))."',''";
        $sqlz = "update hit set ".$liste." where id_hit ='".$ligne["id_hit"]."'";
        $resultz = mysql_query($sqlz);
        $verif++;
      }else{
        $y = mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
        $x = $ligne["horloge_hit"];
        $ecart = $y - $x;
        if($ligne["id_user"] != "Visiteur"){
          if($ecart > $deconnection){
            $r = mysql_query("delete from hit where id_hit='".$ligne["id_hit"]."'");
          }
        }else{
          if($ligne["session_hit"] == session_id()){
            $r = mysql_query("delete from hit where id_hit='".$ligne["id_hit"]."'");
          }else{
            if($ecart > $deconnection){
              $r = mysql_query("delete from hit where id_hit='".$ligne["id_hit"]."'");
            }
          }
        }
      }
    }
  }
  
  if($ok == false){
    $sql = "INSERT INTO `hit` (`id_hit`,`id_user`,`nom_hit`,`horloge_hit`,`session_hit`) VALUES ('','".$_SESSION["co"]."','','".mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"))."','".session_id()."');";
    $result = mysql_query($sql);
  }
  
  $_SESSION["visiteur"]["inconnu"] = 0;
  $_SESSION["visiteur"]["connu"] = 0;
  $_SESSION["visiteur"]["membre"] = 0;

  if(isset($xl) && is_array(@$xl)){
    @reset($xl);
    while (list($key, $ligne) = @each($xl)){
      if($ligne["id_user"] == "Visiteur"){$_SESSION["visiteur"]["inconnu"] ++ ;}
      if($ligne["id_user"] != "Visiteur"){$_SESSION["visiteur"]["connu"] ++ ;}
    }
  }
  
  $_SESSION["visiteur"]["inconnu"] = str_pad($_SESSION["visiteur"]["inconnu"], 3, "0", STR_PAD_LEFT);
  $_SESSION["visiteur"]["connu"] = str_pad($_SESSION["visiteur"]["connu"], 3, "0", STR_PAD_LEFT);

  $result = mysql_query("select * from user");
  $_SESSION["visiteur"]["membre"] = str_pad(mysql_num_rows($result), 3, "0", STR_PAD_LEFT);

  unset($_SESSION["co"]);
}

function alertes(){
  if (isset($_SESSION["alerte"])){
    if($_SESSION["alerte"]!=""){
      echo "<div class=\"alerte\"><h3 class=\"alerte\" id=\"centre\">Message d'information.</h3>";
      echo "<p class=\"alerte\">".$_SESSION["alerte"]."</p>";
      echo "</div>\n";
    }
    unset($_SESSION["alerte"]);
  }
}

function administrateur($y){
  $x = false;
  if($y == @$_SESSION["userid"]){
    if(isset($_SESSION["userid"]) && $_SESSION["userid"] != ""){
      if(isset($_SESSION["localip"]) && $_SESSION["localip"] == "192.168.69.99"){
        $x = true;
      }else{
        //connexionmysql();
        $query = "select id_user,type_user,systeme_user from user where id_user='".$y."'";
        if($res=mysql_query($query)){
        $verif=@mysql_fetch_array($res);
        if($verif["type_user"]=="user"){
          if(@$verif["systeme_user"]=="A" && mysql_num_rows($res)!=0){
            $x = true;
            $_SESSION["localip"] = "192.168.69.99";
          }
        }
        }
      }
    }
  }else{
    //connexionmysql();
    $query = "select id_user,type_user,systeme_user from user where id_user='".$y."'";
    $res=mysql_query($query);
    $verif=@mysql_fetch_array($res);
    if($verif["type_user"]=="user"){
      if(@$verif["systeme_user"]=="A" && mysql_num_rows($res)!=0){
        $x = true;
      }
    }
  }
  return $x;
}

function utilisateur_info($x){
  $sql = "select id_user,nom_user,prenom_user from user where id_user='".$x."' ";
  if($result = mysql_query($sql)){ 
  $ligne = @mysql_fetch_array($result);  
  return $ligne;
  }
}

function utilisateur_cherche_photo($x){
  $ext = array("png","jpg","gif");
  $y = "";
  while(list(,$val) = each($ext)){
    if (file_exists("fichiers/users/photos/user_".$x.".".$val)){
      $photo = "fichiers/users/photos/user_".$x.".".$val;
      $fichier = "user_".$_SESSION["userid"].".".$val;    
      if(isset($photo)){$y = $photo;}    
    }
  }
  return $y;
}

function utilisateur_banni($y){
  $x = false;
  if(isset($_SESSION["userid"])){
    //connexionmysql();
    $query = "select id_user,type_user from user where id_user='".$y."'";
    if($res=mysql_query($query)){
      $verif=@mysql_fetch_array($res);
      if($verif["type_user"]=="banni" && mysql_num_rows($res)!=0){$x = true;}else{$x = false;}
    }
  }
  return $x;
}

function utilisateur($y){
  $x = false;
  if($y == @$_SESSION["userid"]){
    if(isset($_SESSION["userid"]) && $_SESSION["userid"] !=""){
      if(isset($_SESSION["localip"]) && $_SESSION["localip"] == "192.168.1.8"){$x = true;
      }else{
        //connexionmysql();
        $query = "select id_user,type_user,systeme_user from user where id_user='".$y."'";
        if($res=mysql_query($query)){
        $verif=@mysql_fetch_array($res);
        if($verif["type_user"]=="user" && mysql_num_rows($res)!=0){
          $x = true;
          $_SESSION["localip"] = "192.168.1.8";
        }else{
          $x = false;
        }
        }
    }
  }
  }else{
    //connexionmysql();
    $query = "select id_user,type_user,systeme_user from user where id_user='".$y."'";
    if($res = mysql_query($query)){
    $verif=@mysql_fetch_array($res);
    if($verif["type_user"]=="user" && mysql_num_rows($res)!=0){$x = true;}
    }
  }
  return $x;   
}

function datas_filtres(){ 
  switch (@$_SESSION["table"]){
    default :
      //$_SESSION["temp"] = "ok";
      verifier_debutfin();
      if(@$_SESSION["form_nom_".$_SESSION["table"]] != ""){
        $_SESSION["temp"] = "ok";
      }
    break;
    case "user":
      if(isset($_SESSION["form_systeme_user"])){
      if(@$_SESSION["form_systeme_user"] == "A"){
        if(@$_SESSION["form_controle"] != "1"){
          unset($_SESSION["form_systeme_user"]);
          unset($_SESSION["form_controle"]);
        }else{
          $_SESSION["temp"] = "ok";
          unset($_SESSION["form_controle"]);
        }
      }
      }else{
        $_SESSION["temp"] = "ok";
      }
    break;
    case "couleurs":
      $_SESSION["form_type_couleurs"] = "couleurs";
      $_SESSION["temp"] = "ok";
    break;
    case "style":
      unset($_SESSION["style"]);
    break;
  }
  
  switch (@$_SESSION["form_type_".$_SESSION["table"]]){
    default :
      $_SESSION["temp"] = "ok";
    break;
    case "*user":
      if(@$_SESSION["table"] == "groupe"){
        if(@$_SESSION["form_archive"] == "ok"){$_SESSION["form_archive"]=" ";}
        $_SESSION["temp"] = "ok";
      }else{
        $_SESSION["temp"] = "ok";
      }
    break;    
    case "hf":
      if(@$_SESSION["form_nom_".$_SESSION["table"]] != ""){
        $_SESSION["form_debut_".$_SESSION["table"]] = verifier_heure($_SESSION["form_debut_".$_SESSION["table"]]);
        $_SESSION["form_fin_".$_SESSION["table"]] = verifier_heure($_SESSION["form_fin_".$_SESSION["table"]]);
        $x = verifier_heure_debutfin($_SESSION["form_debut_".$_SESSION["table"]],$_SESSION["form_fin_".$_SESSION["table"]]);
        $_SESSION["form_debut_".$_SESSION["table"]] = date("Y-m-d",$_SESSION["form_jour_".$_SESSION["table"]])." ".$x[0];
        $_SESSION["form_fin_".$_SESSION["table"]] = date("Y-m-d",$_SESSION["form_jour_".$_SESSION["table"]])." ".$x[1];
        $_SESSION["temp"] = "ok";
        unset($_SESSION["form_jour_".$_SESSION["table"]]);
      }
               
    break;
    case "hv":
      if(@$_SESSION["form_nom_".$_SESSION["table"]] != ""){
        $_SESSION["form_debut_".$_SESSION["table"]] = verifier_heure($_SESSION["form_debut_".$_SESSION["table"]]);
        $_SESSION["form_fin_".$_SESSION["table"]] = verifier_heure($_SESSION["form_fin_".$_SESSION["table"]]);
        $x = verifier_heure_debutfin($_SESSION["form_debut_".$_SESSION["table"]],$_SESSION["form_fin_".$_SESSION["table"]]);
        $_SESSION["form_debut_".$_SESSION["table"]] = date("Y-m-d",$_SESSION["form_jour_".$_SESSION["table"]])." ".$x[0];
        $_SESSION["form_fin_".$_SESSION["table"]] = date("Y-m-d",$_SESSION["form_jour_".$_SESSION["table"]])." ".$x[1];
        //$_SESSION["form_debut_".$_SESSION["table"]] = $x[0];
        //$_SESSION["form_fin_".$_SESSION["table"]] = $x[1];
        $_SESSION["temp"] = "ok";
        unset($_SESSION["form_jour_".$_SESSION["table"]]);
      }     
    break;
    case "message":
      $_SESSION["form_expediteur_messagerie"] = $_SESSION["userid"];
      while (list($key, $val) = @each($_SESSION)){$sauvegarde[$key] = $val;}
      $_SESSION["temp"] = "ok";
      $_SESSION["form_type_messagerie"] = "message_e";
      sauve();
      while (list($key, $val) = @each($sauvegarde)){$_SESSION[$key] = $val;}
      unset($sauvegarde);
      $_SESSION["temp"] = "ok";
    break;
  }
}

function sauve(){
  if($_SESSION["temp"] == "ok"){
  
    if(isset($_SESSION["form_id_".$_SESSION["table"]]) && @$_SESSION["form_id_".$_SESSION["table"]] <> ""){
      $liste = "id_".$_SESSION["table"]."='".$_SESSION["form_id_".$_SESSION["table"]]."'";
      $result = mysql_query("SHOW COLUMNS FROM ".$_SESSION["table"]."");
      if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
          if(is_string($row[0])){
            $fkey="form_".$row[0];
            if(isset($_SESSION[$fkey])){
              if ($row[0] != "id_".$_SESSION["table"]){
                if($_SESSION[$fkey] == " "){$_SESSION[$fkey] = "";}
                $liste .= ",".$row[0]."='".$_SESSION[$fkey]."'";
                unset($_SESSION[$fkey]);
              }
            }
          }
        }
      }
          
      $sql = "update ".$_SESSION["table"]." set ".$liste." where id_".$_SESSION["table"]."=".$_SESSION["form_id_".$_SESSION["table"]]."";
      if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie sauve UPDATE 002 !";}
      unset($fkey);
      unset($row);
      unset($liste);
      unset($_SESSION["form_id_".$_SESSION["table"]]);
    }else{
      if(@$_SESSION["form_nom_".$_SESSION["table"]] != ""){
      $champs = "`id_".$_SESSION["table"]."`";
      $valeurs = "''";
      $result = mysql_query("SHOW COLUMNS FROM ".$_SESSION["table"]."");
      if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
          if(is_string($row[0])){
            $fkey="form_".$row[0];
            if ($row[0] != "id_".$_SESSION["table"]){
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
      
      $sql = "INSERT INTO `".$_SESSION["table"]."` (".$champs.") VALUES (".$valeurs.");";
      if(!$result = mysql_query($sql)){$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie sauve INSERT 001 !";}
      //mysql_free_result($result);
      unset($champs);
      unset($valeurs);
      unset($fkey);
      unset($row);
      }
    }
    //unset($_SESSION["table"]);
    unset($_SESSION["temp"]);
    if(isset($_SESSION["form_vide"])){unset($_SESSION["form_vide"]);}
  }else{$_SESSION["alerte"] .= "<p>Pas de Ok !";}
}

function icones_liste(){
  $sql ="select nom_icones,lien_icones from icones order by nom_icones asc";
  if($result = mysql_query($sql)){
    while ($ligne = mysql_fetch_array($result)){$_SESSION["ico"][$ligne["nom_icones"]] = $ligne["lien_icones"];}
  }
}

function erreur_404($x){
  if(!isset($_SESSION["alerte"])){$_SESSION["alerte"]="";}
  $_SESSION["alerte"].= "<div class=\"alerte\">";
  $_SESSION["alerte"].= "<img class=\"module\" src=\"".$_SESSION["ico"]["erreur_404"]."\" id=\"i64\">";
  $_SESSION["alerte"].= "<br>";
  $_SESSION["alerte"].= $x." => Page introuvable !";
  //echo "<br>";
  //echo "[".$x."]";
  $_SESSION["alerte"].= "</div>";
}

function texte_separe(){
  echo "<span class=\"separe\">|</span>";
}
 
function ico_module_nouveau($x,$y){
  echo "<a title=\"Ajouter un enregistrement\" href=\"javascript:voir('form".$x."');ajaxpage(rootdomain+'scripts/inc.popup.php?table=".$x."&popup=form".$x."&acte=formulaire&formulaire=nouveau','form".$x."');\">";
  echo "<img class=\"module\" src=\"".$_SESSION["ico"]["ajouter"]."\">";
  echo "</a>";
}

function ico_module_vue($x,$y){
  switch ($x){
    default :
    break;
    
    case "agenda" :
      if(isset($_SESSION["vue"])){
        $ok = array("liste","jour","semaine","mois","an");
        if(!in_array($_SESSION["vue"],$ok)){$_SESSION["vue"]="jour";} 
      }else{$_SESSION["vue"]="jour";}    
    
      $ico = "<img class=\"module\" src=\"".$_SESSION["ico"]["vue"]."\">";
      $icom = "<img class=\"module\" src=\"".module_icone($x)."\">";
      
      echo "<a title=\"Vue Liste\" href=\"".$_SESSION["lien"]."?page=".$x."&vue=liste\">";
      if($_SESSION["vue"]=="liste"){echo $icom."</a>";}else{echo $ico."</a>";}
      
      echo "<a title=\"Vue Journalière\" href=\"".$_SESSION["lien"]."?page=".$x."&vue=jour\">";
      if($_SESSION["vue"]=="jour"){echo $icom."</a>";}else{echo $ico."</a>";}
      
      echo "<a title=\"Vue Hebdomadaire\" href=\"".$_SESSION["lien"]."?page=".$x."&vue=semaine\">";
      if($_SESSION["vue"]=="semaine"){echo $icom."</a>";}else{echo $ico."</a>";}
      
      echo "<a title=\"Vue Mensuelle\" href=\"".$_SESSION["lien"]."?page=".$x."&vue=mois\">";
      if($_SESSION["vue"]=="mois"){echo $icom."</a>";}else{echo $ico."</a>";}
      
      echo "<a title=\"Vue Annuelle\" href=\"".$_SESSION["lien"]."?page=".$x."&vue=an\">";
      if($_SESSION["vue"]=="an"){echo $icom."</a>";}else{echo $ico."</a>";}    
    break;
  }
}

function module_action($x){
  if(file_exists("../scripts/modules/".$x."/action.php")){
    include("../scripts/modules/".$x."/action.php");
  }else{
    //erreur_404(ucfirst($x));
  } 
}

function module_menu($x,$y){
  echo "<table width=\"100%\">";
  echo "<tr>\n";
  echo "<td style=\"text-align:left;\">";
    ico_module_nouveau($x,$y);
    ico_module_vue($x,$y);
  echo "</td>\n";
  echo "<td style=\"text-align:right;\">";
    ico_module_preferences($x);
    ico_module_actualite($x);
    ico_module_information($x);
    ico_module_aide($x);   
  echo "</td>\n";
  echo "</tr>";
  echo "</table>\n";
}

function module($x,$y){
  $non = array('explorateur','test','vue','inscription','user','cartes','menu','images','tables','utilisateur','navigation','enligne','actualite','accueil','administration','droits','modules','fichiers');
  
  echo "<div class=\"module\" ".style_cherche('',$x,'couleur').">";
  //module_menu($x,$y);
  //$non = array('user','cartes','menu','images','tables','utilisateur','navigation','enligne','actualite','accueil','radios','administration','droits','modules','fichiers');
  //if(!in_array($y,$non) && !in_array($x,$non)){module_titre($x,$y);} 
  switch ($y){
    default :
      if(isset($_SESSION["modules"]["116"][$x])){
        if(file_exists("scripts/modules/".$x."/".$y.".php")){
          include("scripts/modules/".$x."/".$y.".php");
        }else{
          //if(file_exists("../scripts/modules/".$x."/".$y.".php")){
            //include("../scripts/modules/".$x."/".$y.".php");
          //}
          //page_en_construction();
          erreur_404(ucfirst($x)." ".ucfirst($y));
        }
      }
    break;
    case "preferences":
        if(file_exists("scripts/modules/".$x."/".$y.".php")){
          include("scripts/modules/".$x."/".$y.".php");
        }else{
          erreur_404(ucfirst($x)." ".ucfirst($y));
        }    
    break;
    case "fonction":
        if(file_exists("scripts/modules/".$x."/".$y.".php")){
          include("scripts/modules/".$x."/".$y.".php");
        }else{
          //if(file_exists("../scripts/modules/".$x."/".$y.".php")){
            //include("../scripts/modules/".$x."/".$y.".php");
          //}
          page_en_construction();
        }    
    break;
    case "index":
      if(isset($_SESSION["modules"]["116"][$x])){
        if(utilisateur($_SESSION["userid"])){
          if(!in_array($y,$non) && !in_array($x,$non)){
            module_titre($x,$y);
          }
        }       
        if(file_exists("scripts/modules/".$x."/index.php")){
          include("scripts/modules/".$x."/index.php");
        }else{
          //if(file_exists("../scripts/modules/".$x."/index.php")){
            //include("../scripts/modules/".$x."/index.php");
          //}
          page_en_construction();
        }   
      }  
    break;
    case "affichage.table":
      if(isset($_SESSION["modules"]["117"][$x]) && !isset($_SESSION["mpage"])){
        if(file_exists("scripts/modules/affichage.table.php")){
          include("scripts/modules/affichage.table.php");
        }
      }
    break;
    case "affichage.liste":
      if(isset($_SESSION["modules"]["118"][$x]) && !isset($_SESSION["mpage"])){
        if(file_exists("scripts/modules/affichage.liste.php")){
          include("scripts/modules/affichage.liste.php");
        }
      }
    break;
  }
  echo "</div>\n";
}

function module_titre($x,$y){
  module_menu($x,$y);
  echo "<table width=\"100%\"><tr>\n";
  //echo "<td style=\"width:70px;padding:5px;\">";
  //echo "<a title=\"Ajouter un enregistrement\" href=\"javascript:voir('form".$x."');ajaxpage(rootdomain+'scripts/inc.popup.php?table=".$x."&popup=form".$x."&acte=formulaire&formulaire=nouveau','form".$x."');\">";
  //echo "<img class=\"entete\" src=\"".module_icone($x)."\" id=\"i64\">";
  //echo "</a>";
  //echo "</td>\n";
  echo "<td>";
  echo "<div id=\"form".$x."\" style=\"display:none;text-align:center;vertical-align:middle;\" ".style_cherche("","pop","couleur")."><img src=\"images/loader/ajax-loader.gif\" style=\"margin-top:15px;vertical-align:middle;\"></div>";
  echo "</td>\n";
  echo "</tr>";
  echo "</table>\n";
}

function module_icone($x){
  $y = false;
  if(isset($_SESSION["modules"]["icone"][$x]) && $_SESSION["modules"]["icone"][$x] !=""){
    $y = $_SESSION["modules"]["icone"][$x];
  }else{
    if($result = mysql_query("select * from modules where type_modules='module' && icones_modules !='' order by nom_modules asc")){
      while ($ligne = @mysql_fetch_array($result)){
        $_SESSION["modules"]["icone"][$ligne["id_modules"]] = $ligne["icone_modules"];
        $_SESSION["modules"]["icone"][$ligne["nom_modules"]] = $ligne["icone_modules"];
      }
      if(isset($_SESSION["modules"]["icone"][$x]) && $_SESSION["modules"]["icone"][$x] !=""){$y = $_SESSION["modules"]["icone"][$x];}
    }    
  }
  return $y;
}

function modules_droits(){
  if(isset($_SESSION["modules"])){unset($_SESSION["modules"]);}
  if($result = mysql_query("select * from droits where type_droits='module' order by nom_module asc")){
    while ($ligne = @mysql_fetch_array($result)){
      if($ligne["type_droits"] == "module"){$_SESSION["modules"][$ligne["valeur_droits"]][$ligne["nom_module"]] = $ligne["id_droits"];}
    }
  }
  if($result = mysql_query("select * from modules where type_modules='module' order by nom_modules asc")){
    while ($ligne = mysql_fetch_array($result)){
      if($ligne["icone_modules"]!=""){
        $_SESSION["modules"]["icone"][$ligne["id_modules"]] = $ligne["icone_modules"];
        $_SESSION["modules"]["icone"][$ligne["nom_modules"]] = $ligne["icone_modules"];
      }
      $_SESSION["modules"]["nom"][$ligne["nom_modules"]] = $ligne["nom_modules"];
      $_SESSION["modules"]["info"][$ligne["nom_modules"]] = $ligne["info_modules"];
    }
  }  
}

function module_creation($module){
  if($module != ""){
 
    if(isset($_SESSION["modulerepertoire"]) && $_SESSION["modulerepertoire"] == "oui"){
      mkdir("../scripts/modules/".$module);
      unset($_SESSION["modulerepertoire"]);
    }
  
    if(isset($_SESSION["moduletable"]) && $_SESSION["moduletable"] == "oui"){
      table_creation($module);
      unset($_SESSION["moduletable"]);
    }
  
    if(!file_exists("../scripts/modules/".$module."/index.php")){
      $Fnm = "../scripts/modules/".$module."/index.php";
      $inF = fopen($Fnm,"w");
      $texte = "<"."?php"."\n";
      $texte .= "if(file_exists(\"../../securite.php\")){include(\"../../securite.php\");}";
      $texte .= "\n"."?".">";
      fwrite($inF,$texte);
      fclose($inF);
      unset($texte);
    }
  
    $champs = "`id_modules`";
    $valeurs = "''";
    $r = mysql_query("SHOW COLUMNS FROM modules");
    if (mysql_num_rows($r) > 0) {
      while ($row = mysql_fetch_array($r)) {
        if(is_string($row[0]) && $row[0] != "id_modules"){
          $champs .= ",`".$row[0]."`";
          if($row[0] == "nom_modules"){$valeurs .= ",'".$module."'";}
          elseif($row[0] == "type_modules"){$valeurs .= ",'module'";}
          else{$valeurs .= ",''";}
        }
      }
    }else{
      $_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Modules 001 !";
    }
    if(!$res = mysql_query("INSERT INTO `modules` (".$champs.") VALUES (".$valeurs.");")){
      $_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Modules 002!";
    }else{
      $_SESSION["alerte"] .= "<p>Demande de cr&eacute;ation de module : <br>Module ".ucfirst($module)." cr&eacute;&eacute; ! (<i>".date_heure()."</i>)</p><br>";
    }
  }
  unset($_SESSION["creationmodule"]);
  unset($module);
}

function module_supprimer(){
  connexionmysql();
  $kill = mysql_query("DROP TABLE IF EXISTS `".$_SESSION["supprimermodule"]."`;");
  if (!$kill) {$_SESSION["alerte"] .= 'Erreur: ' . mysql_error() . "<br />\n";}
  repertoire_supprimer("../scripts/modules/".$_SESSION["supprimermodule"]);
  $sql = "delete from modules where id_modules='".$_SESSION["supprimermoduleid"]."'";
  $result = @mysql_query($sql);  
  $sql = "delete from droits where id_module='".$_SESSION["supprimermoduleid"]."'";
  $result = @mysql_query($sql);
}

function table_droits($table){
  $x = false;
  $sql = "select * from droits where type_droits='table'";
  if($result = mysql_query($sql)){
    while ($ligne = mysql_fetch_array($result)){
      if($ligne["nom_droits"] != "droits"){
        $nom[$ligne["id_droits"]] = $ligne;
      }else{if($ligne["nom_table"] == $table){$droit[$ligne["id_droits"]] = $ligne;}}
    }
    @reset($nom);
    while(list(,$vnom) = @each($nom)){
      @reset($droit);
      while(list(,$vdroit) = @each($droit)){
        if($vnom["id_droits"] == $vdroit["valeur_droits"]){$x[$vnom["id_droits"]] = $vdroit["id_droits"];}
      }  
    }
  }
  return $x;
}

function champs_liste($table){
  if($result = mysql_query("SHOW FULL COLUMNS FROM ".$table)){
    while($ligne = mysql_fetch_assoc($result)){$x[$ligne["Field"]] = $ligne['Type'];}
    return $x;
  }
}

function champs_titre($table){
  if($result = mysql_query("SHOW FULL COLUMNS FROM ".$table)){
    while($ligne = mysql_fetch_assoc($result)){$x[$ligne["Field"]] = $ligne['Comment'];}
    return $x;
  }
}

function champs_droits($table){
  $x = false;
  $sql = "select * from droits where type_droits='champs'";
  if($result = mysql_query($sql)){  
    while ($ligne = mysql_fetch_array($result)){
      if($ligne["nom_droits"] != "droits"){
        $nom[$ligne["id_droits"]] = $ligne;
      }else{
        if($ligne["nom_table"] == $table){$droit[$ligne["id_droits"]] = $ligne;}
      }
    }  
    @reset($nom);
    while(list(,$vnom) = @each($nom)){
      @reset($droit);
      while(list(,$vdroit) = @each($droit)){
        if(@$vnom["id_droits"] == @$vdroit["valeur_droits"]){
          $x[$vdroit["nom_champs"]][$vnom["id_droits"]] = $vdroit["id_droits"];
        }
      }  
    }
  }
  return $x;
}

function taille_fichier($fichier){
  $size=filesize($fichier);
  $unite = array('B','KB','MB','GB');
  @$taille = round(@$size/pow(1024,($i=floor(log(@$size,1024)))),2).' '.@$unite[$i];
  return "<i style=\"font-size:10px;\">".$taille." - ".date("d/m/Y H:i", filemtime($fichier))."</i>";
}

function ico_voir($nom){
  $temp = "<img src=\"".$_SESSION["ico"]["voir"]."\" title=\"Afficher & Masquer\" onclick=\"voir('".$nom."');\" class=\"module\">";
  return $temp;
}

function ico_supprimer($val,$table){
  $temp = "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=effaceligne&effaceligne=".$val["id_".$table]."\" title=\"Supprimer !\n\nAttention !\nCette action est d&eacute;finitive !\"><img src=\"".$_SESSION["ico"]["supprimer"]."\" class=\"module\"></a>";
  $temp .= "<span>&nbsp;|&nbsp;</span>";
  return $temp;
}

function ico_termine($ligne,$table){
  if(isset($ligne["etat_".$table]) && $ligne["etat_".$table]=="t"){
    $temp = "<a href=\"".$_SESSION["lien"]."?action=";
    $temp .= "annuleterminer&annuleterminer=".$ligne["id_".$table];
    $temp .= "&table=".$table;
    $temp .= "\" title=\"Annuler Terminer\">";
    $temp .= "<img src=\"".$_SESSION["ico"]["a_terminer"]."\" class=\"module\">";
    $temp .= "</a>"; 
  }else{
    $temp = "<a href=\"".$_SESSION["lien"]."?action=";
    $temp .= "terminer&terminer=".$ligne["id_".$table];
    $temp .= "&table=".$table;
    $temp .= "\" title=\"Terminer !\">";
    $temp .= "<img src=\"".$_SESSION["ico"]["terminer"]."\" class=\"module\">";
    $temp .= "</a>";  
  }
  return $temp;
}

function ico_hs($ligne,$table){
  if(isset($ligne["etat_".$table]) && $ligne["etat_".$table]=="hs"){
    $temp = "<a href=\"".$_SESSION["lien"]."?action=";
    $temp .= "annulehs&hs=".$ligne["id_".$table];
    $temp .= "&table=".$table;
    $temp .= "\" title=\"Annuler Hors Service !\">";
    $temp .= "<img src=\"".$_SESSION["ico"]["hs"]."\" class=\"module\">";
    $temp .= "</a>";  
  }else{
    $temp = "<a href=\"".$_SESSION["lien"]."?action=hs";
    $temp .= "&hs=".$ligne["id_".$table];
    $temp .= "&table=".$table;
    $temp .= "\" title=\"Signaler un lien Hors Service !\">";
    $temp .= "<img src=\"".$_SESSION["ico"]["hs"]."\" class=\"module\">";
    $temp .= "</a>";
  }
  return $temp;
}

function ico_module_preferences($module){
  if(file_exists("scripts/modules/".$module."/preferences.php") && utilisateur($_SESSION["userid"])){
    echo "<a title=\"Pr&eacute;f&eacute;rences\" href=\"".$_SESSION["lien"]."?page=".$module."&mpage=preferences\"><img src=\"".$_SESSION["ico"]["preferences"]."\" class=\"module\"></a>";
  }
}
function ico_module_aide($module){
  if(file_exists("scripts/modules/".$module."/aide.php") && utilisateur($_SESSION["userid"])){
    echo "<a title=\"Aide\" href=\"".$_SESSION["lien"]."?page=".$module."&mpage=aide\"><img src=\"".$_SESSION["ico"]["aide"]."\" class=\"module\"></a>";
  }
}

function ico_module_actualite($module){
  if(file_exists("scripts/modules/".$module."/actualite.php") && utilisateur($_SESSION["userid"])){
    echo "<a title=\"Actualit&eacute;\" href=\"".$_SESSION["lien"]."?page=".$module."&mpage=actualite\"><img src=\"".$_SESSION["ico"]["actualite"]."\" class=\"module\"></a>";
  }
}function ico_module_information($module){
  if(file_exists("scripts/modules/".$module."/information.php") && utilisateur($_SESSION["userid"])){
    echo "<a title=\"Information\" href=\"".$_SESSION["lien"]."?page=".$module."&mpage=information\"><img src=\"".$_SESSION["ico"]["information"]."\" class=\"module\"></a>";
  }
}
function ico_modifier($table,$sid){
  $x = style_cherche('',$table,'icone');
  if ($x == ""){$x = "<img src=\"".$_SESSION["ico"]["modifier"]."\" class=\"module\">";}
  $temp = "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=".$table."&acte=formulaire&formulaire=modifier&modifier=".$sid."','popup');\">".$x."</a>";
  return $temp;
}

function ico_archive($val,$table){
  if(isset($val["etat_".$table]) && $val["etat_".$table]=="a"){
    $temp = "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=restaurer&restaurer=".$val["id_".$table]."\" title=\"Restaurer !\"><img src=\"".$_SESSION["ico"]["restaurer"]."\" class=\"module\"></a>";
  }else{
    $temp = "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=supprime&supprime=".$val["id_".$table]."\" title=\"Archiver !\"><img src=\"".$_SESSION["ico"]["archiver"]."\" class=\"module\"></a>";
  }
  return $temp;
}

function ico_effacer($sid,$table){
  $temp = "<a href=\"".$_SESSION["lien"]."?table=".$table."&action=effaceligne&effaceligne=".$sid."\" title=\"Supprimer !\n\nAttention !\nCette action est d&eacute;finitive !\"><img src=\"".$_SESSION["ico"]["supprimer"]."\" class=\"module\" id=\"i10\"></a>";
  $temp .= "<span>&nbsp;|&nbsp;</span>";
  return $temp;
}

function ico_repondre($val,$table){
  $temp = "<a title=\"Répondre\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?table=".$table."&acte=formulaire&formulaire=repondre&repondre=".$val["expediteur_messagerie"]."&origine=".$val["id_messagerie"]."','surpopup');\"><img src=\"".$_SESSION["ico"]["droite"]."\" class=\"module\"></a>";
  return $temp;
}

function table_creation($x){
  $z = "
  CREATE TABLE IF NOT EXISTS `".$x."` (
  `id_".$x."` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant',
  `nom_".$x."` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Nom',
  `type_".$x."` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Type',
  `id_societe` bigint(20) unsigned NOT NULL,
  `id_groupe` bigint(20) unsigned NOT NULL,
  `id_categorie` bigint(20) unsigned NOT NULL,
  `etat_".$x."` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `debut_".$x."` datetime NOT NULL,
  `fin_".$x."` datetime NOT NULL,
  `recurrence_".$x."` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `horloge_".$x."` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `info_".$x."` longtext COLLATE utf8_unicode_ci NOT NULL,
  `id_user` bigint(20) unsigned NOT NULL,
  `lien_".$x."` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `icone_".$x."` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `image_".$x."` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fichier_".$x."` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id_style` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id_".$x."`),
  KEY `nom_".$x."` (`nom_".$x."`),
  KEY `type_".$x."` (`type_".$x."`),
  KEY `id_user` (`id_user`),
  KEY `id_societe` (`id_societe`),
  KEY `id_groupe` (`id_groupe`),
  KEY `id_categorie` (`id_categorie`),
  KEY `etat_".$x."` (`etat_".$x."`),
  KEY `lien_".$x."` (`lien_".$x."`),
  KEY `debut_".$x."` (`debut_".$x."`),
  KEY `fin_".$x."` (`fin_".$x."`),
  KEY `recurrence_".$x."` (`recurrence_".$x."`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table ".ucfirst($x)."' AUTO_INCREMENT=1 ;
  ";
  $result = mysql_query($z);
  if ($result) {
    $_SESSION["alerte"].="<p>Cr&eacute;ation r&eacute;ussie de la table ".$x;
  }else{
    $_SESSION["alerte"].="<p>Anomalie lors de la cr&eacute;ation de la table ".$x;
  }
}

function valeurs_session($x){
  $z = "";
  while (list($k, $v) = @each($x)){
    if(!is_array($k)){
      $z .= "{";
      $z .= $k." = ";
      if(!is_array($v)){
        $z .= $v;
      }else{
        valeurs_session($v);
      }
      $z .= "}";
    }else{
      valeurs_session($k);
    }
  }
  return $z;
}

function creation_indexphp($x){
  $target = "fichiers/".$x."/index.php";
  $fp = fopen($target, 'w');
  $lien = "/scripts/securite.php";
  $texte ="<";
  $texte .="?php ";
  $texte .="if(file_exists(\"".$lien."\"))";
  $texte .="{include(\"".$lien."\")";
  $texte .=";}";
  $texte .=" ?";
  $texte .=">";
  fputs($fp, $texte);
  fclose($fp);          
}

function les_enfants_liste($pid){
  $sql = "select id_".$_SESSION["table"].",id_lien from ".$_SESSION["table"]." where id_lien='".$pid."'";   
  if($result = mysql_query($sql)){
  while ($ligne = mysql_fetch_array($result)){       
    $liste[$ligne["id_".$_SESSION["table"]]] = $ligne["id_".$_SESSION["table"]];
    les_enfants_liste($ligne["id_".$_SESSION["table"]]);
  }
  return @$liste;
  }
}

function les_enfants($pid,$table){
  if(!isset($_SESSION["enfants"]) or !is_array($_SESSION["enfants"])){$_SESSION["enfants"] = array("0","0");}
  $sql = "select id_".$table.",lien_".$table." from $table where lien_".$table."='".$pid."'";
  if($result = mysql_query($sql)){
    while ($ligne = mysql_fetch_array($result)){
      array_push($_SESSION["enfants"], $ligne["id_".$table]);
      les_enfants($ligne["id_".$table],$table);
    }
  }
  return str_pad((count($_SESSION["enfants"])-2), 4, "0", STR_PAD_LEFT);
}

function les_parents($pid,$table){
  if(!isset($_SESSION["parents"]) or !is_array($_SESSION["parents"])){$_SESSION["parents"] = array("0","0");}
  $sql = "select id_".$table.",lien_".$table." from $table where id_".$table."='".$pid."'";
  if($result = mysql_query($sql)){
    while ($ligne = mysql_fetch_array($result)){
      array_push($_SESSION["parents"], $ligne["id_".$table]);
      les_parents($ligne["lien_".$table],$table);
    }
  }
  return str_pad((count($_SESSION["parents"])-2), 4, "0", STR_PAD_LEFT);
}

function existe_id_lien($lien,$table){
  $sql = "select id_".$table.",lien_id from $table where id_".$table."='".$lien."'";   
  if($result = mysql_query($sql)){  
    $ligne = mysql_fetch_array($result);
  }
  $sql = "select id_".$table." from $table where id_".$table."='".@$ligne["id_lien_".$table]."' and etat =''";
  if($result = mysql_query($sql)){  
    if($ligne = @mysql_fetch_array($result)){return true;}else{return false;}
  }
}

function est_archive_id_lien($lien,$table){
  $sql = "select id_".$table.",id_lien_".$table." from $table where id_".$table."='".$lien."'";   
  if($result = mysql_query($sql)){  
    @$ligne = mysql_fetch_array($result);
  }
  $sql = "select id_".$table." from $table where id_".$table."='".@$ligne["id_lien_".$table]."' and etat !=''";
  if($result = mysql_query($sql)){  
    if($ligne = @mysql_fetch_array($result)){return true;}else{return false;}
  }
}

function email_validation($x){
  //if (filter_var($x,FILTER_VALIDATE_EMAIL)) {
    return True;
  //}else{
    //return False;
  //}
}

function email_envoyer(){
  if($_SESSION["email"]["email"] == ""){
    $_SESSION["email"]["email"] = "rouaix.daniel@wanadoo.fr";
    $_SESSION["email"]["titre"] = "Alerte Anomalie";
  }
  $headers  ="From:\"www.rouaix.net\"<webmaster@rouaix.net>"."\r\n";
  //$headers .="To:<".$_SESSION["email"]["email"].">"."\r\n";
  $headers .="Content-Type:text/plain; charset=\"utf-8\""."\r\n"; 
  $headers .="Content-Transfer-Encoding:8bit"."\r\n"; 
  $headers .="X-Priority:3"."\r\n";  
  $headers .="Reply-To:webmaster@rouaix.net"."\r\n";
  //$headers .="Cc:webmaster@monassistant.eu"."\r\n"; 
  $headers .="Bcc:daniel@rouaix.com"."\r\n"; 
  @mail($_SESSION["email"]["email"],$_SESSION["email"]["titre"], $_SESSION["email"]["message"], $headers);
  //$_SESSION["alerte"] .= "Email envoy&eacute; (".$_SESSION["email"]["email"].")";     
  unset($_SESSION["email"]);
  $_SESSION["alerte"] .= "Message envoy&eacute; !";
}

function validation_email($x){
  //if (filter_var($x,FILTER_VALIDATE_EMAIL)) {
    return True;
  //}else{
    //return False;
  //}
}

function taille_convertir($size)
{
    $unite = array('B','KB','MB','GB');
    return round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unite[$i];
}

function couleur_rgb2html($r, $g=-1, $b=-1)
{
    if (is_array($r) && sizeof($r) == 3)
        list($r, $g, $b) = $r;

    $r = intval($r); $g = intval($g);
    $b = intval($b);

    $r = dechex($r<0?0:($r>255?255:$r));
    $g = dechex($g<0?0:($g>255?255:$g));
    $b = dechex($b<0?0:($b>255?255:$b));

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    return ''.$color;
}

function nombre_longueur($x,$long){
  return str_pad($x, $long, "0", STR_PAD_LEFT);
}

function image_resize($image,$max){
   $taille = getimagesize("$image");

   $hauteur = $taille[1];
   $largeur = $taille[0];

   if($largeur > $hauteur){
      if($largeur > $max){
         $largeur=$max;
         $hauteur="";
      }
   }else{
      if($hauteur > $max){
         $hauteur=$max;
         $largeur="";
      }
   }

   $x[0]=$largeur;
   $x[1]=$hauteur;

   return $x;
}

function verifier_date($date){
  $temp = explode("/",$date);  
  if($temp[0] > 31){$temp[0] = date("j",$_SESSION["jour"]);}
  if($temp[0] < 1){$temp[0] = date("j",$_SESSION["jour"]);}
  if($temp[1] < 1){$temp[1] = date("n",$_SESSION["jour"]);}
  if($temp[1] > 12){$temp[1] = date("n",$_SESSION["jour"]);}
  if($temp[2] < 1){$temp[2] = date("Y",$_SESSION["jour"]);}      
  $x = $temp[0]."/".$temp[1]."/".$temp[2];      
  if(strlen($date) != 10){$x = date("d",$_SESSION["jour"])."/".date("m",$_SESSION["jour"])."/".date("Y",$_SESSION["jour"]);}
  return $x;
}

function verifier_heure($heure){  
  $temp = explode(":",$heure);
  if($temp[0] > 24){$temp[0] = "24";}
  if($temp[0] < 0){$temp[0] = "00";}  
  if($temp[1] > 59){$temp[1] = "59";}
  if($temp[1] < 0){$temp[1] = "00";}
  $x = $temp[0].":".$temp[1];      
  if(strlen($heure) != 5){$x = date("G",$_SESSION["jour"]).":".date("i",$_SESSION["jour"]);}
  return $x;  
}

function verifier_debutfin(){
  if(isset($_SESSION["form_date_debut_".$_SESSION["table"]])){
    if($_SESSION["form_date_debut_".$_SESSION["table"]] == " "){$_SESSION["form_date_debut_".$_SESSION["table"]] = 0;}
    if($_SESSION["form_date_debut_".$_SESSION["table"]] <> 0){$_SESSION["form_date_debut_".$_SESSION["table"]] = verifier_date($_SESSION["form_date_debut_".$_SESSION["table"]]);}
  }
  if(isset($_SESSION["form_date_fin_".$_SESSION["table"]])){
    if($_SESSION["form_date_fin_".$_SESSION["table"]] == " "){$_SESSION["form_date_fin_".$_SESSION["table"]] = 0;}
    if($_SESSION["form_date_fin_".$_SESSION["table"]] <> 0){$_SESSION["form_date_fin_".$_SESSION["table"]] = verifier_date($_SESSION["form_date_fin_".$_SESSION["table"]]);}
  }
  if(isset($_SESSION["form_heure_debut_".$_SESSION["table"]])){
    if($_SESSION["form_heure_debut_".$_SESSION["table"]] == " "){$_SESSION["form_heure_debut_".$_SESSION["table"]] = 0;}
    if($_SESSION["form_heure_debut_".$_SESSION["table"]] <> 0){$_SESSION["form_heure_debut_".$_SESSION["table"]] = verifier_heure($_SESSION["form_heure_debut_".$_SESSION["table"]]);}
  }
  if(isset($_SESSION["form_heure_fin_".$_SESSION["table"]])){
    if($_SESSION["form_heure_fin_".$_SESSION["table"]] == " "){$_SESSION["form_heure_fin_".$_SESSION["table"]] = 0;}
    if($_SESSION["form_heure_fin_".$_SESSION["table"]] <> 0){$_SESSION["form_heure_fin_".$_SESSION["table"]] = verifier_heure($_SESSION["form_heure_fin_".$_SESSION["table"]]);}
  }
  if(isset($_SESSION["form_date_debut_".$_SESSION["table"]]) && isset($_SESSION["form_date_fin_".$_SESSION["table"]])){
    if($_SESSION["form_date_debut_".$_SESSION["table"]] <> 0 && $_SESSION["form_date_fin_".$_SESSION["table"]] <> 0){
      $xx = verifier_date_debutfin($_SESSION["form_date_debut_".$_SESSION["table"]],$_SESSION["form_date_fin_".$_SESSION["table"]]);
      $_SESSION["form_date_debut_".$_SESSION["table"]] = $xx[0];
      $_SESSION["form_date_fin_".$_SESSION["table"]] = $xx[1];
      unset($xx);
    }
  }
  
  if(isset($_SESSION["form_heure_debut_".$_SESSION["table"]]) && isset($_SESSION["form_heure_fin_".$_SESSION["table"]])){
    if($_SESSION["form_heure_debut_".$_SESSION["table"]] <> 0 && $_SESSION["form_heure_fin_".$_SESSION["table"]] <> 0){
      $xx = verifier_heure_debutfin($_SESSION["form_heure_debut_".$_SESSION["table"]],$_SESSION["form_heure_fin_".$_SESSION["table"]]);
      $_SESSION["form_heure_debut_".$_SESSION["table"]] = $xx[0];
      $_SESSION["form_heure_fin_".$_SESSION["table"]] = $xx[1];
      unset($xx);
    }
  }

  if(isset($_SESSION["form_date_debut_".$_SESSION["table"]])){
    if($_SESSION["form_date_debut_".$_SESSION["table"]] == 0){
      $_SESSION["form_debut_".$_SESSION["table"]] = " ";
      unset($_SESSION["form_date_debut_".$_SESSION["table"]]);
    }else{
      $xx = explode("/",$_SESSION["form_date_debut_".$_SESSION["table"]]);
      $_SESSION["form_debut_".$_SESSION["table"]] = $xx[2]."-".$xx[1]."-".$xx[0];
      unset($_SESSION["form_date_debut_".$_SESSION["table"]]);
      unset($xx);
    }
    if(isset($_SESSION["form_heure_debut_".$_SESSION["table"]])){
      if($_SESSION["form_heure_debut_".$_SESSION["table"]] == 0){
        $_SESSION["form_debut_".$_SESSION["table"]] .= " ";
        unset($_SESSION["form_heure_debut_".$_SESSION["table"]]);
      }else{
        $xx = explode(":",$_SESSION["form_heure_debut_".$_SESSION["table"]]);
        $_SESSION["form_debut_".$_SESSION["table"]] .= " ".$xx[0].":".$xx[1];
        unset($_SESSION["form_heure_debut_".$_SESSION["table"]]);
        unset($xx);
      }
    }
  }
  
  if(isset($_SESSION["form_date_fin_".$_SESSION["table"]])){
    if($_SESSION["form_date_fin_".$_SESSION["table"]] == 0){
      $_SESSION["form_fin_".$_SESSION["table"]] = " ";
      unset($_SESSION["form_date_fin_".$_SESSION["table"]]);
    }else{
      $xx = explode("/",$_SESSION["form_date_fin_".$_SESSION["table"]]);
      $_SESSION["form_fin_".$_SESSION["table"]] = $xx[2]."-".$xx[1]."-".$xx[0];
      unset($_SESSION["form_date_fin_".$_SESSION["table"]]);
      unset($xx);
    }
    if(isset($_SESSION["form_heure_fin_".$_SESSION["table"]])){
      if($_SESSION["form_heure_fin_".$_SESSION["table"]] == 0){
        $_SESSION["form_fin_".$_SESSION["table"]] .= " ";
        unset($_SESSION["form_heure_fin_".$_SESSION["table"]]);
      }else{
        $xx = explode(":",$_SESSION["form_heure_fin_".$_SESSION["table"]]);
        $_SESSION["form_fin_".$_SESSION["table"]] .= " ".$xx[0].":".$xx[1];
        unset($_SESSION["form_heure_fin_".$_SESSION["table"]]);
        unset($xx);
      }
    }
  }
  
}

function verifier_date_debutfin($d,$f){
  $xdebut = explode("/",$d);
  $xdatedebut = mktime(0,0,0,$xdebut[1],$xdebut[0],$xdebut[2]);  
  $xfin = explode("/",$f);
  $xdatefin = mktime(0,0,0,$xfin[1],$xfin[0],$xfin[2]);  
  if($xdatedebut <= $xdatefin){
    $x[0]= $d;
    $x[1]= $f;   
  }else{
    $x[0]= $d;
    $x[1]= $d;  
  }
  return $x;
}

function verifier_heure_debutfin($d,$f){
  $xdebut = explode(":",$d);
  $xfin = explode(":",$f);
  
  if($xdebut[0] > $xfin[0]){$xfin[0] = $xdebut[0];}
  
  if($xdebut[0] == $xfin[0]){
    if($xdebut[1] > $xfin[1]){$xfin[1] = $xdebut[1];}
  }
  
  $x[0]= $xdebut[0].":".$xdebut[1];
  $x[1]= $xfin[0].":".$xfin[1];
  return $x;  
}

function erreurs(){
  $page = $_SESSION["erreur"];
  // On définit le type de l'erreur
  if($page != ""){
    if(!isset($_SESSION["alerte"])){$_SESSION["alerte"] = "";}
    $champs = "`id_erreurs`";
    $valeurs = "''";
    $l = array("nom_erreurs","id_user","horloge_erreurs","info_erreurs");
    $r = mysql_query("SHOW COLUMNS FROM erreurs");
    if (mysql_num_rows($r) > 0) {
      while ($row = mysql_fetch_array($r)) {
        if(is_string($row[0]) && $row[0] != "id_erreurs"){
          $champs .= ",`".$row[0]."`";
          if(in_array($row[0], $l)){
            if($row[0] == "nom_erreurs"){
              $valeurs .= ",'Erreur page ".ucfirst($page);
              //if(isset($_SESSION["voir"]) && $_SESSION["voir"] != ""){$valeurs .= " [".$_SESSION["voir"]."]";}
              //if(isset($_SESSION["inc"]) && $_SESSION["inc"] != ""){$valeurs .= " [".$_SESSION["inc"]."]";}
              //if(isset($_SESSION["montre"]) && $_SESSION["montre"] != ""){$valeurs .= " [".$_SESSION["montre"]."]";}
              $valeurs .= "'";
            }
            elseif($row[0] == "type_erreurs"){$valeurs .= ",''";}
            elseif($row[0] == "id_user"){$valeurs .= ",'".@$_SESSION["userid"]."'";}
            elseif($row[0] == "horloge_erreurs"){$valeurs .= ",'".date_heure()."'";}
            elseif($row[0] == "info_erreurs"){
              $x = "";
              //if(isset($_SESSION)){$x = serialize($_SESSION)."\n";}
              $x .= "\n";
              $x .= "ip = ".getenv("REMOTE_ADDR")."\n";
              $x .= "navigateur = ".getenv("HTTP_USER_AGENT")."\n";
              $x .= "origine = ".getenv("HTTP_REFERER")."\n";
              $x .= "langues = ".getenv("HTTP_ACCEPT_LANGUAGE")."\n";
              $x .= "script = ".getenv("PHP_SELF")."\n";
              $x .= "\n";
              if(utilisateur(@$_SESSION["userid"])){
                while (list($key, $val) = @each($_SESSION)){
                  if(!is_array($key)){
                    $x .= "[";
                    $x .= $key." = ";
                    if(!is_array($val)){
                      $x .= $val;
                    }else{
                      $x .= valeurs_session($val);
                    }
                    $x .= "]\n";
                  }else{$x .= valeurs_session($key);}
                }
              }
              $valeurs .= ",'".$x."'";
            }
          }else{$valeurs .= ",''";}
        }
      }
    }else{$_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Erreur 001 !";}
    if(!$res = mysql_query("INSERT INTO `erreurs` (".$champs.") VALUES (".$valeurs.");")){
      $_SESSION["alerte"] .= "<p>".mysql_errno().": ".mysql_error()."<p>Anomalie Erreur 002!";
    }else{
      $_SESSION["alerte"] .= "<p>Demande de correction : <br> Message envoy&eacute; ! (<i>".date_heure()."</i>)</p><br>";
    }
  }
}
?>
