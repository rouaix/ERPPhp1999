<?php
if(file_exists("../../securite.php")){include("../../securite.php");}

echo "<div style=\"color:#".@$_SESSION["modules"]["couleurtexte"][$_SESSION["page"]].";background-color:#".@$_SESSION["modules"]["couleurfond"][$_SESSION["page"]].";\">";

$url = "http://news.google.fr/news?ned=fr&topic=h&output=rss";

switch (@$_SESSION["page"]){
  default :
    echo lire_rss($url,'5','mini');
  break;
  case "accueil":
    echo lire_rss($url,'10','mini');
    echo "<div class=\"content-separator\"></div>";
  break;
}


echo "</div>";




function lire_rss($url,$nbr,$taille)
{
  $i=0;
  $tout = "<div class=\"module\" id=\"titre\">Actualit&eacute; (Flux Rss Google)</div>\n";
  $tout .= "<ul class=\"rss\">\n";
  $xml = simplexml_load_file($url) ;
  foreach($xml->channel->item as $item) {
    $i++;
    if($i<=$nbr){
      $txt=$item->description;
      $lien = $item->link;
      $titre = $item->title;
      $tout .= "<li>";

      $tout .= "<a href=\"".$lien."\" class=\"rss\">";
      //$tout .= "<img src=\"images/png/jamembo-forward.png\" height=\"16px\" hspace=\"5px\" border=\"0\">";
      $tout .= $titre;
      $tout .= "</a><br />";


      if($taille == "maxi"){$tout .= $txt;}
      if($taille == "mini"){$tout .= "";}
      $tout .= "</li>\n";
    }
  }
  $tout .= "</ul>\n";
  $tout = str_replace('href=', 'target="Flux Rss" href=', $tout);
  $tout = str_replace('<nobr>', '<nobr class="rss">', $tout);
  $tout = str_replace('</nobr>', '</nobr>'."\n", $tout);
  $tout = str_replace('<br />', '<br>'."\n", $tout);
  //$tout = explode (' - ',$tout);
  //$tout = $tout[0]."<br>".$tout[1];
return $tout;
}
?>