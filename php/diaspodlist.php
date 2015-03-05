<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Sébastien Adam http://www.sebastienadam.be/
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

function getPodsList($path_padlist = "podslist.php", $cache_duration = 86400) {
  // test if data must be accessed from cache or source
  if(!file_exists($path_padlist) || !empty($_GET["refresh"])) {
    $reload = TRUE;
  } else {
    include $path_padlist;
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
  sort($pods);

  // return the pods list
  return $pods;
}

// output data if script directly called
if(basename(__FILE__) == basename($_SERVER["SCRIPT_FILENAME"])) {
  header('Content-Type: application/json');
  echo json_encode(getPodsList());
}