<?php
function getPodsList($path_padlist = "podslist.php", $cache_duration = 86400) {
  // test if data must be accessed from cache or source
  if(!file_exists($path_padlist) || !empty($_GET["refresh"])) {
    $reload = TRUE;
  } else {
    include_once $path_padlist;
    if(($last_update + $cache_duration) < time()) {
      $reload = TRUE;
    } else {
      $reload = FALSE;
    }
  }

  // reload data
  if ($reload) {
    $json = file_get_contents("http://podupti.me/api.php?key=4r45tg&format=json");
    $pods = array();
    if($json !== FALSE) {
      $decoded = json_decode($json);
      if($decoded !== NULL) {
        foreach ($decoded->{'pods'} as $pod) {
          if(strtolower($pod->{'status'}) == "up") {
            $pods[] = $pod->{'domain'};
          }
        }
      }
    }
    $last_update = time();
    $FH = fopen($path_padlist, "w");
    fwrite($FH, "<?php\n");
    fwrite($FH, "\$last_update = $last_update;\n");
    fwrite($FH, "\$pods = ".var_export($pods, true).";\n");
    fclose($FH);
  }
  
  // return the pods list
  return $pods;
}

// output data if script directly called
if(basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header('Content-Type: application/json');
  echo json_encode(getPodsList());
}