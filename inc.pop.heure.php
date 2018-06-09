<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("securite.php")){include("securite.php");}
if(file_exists("inc.config.php")){include("inc.config.php");}

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
unset($_GET);
unset($_POST);


?>
<img class="fenetre" id="fermer" src="images/jpg/x.jpg" title="Fermer" onclick="javascript:voir('pop');"> 
<table cellpadding="0" cellspacing="0" border="0" style="width:100%;height:100%;">
<tr>
<td width="100%" height="100%" id="centre">

<form style="margin:10px;" enctype="multipart/form-data" method="post" action="index.php">

<table class="table" id="centre" style="width:400px;">
<?php
  for($xheure=0;$xheure < 24;$xheure ++) {
    $h = str_pad($xheure, 2, "0", STR_PAD_LEFT);
    echo "<tr>";
    echo "<td id=\"centre\"><b>".$h."</b> H</td>";
    for($xminute=0;$xminute < 60;$xminute += 5) {
      $m = str_pad($xminute, 2, "0", STR_PAD_LEFT);
      echo "<td id=\"centre\" style=\"cursor:pointer;\" onClick=\"setvaleurid('".$_SESSION["origine"]."','".$h.":".$m."');voir('pop');\" title=\"Cliquez pour choisir ".$h."h".$m."\">".$m."</td>";
    }
    echo "</tr>";  
  }
?>
</table>
</form>

</td>
</tr>
</table>
<?php
unset($_SESSION["origine"]);
?>