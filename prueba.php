<?php
 
if(!ini_get('allow_url_fopen')){
echo "Es necesario activar la directiva allow_url_fopen del php.ini";
exit;
}
 
echo @file_get_contents("http://www.google.com");
 
?>

