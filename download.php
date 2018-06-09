<?php
if(!isset($_SESSION)){session_start();}

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
