<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
      $Fnm = "fichiers/fichiers/fichiers/cartes/Tables.mm";
      $inF = fopen($Fnm,"w");
      $texte = "<map version=\"0.9.0\">\n";
      $texte .="<!-- To view this file, download free mind mapping software FreeMind from http://freemind.sourceforge.net -->\n";
      $texte .= "<node BACKGROUND_COLOR=\"#ffffff\" CREATED=\"1\" ID=\"1\" MODIFIED=\"1\" STYLE=\"fork\" TEXT=\"Liste et structure des tables\">\n";
      $texte .= "<edge STYLE=\"sharp_linear\" WIDTH=\"1\"/>\n";
      $texte .= "<hook NAME=\"MapStyle\" max_node_width=\"600\"/>\n";
      $texte .= "<node CREATED=\"1\" ID=\"2\" MODIFIED=\"1\" STYLE=\"bubble\" POSITION=\"right\" TEXT=\"".ucfirst($_SESSION["base"])."\">\n";
      $cid = 10;
      $pid = 10;
      $result = mysql_query("SHOW TABLES FROM ".$_SESSION["base"]);
      while ($row = mysql_fetch_row($result)){
        $cid ++;        
        $texte .= "<node BACKGROUND_COLOR=\"#ffe76d\" CREATED=\"2\" ID=\"A".$cid."\" MODIFIED=\"2\" STYLE=\"bubble\" FOLDED=\"true\" TEXT=\"".ucfirst($row[0])."\">\n";       
        $rc = mysql_query("SHOW FULL COLUMNS FROM ".$row[0]);
        while($ligne = mysql_fetch_assoc($rc)){
          $pid ++ ;
          $texte .= "<node CREATED=\"A".$cid."\" ID=\"B".$pid."\" MODIFIED=\"".$pid."\" STYLE=\"bubble\" TEXT=\"".ucfirst($ligne["Field"])."\">\n";
          while(list($key,$val) = each($ligne)){
            $texte .= "<node CREATED=\"A".$cid.$val."\" ID=\"B".$pid.$val."\" MODIFIED=\"".$pid.$val."\" STYLE=\"bubble\" TEXT=\"".ucfirst($key)." = ".ucfirst($val)."\"/>\n";
            //$texte .= "</node>\n";            
          }          
          $texte .= "</node>\n";
        }
        unset($infos);
        $texte .= "</node>\n";
      }
      $texte .= "</node>\n";
      $texte .= "</node>\n";
      $texte .= "</map>\n";
      fwrite($inF,$texte);
      fclose($inF);

      echo "<div class=\"module\" id=\"ligne\"><a href=\"".$_SESSION["lien"]."?page=cartes&carte=Tables.mm\" title=\"Afficher\"><img src=\"".$_SESSION["ico"]["voir"]."\" class=\"module\"><b>Cliquer ici pour voir la carte</b></a></div>\n";
      unset($_SESSION["montre"]);

?>