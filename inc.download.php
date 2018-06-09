<?php

if(!isset($_SESSION)){session_start();}
//if (file_exists("securite.php")){include("securite.php");}
if(count($_GET)){
   while (list($key, $val) = each($_GET)){
      if($val!=""){$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');}else{unset($_SESSION[$key]);}
   }
}

if(count($_POST)){
   while (list($key, $val) = each($_POST)){
      if($val!=""){$_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8');}else{unset($_SESSION[$key]);}
   }
}

if(file_exists("inc.config.php")){include("inc.config.php");}

if(isset($_SESSION["action"])){
  if($_SESSION["action"]=="fdownload"){
    $target = "";
    //if($_SESSION["fichier_type"]=="carte"){$target = "../fichiers/cartes/";}
    //else if($_SESSION["fichier_type"]=="fichier"){$target = "../fichiers/fichiers/fichiers/";}
    //else if($_SESSION["fichier_type"]=="doc"){$target = "../fichiers/fichiers/fichiers/documents/";}
    //else if($_SESSION["fichier_type"]=="userphoto"){$target = "../fichiers/users/photos/";}
    //else if($_SESSION["fichier_type"]=="x"){$target = "../".$_SESSION["fichier_dir"];}
     $target = "../".$_SESSION["dir"];
    download_fichier($_SESSION["fdownload"], $target);

    unset($target);
    unset($_SESSION["fdownload"]);
    unset($_SESSION["fichier_type"]);
    unset($_SESSION["fichier_dir"]);
    unset($_SESSION["action"]);
  }
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Download</title>
<meta name="keywords" content="Download" />
<meta name="description" content="ROUAIX.COM Download" />

<?php

function download_fichier($x, $chemin){
  header("Content-disposition: attachment; filename=$x");
  header("Content-Type: application/force-download");
  header("Content-Transfer-Encoding: application/octet-stream \n"); // Surtout ne pas enlever le \n
  header("Content-Length: ".filesize($chemin . $x));
  header("Pragma: no-cache");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
  header("Expires: 0");
  readfile($chemin . $x);
  exit();

}



?>
<script language="JavaScript">
function fermer() {
opener=self;
self.close();
}
</script>