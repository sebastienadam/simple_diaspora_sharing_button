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

// HTML, CSS & JavaScript (almost) from 'http://sharetodiaspora.github.io'

include_once './diaspodlist.php';
include_once './locales/tr.php';
$tr = new Tr();

// manage input parameters
$shareParams = array(); // used to generate parameters for pod sharing page
if(empty($_GET["url"])) {
  $url = "";
} else {
  $url = htmlentities($_GET["url"]);
  if(empty($_GET["title"])) {
    $shareParams[] = "url=".urlencode($_GET["url"]);
  } else {
    $shareParams[] = "url=".urlencode(" ");
  }
}
if(empty($_GET["title"])) {
  $title = "";
} else {
  $title = htmlentities($_GET["title"]);
  if(empty($_GET["url"])) {
    $shareParams[] = "title=".urlencode($_GET["title"]);
  } else {
    $shareParams[] = "title=".urlencode("[").urlencode($_GET["title"]).urlencode("](").urlencode($_GET["url"].")");
  }
}
if(!empty($_GET["notes"])) {
  $shareParams[] = "notes=".urlencode($_GET["notes"]);
}
$shareParams[] = "jump=doclose";

$pods = getPodsList();

function print_pods_list($pods) {
  $return = "";
  if(!empty($pods)) {
    $return .= '<datalist id="podslist">';
    foreach ($pods as $pod) {
      $return .= '<option value="'.$pod.'">';
    }
    $return .= '</datalist>';
  }
  return $return;
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $tr->message("share_on_diaspora"); ?></title>
    <style>
      /* from: 'http://sharetodiaspora.github.io' */
      body {
        margin: 0;
        padding: 0 0 2em;
        font-family: Helvetica, "Helvetica", Arial, sans-serif;
        font-size: 15px;
        max-height: 100%;
      }
      header {
        /***
          The style for the header is from diaspora*
            https://joindiaspora.com
            https://github.com/diaspora/diaspora
        ***/
        background-color: #222;
        -webkit-box-shadow: 0 0 2px #777;
        -moz-box-shadow: 0 0 2px #777;
        box-shadow: 0 0 2px #777;
        background-image: rgba(35,30,30,0.975);
        //filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=rgb(35, 30, 30),endColorstr=#231e1e);
        //-ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=rgba(35, 30, 30, 0.95), endColorstr=#231e1e)";
        background-image: -webkit-gradient(linear,0% 0,0% 100%,from(rgba(35,30,30,0.95)),to(#231e1e));
        background-image: -moz-linear-gradient(top,rgba(35,30,30,0.95) 0,#231e1e 100%);
        background-image: -o-linear-gradient(top,rgba(35,30,30,0.95) 0,#231e1e 100%);
        color: #dadada;
        padding: 8px 10px;
      }  header h2 {
          float: left;
          font-size: inherit;
          font-weight: inherit;
          border-right: 1px solid #aaa;
          padding: .6em 20px .6em 10px;
          margin: 0;
          display: none;
        }

        @media screen and (min-width: 600px) {
          header h2 {
            display: block;
          }
        }
        header #sharedet {
          text-align: center;
          margin: 0;
          width: auto;
        }  header #sharedet div {
            display: block;
            height: 1.2em;
            max-height: 1.2em;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            padding: 0 10px 0 20px;
            color: #dadada;
          }
          header #sharedet #sharetitle {
            font-weight: bold;
          }
      section {
        width: auto;
        float: left;
        margin: 10px 0 0;
        padding: 0px 20px;
      }  h3 {
          font-size: inherit;
          font-weight: inherit;
          color: #888;
        }
      section#podinput {
      
      }  #podurl {
          width: 200px;
          padding: 3px 6px;
          margin: 0;
          font-size: 15px;
          border: 1px solid silver;
          -webkit-transition: .1s border-color ease;
          -moz-transition: .1s border-color ease;
          -o-transition: .1s border-color ease;
          transition: .1s border-color ease;
        }
        #podurl:focus {
          border: 1px solid #bbcad0;
        }
        #podurlsm {
          margin: 0;
          margin-top: 6px;
          padding: 4px 10px;
        }
        :focus {
          outline: none;
        }
        input.error, input#podurl.error {
          border: 1px solid #a00;
        }
    </style>
    <script type="text/javascript">
      /* (almost) from: 'http://sharetodiaspora.github.io' */
      // Calculates URL and redirects (for direct redirection and custom pod)
      var share = function(u) {
        if (u!=="") {
          var nu = /^http/.test(u) ? u : ("https://" + u);
          nu += "/bookmarklet?<?php echo join("&", $shareParams) ?>";
          location.href = nu;
        } else {
          document.getElementById('podurl').className="error";
        }
      }
    </script>
  </head>
  <body>
    <header>
      <h2><?php echo $tr->message("sharing"); ?></h2>
      <div id="sharedet">
        <div id="sharetitle"><?php echo $title; ?></div>
        <div id="shareurl"><?php echo $url; ?></div>
      </div>
    </header>
    <section id="podinput">
      <h3><?php echo $tr->message("introduce_your_pod_URL"); ?></h3>
      <form onsubmit="share(document.getElementById('podurl').value); return false;">
        https://<input type="text" id="podurl" placeholder="<?php echo $tr->message("input_example").$pods[array_rand($pods)]; ?>" value="" list="podslist" />/&nbsp;&nbsp;&nbsp;<input type="submit" id="podurlsm" value="<?php echo $tr->message("button_go"); ?>" />
      </form>
      <?php echo print_pods_list($pods); ?>
    </section>
  </body>
</html>