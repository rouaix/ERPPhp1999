<?php
//if(file_exists("../../securite.php")){include("../../securite.php");}

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
              if(isset($_SESSION["voir"]) && $_SESSION["voir"] != ""){$valeurs .= " [".$_SESSION["voir"]."]";}
              if(isset($_SESSION["inc"]) && $_SESSION["inc"] != ""){$valeurs .= " [".$_SESSION["inc"]."]";}
              if(isset($_SESSION["montre"]) && $_SESSION["montre"] != ""){$valeurs .= " [".$_SESSION["montre"]."]";}
              $valeurs .= "'";
            }
            elseif($row[0] == "type_erreurs"){$valeurs .= ",''";}
            elseif($row[0] == "id_user"){$valeurs .= ",'".@$_SESSION["userid"]."'";}
            elseif($row[0] == "horloge_erreurs"){$valeurs .= ",'".date_heure()."'";}
            elseif($row[0] == "info_erreurs"){
              $x = "";
              //if(isset($_SESSION)){$x = serialize($_SESSION)."\n";}

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

?>