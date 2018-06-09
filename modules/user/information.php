<?php
if(!isset($_SESSION)){session_start();}
//if (file_exists("../securite.php")){include("../securite.php");}
if(isset($_SESSION["userid"])){
  if(isset($_SESSION["userinfo"])){
   $sql = "select * from user where id_user=".$_SESSION["userinfo"]."";   
   if($result = mysql_query($sql)){
   while ($ligne = mysql_fetch_array($result)){
      while(list($key,$val) = each($ligne)){
        //$_SESSION["dbdata"][$key] = html_entity_decode($val, ENT_QUOTES, 'UTF-8');
        $_SESSION["dbdata"][$key] = $val;  
      }
   }
   unset($sql);
   unset($ligne);
  }
  }
?>
<table style="border-collapse:separate;border-spacing:5px;width:100%;">
<tr>
<td style="width:300px;">
<?php
$ext = array("png","jpg","gif");
reset($ext);
while(list(,$val) = each($ext)){
  if (file_exists("fichiers/users/photos/user_".$_SESSION["userid"].".".$val)){
    $photo = "fichiers/users/photos/user_".$_SESSION["userid"].".".$val;
    $fichier = "user_".$_SESSION["userid"].".".$val;
    
if(isset($photo)){
  $l_max = 250;
  $t = getimagesize($photo);
  $largeur = $t[0];
  $hauteur = $t[1];
  unset($t);
  if($largeur > $l_max){
    $r = ($l_max / $largeur);
    $largeur = round($largeur * $r);
    $hauteur = round($hauteur * $r);
  }
  echo "<img src=\"".$photo."\" style=\"margin:5px;width:".$largeur."px;height:".$hauteur."px;border:1px solid #333;\">";
  echo "<a style=\"position:relative;z-index:2;left:-".round(($largeur / 2)+1)."px;top:-".round(($hauteur / 2)+1)."px;\" href=\"".$_SESSION["lien"]."?page=user&mpage=information&userinfo=".$_SESSION["userid"]."&action=effacefichier&doc=".$fichier."&dir=fichiers/users/photos/\" title=\"Supprimer !\nAttention, cette action est d&eacute;finitive !\">";
  echo "<img src=\"".$_SESSION["ico"]["supprimer"]."\" id=\"image10\">";
  echo "</a>\n<br />";
  unset($photo);
  unset($fichier);
  unset($hauteur);
  unset($largeur);
}    
  }
}

?>   
</td>

<td rowspan="2">

<table style="border-collapse:separate;border-spacing:5px;max-width:90%;">
<form enctype="multipart/form-data" method="post" action="<?php echo $_SESSION["lien"];?>">
<tr>
<td style="text-align:right;">Vous êtes</td>
<td style="text-align:center;"><?php
$sql = "select * from civilite where etat_civilite=''";   
if($result = mysql_query($sql)){
  echo "<select class=\"pop\" name=\"form_id_civilite\">\n";
  while ($ligne = mysql_fetch_array($result)){
    echo "<option value=\"".$ligne["id_civilite"]."\" ";
    if(isset($_SESSION["dbdata"]["id_civilite"]) && $_SESSION["dbdata"]["id_civilite"] == $ligne["id_civilite"]){echo "selected";}  
    echo ">".$ligne["nom_civilite"]." (".@$ligne["info_civilite"].")";
    echo "</option>\n";
  }
  echo "</select>\n";
  unset($temp);
  unset($sql);
  unset($ligne);
}
?></td>
</tr>
<tr>
<td style="text-align:right;">Identifiant de connexion</td>
<td style="text-align:center;"><input type="text" class="pop" name="form_login_user" value="<?php if(isset($_SESSION["dbdata"]["login_user"])){echo $_SESSION["dbdata"]["login_user"];}?>"></td>
</tr>
<tr>
<td style="text-align:right;">Email</td>
<td style="text-align:center;"><input class="pop" type="text" name="form_email_user" value="<?php if(isset($_SESSION["dbdata"]["email_user"])){echo $_SESSION["dbdata"]["email_user"];}?>"></td>
</tr>
<tr>
<td style="text-align:right;">Nom</td>
<td style="text-align:center;"><input class="pop" type="text" name="form_nom_user" value="<?php if(isset($_SESSION["dbdata"]["nom_user"])){echo $_SESSION["dbdata"]["nom_user"];}?>"></td>
</tr>
<tr>
<td style="text-align:right;">Prénom</td>
<td style="text-align:center;"><input class="pop" type="text" name="form_prenom_user" value="<?php if(isset($_SESSION["dbdata"]["prenom_user"])){echo $_SESSION["dbdata"]["prenom_user"];}?>"></td>
</tr>
<tr>
<td style="text-align:right;">Adresse</td>
<td style="text-align:center;"><textarea class="pop" name="form_adresse_user"><?php if(isset($_SESSION["dbdata"]["adresse_user"])){echo $_SESSION["dbdata"]["adresse_user"];}?></textarea></td>
</tr>
<tr>
<td style="text-align:right;">Code postal</td>
<td style="text-align:center;"><input class="pop" type="text" name="form_codepostal_user" value="<?php if(isset($_SESSION["dbdata"]["codepostal_user"])){echo $_SESSION["dbdata"]["codepostal_user"];}?>"></td>
</tr>
<tr>
<td style="text-align:right;">Ville</td>
<td style="text-align:center;"><input class="pop" type="text" name="form_ville_user" value="<?php if(isset($_SESSION["dbdata"]["ville_user"])){echo $_SESSION["dbdata"]["ville_user"];}?>"></td>
</tr>
<tr>
<td style="text-align:right;">Pays</td>
<td style="text-align:center;"><input class="pop" type="text" name="form_pays_user" value="<?php if(isset($_SESSION["dbdata"]["pays_user"])){echo $_SESSION["dbdata"]["pays_user"];}?>"></td>
</tr>
<tr>
<td style="text-align:right;">Téléphone mobile</td>
<td style="text-align:center;"><input class="pop" type="text" name="form_mobile_user" value="<?php if(isset($_SESSION["dbdata"]["mobile_user"])){echo $_SESSION["dbdata"]["mobile_user"];}?>"></td>
</tr>
<tr>
<td style="text-align:right;">
<input type="hidden" name="action" value="sauvedata">
<input type="hidden" name="table" value="user">
<input type="hidden" name="form_horloge_user" value="<?php echo date_heure();?>">
<input type="hidden" name="form_type_user" value="<?php if(isset($_SESSION["dbdata"]["type_user"])){echo $_SESSION["dbdata"]["type_user"];}else{echo "user";} ?>">
<input type="hidden" name="form_id_user" value="<?php if(isset($_SESSION["dbdata"]["id_user"])){echo $_SESSION["dbdata"]["id_user"];}?>">
</td>
<td style="text-align:center;">
<br><br><input type="image" src="<?php echo $_SESSION["ico"]["valider"];?>" id="i32" name="submit" title="Cliquez pour valider">
</td>
</tr>
</form>
</table> 
 
</td>
</tr>
<tr>
<td style="vertical-align:bottom;height:50%;">
<?php 
  echo "<label class=\"module\">Votre photo (au format png ou jpg ou gif)</label>";
  echo "<form method=\"POST\" id=\"centre\" action=\"".$_SESSION["lien"]."?page=user&mpage=information&userinfo=".$_SESSION["userid"]."\" enctype=\"multipart/form-data\">";
  echo "<input type=\"file\" name=\"fichier\" style=\"width:300px;\">";
  echo "<br><br><input type=\"image\" id=\"i32\" style=\"margin-left:5px;\" src =\"".$_SESSION["ico"]["valider"]."\" title=\"Cliquez pour valider\">";
  echo "<input type=\"hidden\" name=\"fichier_type\" value=\"userphoto\">";
  echo "<input type=\"hidden\" name=\"fichier_nom\" value=\"user_".$_SESSION["userid"]."\">";
  echo "<input type=\"hidden\" name=\"action\" value=\"fichierupload\">";
  echo "</form><br>\n";
?>
</td>
</tr>
</table>
<?php
unset ($_SESSION["inc"]);
unset ($_SESSION["userinfo"]);   
unset ($_SESSION["dbdata"]);
}
?>