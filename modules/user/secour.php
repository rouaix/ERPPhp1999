<?php
if (file_exists("securite.php")){include("securite.php");}
echo "<fieldset class=\"page\">";
echo "<legend class=\"page\">Identifiant ou mot de passe perdu ?</legend>";
?>
<p id="centre"><img src="images/png/carre-jaune.png" border="0" width="32px" vspace="10">
<p id="centre">Pour recevoir un email contenant vos informations de connexion, veuillez saisir votre adresse email, votre prénom et votre nom.</p>
<center>
<form enctype="multipart/form-data" style="width:400px;" method="post" action="<?php echo $_SESSION["lien"];?>">
<table cellpadding="0" cellspacing="10" border="0" width="100%">

<tr> 
<td width="80px" align="right">Email</td>
<td width="300px"><input id="obligatoire" type="text" name="xxxemail" value=""></td>
</tr> 

<tr>
<td align="right">Prénom</td>
<td><input id="obligatoire" type="text" name="xxxprenom" value=""></td>
</tr>

<tr>
<td align="right">Nom</td>
<td><input id="obligatoire" type="text" name="xxxnom" value=""></td>
</tr>


<tr>
<td colspan="2"><p><br><p id="centre">Ou votre identifiant</p><p><br></td>
</tr>

<tr>
<td align="right">Identifiant</td>
<td><input type="text" name="xxxuser" value=""></td>
</tr>
<tr>
<td align="center" colspan="2"><input type="image" src="images/png/ok-vert.png" id="image" name="submit" title="Cliquez pour valider"><input type="hidden" name="action" value="usersecour"></td>
</tr>
</table>
</form>
</center>
</fieldset>