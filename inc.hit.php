<?php
if (file_exists("securite.php")){include("securite.php");}


$verif = 0;
$ok = false;
$_SESSION["alerte"] .= "";
if(!isset($_SESSION["jour"]) or @$_SESSION["jour"]==""){$_SESSION["jour"] = mktime(0, 0, 0, date("m"), date("d"), date("Y"));}

session_id()


if(isset($_SESSION["userid"])){

}else{

}

$sql = "select * from hit where hit='".."'";
$result = mysql_query($sql);
while ($ligne = @mysql_fetch_array($result)){
  if($ligne != ""){
    if($ligne["ses"] == session_id()){      
      $ok = true;
      if($verif > 0){
        $sqlx = "delete from hit where id='".$ligne["id"]."'";
        $resultx = mysql_query($sqlx);
        @mysql_free_result($resultx);                        
      }else{
        $liste = "co='".$_SESSION["co"]."',horloge='".maintenant()."'";      
        $sqlz = "update hit set ".$liste." where id ='".$ligne["id"]."'";
        $resultz = mysql_query($sqlz);
        @mysql_free_result($resultz);
        $verif++;              
      } 
    }else{
      $y = maintenant();
      $x = $ligne["horloge"];
      $ecart = $y - $x;           
      if($ecart > 180){
        $sqly = "delete from hit where id='".$ligne["id"]."'";
        $resulty = mysql_query($sqly);
        @mysql_free_result($resulty);              
      }            
    }
  }  
}

if($ok == false){
  $xd = nouvelle_id();
  $sql  = "INSERT INTO hit(`id`)VALUES('".$xd."')";
  $result = mysql_query($sql);
    
  $liste = "id='".$xd."' ,co='".$_SESSION["co"]."',ses='".session_id()."',horloge='".maintenant()."'";
  $sql = "update hit set ".$liste." where id='".$xd."'";
  $result = mysql_query($sql);  
}

$_SESSION["visiteur"]["inconnu"] = 0;
$_SESSION["visiteur"]["connu"] = 0;
$_SESSION["visiteur"]["membre"] = 0;

$sql = "select * from hit where co='Visiteur'";
$result = mysql_query($sql);
$_SESSION["visiteur"]["inconnu"] = str_pad(mysql_num_rows($result), 3, "0", STR_PAD_LEFT);
@mysql_free_result($result);
$sql = "select * from hit where co!='Visiteur'";
$result = mysql_query($sql);
$_SESSION["visiteur"]["connu"] = str_pad(mysql_num_rows($result), 3, "0", STR_PAD_LEFT);
@mysql_free_result($result);
$sql = "select * from user";
$result = mysql_query($sql);
$_SESSION["visiteur"]["membre"] = str_pad(mysql_num_rows($result), 3, "0", STR_PAD_LEFT);
@mysql_free_result($result);

unset($_SESSION["co"]);

?>