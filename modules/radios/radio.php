<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("../../securite.php")){include("../../securite.php");}

if(count($_GET)){
   while (list($key, $val) = each($_GET)){
      if($val!=""){ $_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8'); }else{unset($_SESSION[$key]);}
   }
}
if(count($_POST)){
   while (list($key, $val) = each($_POST)){
      if($val!=""){ $_SESSION[$key]= htmlentities($val,ENT_QUOTES,'UTF-8'); }else{unset($_SESSION[$key]);}
   }
}

unset($_GET);
unset($_POST);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//FR">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Rouaix (Radio)</title>
<meta name="keywords" content="Assistant, Gestion, Stock, Facturation, Agenda, Rendez-vous, Rdv, Radio">
<meta name="description" content="www.rouaix.com">
<meta name="Auteur" content="Copyright 2011 Daniel ROUAIX">
<script type="text/javascript">
<!--
function setvaleurid(des,valeur){
   document.getElementById(des).value = valeur;
}
//-->
</script>
</head>
<body style="color:#000000;background-color:#ffffff;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;overflow:auto;padding:0 0 0 0;">

<?php
$adresse = $_SESSION["lienradio"];
$image = $_SESSION["location"]."images/divers/casque_0010.png";

?>
<table cellpadding="0" cellspacing="0" border="0" style="width:100%;height:100%;">
<tr>
<td align="center" valign="middle" style="width:100%;height:100%;background-color:ffffff;">
<img src="<?php echo $image;?>" border="0" vspace="5" height="64px">
<p style="color:#666666;text-align:center;font-size:12px;font-weight:normal;margin:0 0 0 0;">Vous Ecoutez :<br><b style="color:#000000;font-size:14px;"><?php echo $_SESSION["titre"];?></b></p>
</td>
</tr>
<tr>
<td style="width:100%;height:44px;text-align:center;background-color:ffffff;border-top:1px solid #999999;">
<object classid="CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95"  style="left:0px:position:relative;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;"
codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112" 
type="application/x-oleobject" width="100%" height="100%" standby="Loading..." id="player">
<param name="FileName" value="<?php echo $adresse;?>">
<param name="ShowControls" value="1">
<param name="ShowAudioControls" value="1">
<param name="ShowPositionControls" value="0">
<param name="Volume" value="2">
<embed  src="<?php echo $adresse;?>" width="100%" height="100%" type="application/x-mplayer2" pluginspage = "http://www.microsoft.com/Windows/MediaPlayer/" controls="1" AudioControls="1" ShowPositionControls="0" Volume="2"></embed>
</object>
</td>
</tr>
</table>
</center>
<?php
unset($_SESSION["lienradio"]);
unset($_SESSION["radio"]);
unset($_SESSION["titre"]);
unset($adresse);
unset($image);
?>
</body>
</html>