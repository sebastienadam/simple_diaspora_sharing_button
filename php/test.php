<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <pre>
<?php
$http_accepted_languages = explode(",",$_SERVER['HTTP_ACCEPT_LANGUAGE']);
$accepted_languages = array();
foreach ($http_accepted_languages as $http_accepted_language) {
  $accepted_languages[] = strtolower(substr($http_accepted_language,0,2));
}
var_export($accepted_languages);
echo "\n";
var_export(array_unique($accepted_languages));
?>
    </pre>
  </body>
</html>
