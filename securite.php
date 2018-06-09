<?php

$ipv = (getenv("HTTP_X_FORWARDED_FOR") ? getenv("HTTP_X_FORWARDED_FOR") : getenv("REMOTE_ADDR"));

$HTTP_REFERER = getenv("HTTP_REFERER");
$HTTP_HOST = getenv("HTTP_HOST");
$machine = getenv("HTTP_HOST");
  if ($machine == "127.0.0.1" or $machine == "localhost"  or $machine == "192.168.1.3"){
   $x = "http://".$machine."/";
} else {
   $x = "http://www.rouaix.com/";
}
if ( !mb_eregi($HTTP_HOST,$HTTP_REFERER) ) {
  if ($HTTP_REFERER == ""){
    $temp = "Favori";
  }else{
    $temp = $HTTP_REFERER;
  }
}else{ 
  $temp = "Ici";
}
if ($temp != "Ici"){
  //echo "<div style=\"background-color:#ffffff;border:1px solid #222222;\"><h2>";
  //echo "<center>".$ipv."<br>Merci de cliquer ci-dessous !<br>";
  //echo "<a href=\"".$x."\" title='Retour !'><img src='".$x."../images/png/hal9000.png' title='Retour !' border='0px' height='64px' style='vertical-align:middle;cursor:pointer;'></a>";
  //echo "</center></h2></div>";      
  @header("location:".$x);
  //die;
}

unset($ipv);
unset($temp);
?>