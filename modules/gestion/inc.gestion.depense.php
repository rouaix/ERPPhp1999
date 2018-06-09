<?php
if (file_exists("securite.php")){include("securite.php");}
echo "<h3>";
echo "Centre de gestion";
echo "</h3>";
?>
<center>
<table style="width:100%" cellpadding="0" cellspacing="2" border="0">
<tr>
<td style="width:50%;text-align:center;">Dépenses</td>
</tr>
<tr>
<td class="contenu" id="titre" style="width:100%;">
    <form name="formachat" enctype="multipart/form-data" style="text-align:center;" method="post" action="<?php echo $_SESSION["lien"];?>">
    
    <table style="width:100%;" cellpadding="0" cellspacing="2" border="0">
    <tr>
    <td style="width:90px;text-align:center;">Date<br><input type="text" name="xxxhorloge" title="Date" value="<?php echo substr(date_heure(),0,-6);?>"></td>
    <td colspan="5" style="text-align:center;">Classement comptable<br><select name="xxxcategorie" title="Classement comptable">
    <option value=" " selected>?</option><?php
    $sql = "select id,compte,nom,info,pere from compte ";
    $sql .= "where compte like '602%' ";   
    $sql .= "or compte like '7%' ";     
    $sql .= "and archive ='' order by compte";   
    $result = mysql_query($sql);
    while ($ligne = mysql_fetch_array($result)){
      //$temp = html_entity_decode($ligne["civilite"], ENT_QUOTES, 'UTF-8');
      if(strlen($ligne["compte"])>0){
        echo "<option value=\"".$ligne["compte"]."\">";
        $x = 1;
        while ($x < strlen($ligne["compte"])){
          echo "&nbsp;&nbsp;";  
          $x ++;
        }
        //echo "<b>".html_entity_decode($ligne["compte"],ENT_QUOTES,'UTF-8')."</b>&nbsp;".ucfirst(html_entity_decode($ligne["nom"],ENT_QUOTES,'UTF-8'))."&nbsp;".ucfirst(html_entity_decode($ligne["info"],ENT_QUOTES,'UTF-8'))."";
        echo "<b>".$ligne["compte"]."</b>&nbsp;".ucfirst($ligne["nom"])."&nbsp;".ucfirst($ligne["info"])."";
        echo "</option>";
      }
    }    
    ?></select></td>
    
    </tr>
    <tr>
    <td style="width:90px;text-align:center;">Référence<br><input type="text" name="xxxnom" title="Identifiant" value=""></td>    
    <td style="width:300px;text-align:center;">Détails<br><input type="text" name="xxxcontenu" title="Détail" value=" "></td>
    <td style="width:50px;text-align:center;">Qte<br><input type="text" name="xxxdebut" title="Quantité" value="1"></td>
    <td style="width:150px;text-align:center;">Montant Total<br><input type="text" name="xxxfin" title="Montant" value=""></td>
    <td style="width:50px;text-align:center;"> <br><input type="submit" style="width:60px;height:20px;text-align:center;" value="Valider" title="Cliquez pour valider"></td>
    <td></td>
    </tr>
    </table>
    <input type="hidden" name="action" value="sauvedata">
    <input type="hidden" name="table" value="<?php echo "z".$_SESSION["userid"];?>">
    <input type="hidden" name="xxxpere" value="<?php echo $_SESSION["userid"];?>">
    <input type="hidden" name="xxxtype" value="610">
    </form>
</td>
</tr>
<tr>
<td style="width:100%;">
  <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
<?php
$sql = "select * from z".$_SESSION["userid"]." where type='610' and archive =''";
$result = mysql_query($sql);
$total = 0;
while ($ligne = @mysql_fetch_array($result)){
  //$temp = html_entity_decode($ligne["civilite"], ENT_QUOTES, 'UTF-8');
  echo "<tr>";
  echo "<td style=\"width:70%\">";
  echo "<a href=\"".$_SESSION["lien"]."?table=z".$_SESSION["userid"]."&action=effaceligne&effaceligne=".$ligne["id"]."\" title=\"Supprimer !\">";
  echo "<img src=\"images/jpg/x.jpg\" style=\"height:12px;margin-right:5px;vertical-align:middle\" border=\"0\">";
  echo "</a>";
  echo substr($ligne["horloge"],0,-5)." ";
  echo $ligne["nom"]." ";
  echo $ligne["categorie"]." ";
  $total = $total + $ligne["fin"];
  
  echo " ".ucfirst($ligne["contenu"])." ";
  echo "</td>";

  echo "<td style=\"width:10%;text-align:center\">";
  echo $ligne["debut"];
  echo "</td>";
  
  echo "<td style=\"width:10%;text-align:right\">";
  echo @number_format($ligne["fin"], 2, '.', ',')." €";
  echo "</td>";
  echo "</tr>";
}
  echo "<tr>";
  echo "<td style=\"text-align:left\" colspan=\"2\">";
  echo "<b>Total</b>";
  echo "</td>";

  echo "<td style=\"text-align:right\">";
  echo "<b>".number_format($total, 2, '.', ',')." €</b>";
  echo "</td>";
  echo "</tr>";

unset($sql);
unset($ligne);
unset($total);
@mysql_free_result($result);
?>
</table>
</td>
</tr>
<tr>
<td style=""></td>
</tr>
<tr>
<td style=""></td>
</tr>
</table>
</center>
<?php
  switch (@$_SESSION["inc"]) {
    default :
    break;

    case "achat":
?>
    <form class="user" enctype="multipart/form-data" style="margin:2px;width:400px;" method="post" action="<?php echo $_SESSION["lien"];?>">
    <p>Ajouter un achat
    <p><input type="text" name="xxxnom" value="">
    <input type="hidden" name="action" value="sauvedata">
    <input type="hidden" name="table" value="<?php echo "z".$_SESSION["userid"];?>">
    <input type="text" name="xxxhorloge" value="<?php echo date_num();?>">
    <input type="hidden" name="xxxpere" value="<?php echo $_SESSION["userid"];?>">
    <input type="hidden" name="xxxtype" value="610">
    <p id="centre"><input type="submit" value="Valider" style="width:50px;height:25px;text-align:center;" title="Cliquez pour valider">
    </form>
<?php
    unset($_SESSION["inc"]);
    break;
  }
?>