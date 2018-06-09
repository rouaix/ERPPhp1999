<?php
if (file_exists("securite.php")){include("securite.php");}
?>

<div class="zone">
  <div class="zone" id="titre"><?php
  $sql = "select * from messagerie where pere=".$_SESSION["userid"]." and type='message' and archive='' order by id desc";
  $result = mysql_query($sql);
  if(mysql_num_rows($result)>0){$style = "jpg/affirme.jpg";}else{$style="jpg/carre.jpg";}
  ?><img src="images/<?php echo $style; ?>" class="zone" alt="" />Messagerie</div>
  <div class="zone" id="contenu"><ul>
  <li><?php echo "<a title=\"Envoyer un message\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=nouveaumessage','surpopup');\">Envoyer un message</a>"; ?></li>
	<li><?php
    $sql = "select * from messagerie where type='message' and archive ='' and destinataire='".$_SESSION["userid"]."' order by id desc";
    $result = mysql_query($sql);
    echo "<a href=\"".$_SESSION["lien"]."?page=organiseur&voir=message\">";
    echo "Vous avez ".mysql_num_rows($result)." message".pluriel(mysql_num_rows($result));
    echo "</a>";?>
  </li>
  </ul></div>
</div>

<div class="zone">
  <div class="zone" id="titre"><?php
  $result = mysql_query("select * from tache where pere=".$_SESSION["userid"]." and type='tache' and archive='' order by nom");
  if(mysql_num_rows($result)>0){$style = "jpg/affirme.jpg";}else{$style="jpg/carre.jpg";}?><img src="images/<?php echo $style; ?>" class="zone" alt="" />Taches en cours</div>
  <div class="zone" id="contenu"><ul>
  <li><a href="<?php echo "javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=nouvelletache','surpopup');";?>">Ajouter une tache</a></li><?php
    while ($ligne = mysql_fetch_array($result)){
    echo "<li title=\"".$ligne["nom"]."\n".substr($ligne["contenu"],0,200)."\n...\"".categorie($ligne,"t").">";
    echo "<a title=\"Modifier\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=modifiertache&modifier=".$ligne["id"]."','surpopup');\">";
    echo "</a>";
    echo limite_texte(@$ligne["nom"],"25");
    echo "</li>\n";
  }?></ul></div>
</div>

<div class="zone">
  <div class="zone" id="titre"><?php
  $sql = "select user.id,user.prenom,user.nom from user,connecte where user.id = connecte.co";
  $result = mysql_query($sql);
  if(mysql_num_rows($result)>0){$style = "jpg/affirme.jpg";}else{$style="jpg/carre.jpg";}?><img src="images/<?php echo $style; ?>" class="zone" alt="" />En ligne</div>
  <div class="zone" id="contenu"><ul><?php
  echo "<li>".@$_SESSION["visiteur"]["inconnu"]." Visiteur".pluriel(@$_SESSION["visiteur"]["inconnu"])."</li>";
  echo "<li>".@$_SESSION["visiteur"]["connu"]." Membre".pluriel(@$_SESSION["visiteur"]["connu"])." sur ".@$_SESSION["visiteur"]["membre"]."</li>";
  while ($ligne = mysql_fetch_array($result)){
  echo "<li>";
  //echo "<a title=\"Envoyer un message\" href=\"javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.php?inc=reponsemessage&modifier=".$ligne["id"]."','surpopup');\">";
  echo ucfirst($ligne["prenom"])." ".strtoupper($ligne["nom"]);
  //echo "</a>";
  echo "</li>";
  }?></ul></div>
</div>

<div class="zone">
  <div class="zone" id="titre"><img src="images/jpg/carre.jpg" class="zone" alt="">Outils</div>
  <div class="zone" id="contenu"><center>
  <a href="javascript:voir('leformulaire');ajaxpage(rootdomain+'scripts/inc.radio.php','leformulaire');loadobjs();"><img src="images/jpg/dialogue.jpg" title="Ecouter la radio" class="zone"></a>
  <img src="images/jpg/i.jpg" title="Imprimer (en construction)" class="zone">
  <img src="images/jpg/question.jpg" title="Aide (en construction)" class="zone" onClick="javascript:voir('popup');ajaxpage(rootdomain+'scripts/inc.popup.aide.php?','surpopup');"></center></div>
</div>