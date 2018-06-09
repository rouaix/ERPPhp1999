<?php
if(!isset($_SESSION)){session_start();}
if (file_exists("securite.php")){include("securite.php");}
echo "<fieldset class=\"page\">";
echo "<legend class=\"page\">Inscription</legend>";
?>
<center>
<form enctype="multipart/form-data" method="post" action="<?php echo $_SESSION["lien"];?>">
<table cellpadding="0" cellspacing="10" border="0">
<tr>
<td width="200px" id="droite" valign="middle">Vous êtes</td>
<td width="400px" valign="middle">
<?php
$sql = "select * from civilite where archive =''";   
$result = mysql_query($sql)or die("Erreur dans Civilite !");
echo "<select name=\"form_civilite\">";

while ($ligne = mysql_fetch_array($result)){
  //$temp = html_entity_decode($ligne["civilite"], ENT_QUOTES, 'UTF-8');
  //$titre = html_entity_decode($ligne["nom"], ENT_QUOTES, 'UTF-8');
  $temp = $ligne["civilite"];
  $titre = $ligne["nom"];  
  echo "<option value=\"".$temp."\" ";
  if(isset($_SESSION["form_civilite"])&& $_SESSION["form_civilite"]==$temp){echo "selected";}
  echo ">".$temp." (".$titre.")";
  echo "</option>";  
}
echo "</select>";
unset($temp);
unset($ligne);
mysql_free_result($result);
?>
</td>

<td rowspan="8" valign="top">
<p id="centre"><img src="images/png/carre-jaune.png" border="0" height="32px">
<p><b>L'inscription est gratuite.</b>
<p><br>Votre identifiant doit contenir un minimum de 3 caractères. Vous pouvez utiliser des points et des espaces mais évitez les caractères accentués.
<p><br>La taille minimum de votre mot de passe est de 5 caractères. <br>Après l'ouverture de votre compte, vous recevrez par e-mail une copie de votre code d'accès et de votre identifiant.
</td>

<tr>
<td width="200px" id="droite" valign="middle">Identifiant de connexion</td>
<td width="400px" valign="middle"><input type="text" name="form_user" value="<?php if(isset($_SESSION["form_user"]) && $_SESSION["form_user"] != ""){echo $_SESSION["form_user"];}else{echo "";}?>"></td>
</tr>
<tr>
<td width="200px" id="droite" valign="middle">Mot de passe</td>
<td width="400px" valign="middle"><input type="password" name="form_motdepasse" value="<?php if(isset($_SESSION["form_motdepasse"]) && $_SESSION["form_motdepasse"] != ""){echo $_SESSION["form_motdepasse"];}else{echo "";}?>" title="Votre Mot de passe"></td>
</tr>
<tr>
<td width="200px" id="droite" valign="middle">Confirmation du Mot de passe</td>
<td width="400px" valign="middle"><input type="password" name="form_confirmationmotdepasse" value="<?php if(isset($_SESSION["form_confirmationmotdepasse"]) && $_SESSION["form_confirmationmotdepasse"] != ""){echo $_SESSION["form_confirmationmotdepasse"];}else{echo "";}?>" title="Confirmer votre Mot de passe"></td>
</tr>
<tr>
<td width="200px" id="droite" valign="middle">Email</td>
<td width="400px" valign="middle"><input type="text" name="form_email" value="<?php if(isset($_SESSION["form_email"]) && $_SESSION["form_email"] != ""){echo $_SESSION["form_email"];}else{echo "";}?>"></td>
</tr>
<tr>
<td width="200px" id="droite" valign="middle">Prénom</td>
<td width="400px" valign="middle"><input type="text" name="form_prenom" value="<?php if(isset($_SESSION["form_prenom"]) && $_SESSION["form_prenom"] != ""){echo $_SESSION["form_prenom"];}else{echo "";}?>"></td>
</tr>
<tr>
<td width="200px" id="droite" valign="middle">Nom</td>
<td width="400px" valign="middle"><input type="text" name="form_nom" value="<?php if(isset($_SESSION["form_nom"]) && $_SESSION["form_nom"] != ""){echo $_SESSION["form_nom"];}else{echo "";}?>"></td>
</tr>
<tr>
<td width="200px" id="droite" valign="middle">
<input type="hidden" name="action" value="inscription">
<input type="hidden" name="table" value="user">
<input type="hidden" name="form_id" value="<?php if(isset($_SESSION["form_id"]) && $_SESSION["form_id"] != ""){echo $_SESSION["form_id"];}else{echo nouvelle_id();}?>">
<input type="hidden" name="form_pere" value="<?php if(isset($_SESSION["userid"]) && $_SESSION["userid"] != ""){echo $_SESSION["userid"];}else{echo "";}?>">
</td>
<td width="400px" valign="middle" align="center">
<input type="image" src="images/png/ok-vert.png" id="image" name="submit" title="Cliquez pour valider">
</td>
</tr>
<tr>
</table>
</form>
</center>
<?php echo "</fieldset>";?>