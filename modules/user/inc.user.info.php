<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("securite.php")){include("securite.php");}

if(isset($_SESSION["userid"])){
  if(isset($_SESSION["userinfo"])){
   $sql = "select * from user where id=".$_SESSION["userinfo"]."";   
   $result = mysql_query($sql);
   while ($ligne = mysql_fetch_array($result)){
      while(list($key,$val) = each($ligne)){
        //$_SESSION["dbdata"][$key] = html_entity_decode($val, ENT_QUOTES, 'UTF-8');
        $_SESSION["dbdata"][$key] = $val;  
      }
   }
   unset($sql);
   unset($ligne);
   mysql_free_result($result);
  }
?>
<center><form enctype="multipart/form-data" method="post" action="<?php echo $_SESSION["lien"];?>">
<table cellpadding="0" cellspacing="5" border="0">
<tr>
<td width="200px" style="text-align:right;">Vous êtes</td>
<td style="text-align:center;">
<?php
$sql = "select * from civilite where archive =''";   
$result = mysql_query($sql)or die("Erreur dans Civilite !");
echo "<select class=\"user\" id=\"large\" name=\"form_civilite\">";
while ($ligne = mysql_fetch_array($result)){
  $temp = html_entity_decode($ligne["civilite"], ENT_QUOTES, 'UTF-8');
  $titre = html_entity_decode($ligne["nom"], ENT_QUOTES, 'UTF-8');
  echo "<option value=\"".$temp."\" ";
  if(isset($_SESSION["dbdata"]["civilite"])&& $_SESSION["dbdata"]["civilite"]==$temp){echo "selected";}  
  echo ">".$temp." (".$titre.")";
  echo "</option>";
}
echo "</select>";
unset($temp);
unset($sql);
unset($ligne);
mysql_free_result($result);
?>
</tr>
<tr>
<td width="200px" style="text-align:right;">Identifiant de connexion</td>
<td style="text-align:center;"><input type="text" name="form_user" value="<?php if(isset($_SESSION["dbdata"]["user"])){echo $_SESSION["dbdata"]["user"];}?>"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Nouveau Mot de passe</td>
<td style="text-align:center;"><input type="password" name="form_nouveaumotdepasse" value="" title="Changer de Mot de passe"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Confirmation du Mot de passe</td>
<td style="text-align:center;"><input type="password" name="form_confirmationmotdepasse" value="" title="Confirmer le Mot de passe"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Email</td>
<td style="text-align:center;"><input type="text" name="form_email" value="<?php if(isset($_SESSION["dbdata"]["email"])){echo $_SESSION["dbdata"]["email"];}?>"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Nom</td>
<td style="text-align:center;"><input type="text" name="form_nom" value="<?php if(isset($_SESSION["dbdata"]["nom"])){echo $_SESSION["dbdata"]["nom"];}?>"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Prénom</td>
<td style="text-align:center;"><input type="text" name="form_prenom" value="<?php if(isset($_SESSION["dbdata"]["prenom"])){echo $_SESSION["dbdata"]["prenom"];}?>"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Adresse</td>
<td style="text-align:center;"><textarea name="form_adresse"><?php if(isset($_SESSION["dbdata"]["adresse"])){echo $_SESSION["dbdata"]["adresse"];}?></textarea></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Code postal</td>
<td style="text-align:center;"><input type="text" name="form_codepostal" value="<?php if(isset($_SESSION["dbdata"]["codepostal"])){echo $_SESSION["dbdata"]["codepostal"];}?>"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Ville</td>
<td style="text-align:center;"><input type="text" name="form_ville" value="<?php if(isset($_SESSION["dbdata"]["ville"])){echo $_SESSION["dbdata"]["ville"];}?>"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Pays</td>
<td style="text-align:center;"><input type="text" name="form_pays" value="<?php if(isset($_SESSION["dbdata"]["pays"])){echo $_SESSION["dbdata"]["pays"];}?>"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">Téléphone mobile</td>
<td style="text-align:center;"><input type="text" name="form_mobile" value="<?php if(isset($_SESSION["dbdata"]["mobile"])){echo $_SESSION["dbdata"]["mobile"];}?>"></td>
</tr>
<tr>
<td width="200px" style="text-align:right;">
<input type="hidden" name="action" value="sauveuser">
<input type="hidden" name="form_horloge" value="<?php echo date_heure();?>">
<input type="hidden" name="form_pere" value="<?php if(isset($_SESSION["dbdata"]["pere"])){echo $_SESSION["dbdata"]["pere"];} ?>">
<input type="hidden" name="form_type" value="<?php if(isset($_SESSION["dbdata"]["type"])){echo $_SESSION["dbdata"]["type"];}else{echo "user";} ?>">
<input type="hidden" name="form_id" value="<?php if(isset($_SESSION["dbdata"]["id"])){echo $_SESSION["dbdata"]["id"];}else{echo nouvelle_id();} ?>">
</td>
<td style="text-align:center;">
<br><br><input type="image" src="images/jpg/valider.jpg" id="image32" name="submit" title="Cliquez pour valider">
<input type="hidden" value="Valider" style="width:64px;height:64px;" name="submit" title="Cliquez pour valider">
</td>
</tr>
</table>  
</form></center>
<?php
unset ($_SESSION["inc"]);
unset ($_SESSION["userinfo"]);   
unset ($_SESSION["dbdata"]);
}
?>