<?phpIF(file_exists("../../securite.php")){INCLUDE("../../securite.php");}  $cid = 5;  $pid = 5;  $texte  = "<map version=\"0.9.0\">\n";  $texte .= "<!-- To view this file, download free mind mapping software FreeMind from http://freemind.sourceforge.net -->\n";  $texte .= "<node BACKGROUND_COLOR=\"#ffffff\" CREATED=\"CID_1\" MODIFIED=\"MID_1\" ID=\"ID_1\" STYLE=\"fork\" TEXT=\"Liste et structure des tables\">\n";  $texte .= "<edge STYLE=\"sharp_linear\" WIDTH=\"1\"/>\n";  $texte .= "<hook NAME=\"MapStyle\" max_node_width=\"600\"/>\n";  $texte .= "<node CREATED=\"CID_2\" MODIFIED=\"MID_2\" ID=\"ID_2\" STYLE=\"bubble\" POSITION=\"right\" TEXT=\"".ucfirst($_SESSION["base"])."\">\n";  $texte .= "<edge STYLE=\"sharp_linear\" WIDTH=\"1\"/>\n";  if($result = mysql_query("SHOW TABLES FROM ".$_SESSION["base"])){    WHILE ($row = mysql_fetch_row($result)){      $cid ++;              $texte .= "<node BACKGROUND_COLOR=\"#ffe76d\" STYLE=\"bubble\" FOLDED=\"true\" CREATED=\"CID_".$cid."\" MODIFIED=\"MID_".$cid."\" ID=\"ID_".$cid."\" LINK=\"".$_SESSION["lien"]."?page=cartes&amp;carte=Tables_".ucfirst($row[0])."\" TEXT=\"".ucfirst($row[0])."\">\n";      if($rc = mysql_query("SHOW FULL COLUMNS FROM ".$row[0])){        WHILE($ligne = mysql_fetch_assoc($rc)){          $pid ++ ;          $texte .= "<node CREATED=\"CPID_".$pid."\" MODIFIED=\"MPID_".$pid."\" ID=\"PID_".$pid."\" STYLE=\"bubble\" TEXT=\"".ucfirst($ligne["Field"])."\"/>\n";                  }      }      $texte .= "</node>\n";      carte_enfant($row[0],"Tables");    }  }  $texte .= "</node>\n";  $texte .= "</node>\n";  $texte .= "</map>\n";    $Fnm = "fichiers/fichiers/fichiers/cartes/Tables.mm";  $inF = fopen($Fnm,"w");    fwrite($inF,$texte);  fclose($inF);  UNSET($texte);  ECHO "<div class=\"module\" id=\"ligne\"><a href=\"".$_SESSION["lien"]."?page=cartes&amp;carte=Tables\" title=\"Afficher\"><img src=\"".$_SESSION["ico"]["voir"]."\" class=\"module\"><b>Cliquer ici pour voir la carte</b></a></div>\n";UNSET($_SESSION["montre"]);FUNCTION carte_enfant($nom,$lien_retour){  $xcid = 5;  $xpid = 5;  $t  = "<map version=\"0.9.0\">\n";  $t .= "<!-- To view this file, download free mind mapping software FreeMind from http://freemind.sourceforge.net -->\n";    $t .= "<node BACKGROUND_COLOR=\"#ffffff\" CREATED=\"CID_1\" MODIFIED=\"MID_1\" ID=\"ID_1\" STYLE=\"fork\" LINK=\"".$_SESSION["lien"]."?page=cartes&carte=".$lien_retour."\" TEXT=\"".ucfirst($lien_retour)."\">\n";    $t .= "<edge STYLE=\"sharp_linear\" WIDTH=\"1\"/>\n";  $t .= "<hook NAME=\"MapStyle\" max_node_width=\"600\"/>\n";      $t .= "<node BACKGROUND_COLOR=\"#ffe76d\" CREATED=\"CID_".$xcid."\" MODIFIED=\"MID_".$xcid."\" ID=\"ID_".$xcid."\" POSITION=\"right\" STYLE=\"bubble\" FOLDED=\"true\" TEXT=\"".ucfirst($nom)."\">\n";         if($rc = mysql_query("SHOW FULL COLUMNS FROM ".$nom)){    WHILE($ligne = mysql_fetch_assoc($rc)){      $xpid ++ ;      $xcid ++ ;      $t .= "<node CREATED=\"CWID_".$xpid."\" MODIFIED=\"MWID_".$xpid."\" ID=\"WID_".$xpid."\" STYLE=\"bubble\" TEXT=\"".ucfirst($ligne["Field"])."\">\n";      WHILE(LIST($key,$val) = each($ligne)){        $xpid ++ ;        $xcid ++ ;              $t .= "<node CREATED=\"CXID_".$xpid."\" MODIFIED=\"MXID_".$xpid."\" ID=\"XID_".$xpid."\" STYLE=\"bubble\" TEXT=\"".ucfirst($key)." ".ucfirst($val)."\"/>\n";                  }                $t .= "</node>\n";    }  }  $t .= "</node>\n";  $t .= "</node>\n";  $t .= "</map>\n";    $F = "fichiers/fichiers/fichiers/cartes/Tables_".ucfirst($nom).".mm";    $fichier = fopen($F,"w");  fwrite($fichier,$t);  fclose($fichier);  UNSET($t);}?>