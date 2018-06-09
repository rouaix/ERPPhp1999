<?php
if(file_exists("../../securite.php")){include("../../securite.php");}
echo "<div style=\"color:#".@$_SESSION["modules"]["couleurtexte"][$_SESSION["page"]].";background-color:#".@$_SESSION["modules"]["couleurfond"][$_SESSION["page"]].";\">";
page_en_construction();
echo "</div>";
?>