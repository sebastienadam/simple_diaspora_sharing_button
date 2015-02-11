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

// goto : https://<domain>/bookmarklet?url=<url_encode_url>&title=<url_encode_title>&notes=&v=1&noui=1&jump=doclose
include_once './diaspodlist.php';
include_once './locales/tr.php';
$pods = getPodsList();
$from = empty($_GET["url"])?"":urlencode($_GET["url"]);
$title = empty($_GET["title"])?"":urlencode($_GET["title"]);
$notes = empty($_GET["notes"])?"":urlencode($_GET["notes"]);
$tr = new Tr();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $tr->message("share_on_diaspora"); ?></title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/black-tie/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <style type="text/css">
      body { padding-top: 50px; }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <span class="navbar-brand">diapora*</span>
      </div>
    </nav>
    <div class="container">
      <h1><?php echo $tr->message("share_on_diaspora"); ?></h1>
      <form class="form-inline" id="gotoForm">
        <div class="form-group">
          <label for="exampleInputName2">Pod&nbsp;:</label>
          <div class="input-group">
            <div class="input-group-addon">https://</div>
            <input type="text" class="form-control input-sm" id="podInputUrl" style="width: 200px;">
            <div class="input-group-addon">/</div>
          </div>
        </div>
        <button type="submit" id="gotoButton" class="btn btn-primary input-sm"><?php echo $tr->message("button_go"); ?></button>
      </form>
    </div><!-- /.container -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.11.2/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script type="text/javascript">
$(function() {
  var availableTags = <?php echo json_encode($pods); ?>;
  $( '#podInputUrl' ).focus();
  $( '#podInputUrl' ).autocomplete({
    source: availableTags
  });
  $( '#gotoForm' ).submit(function () {
    var domain = $( '#podInputUrl' ).val();
    if (domain !== '') {
      var url = '<?php echo $from; ?>';
      var title = '<?php echo $title; ?>';
      var notes = '<?php echo $notes; ?>';
      if(url !== '' && title !== '') {
        var redirect = 'https://'+domain+'/bookmarklet?title=%5B'+title+'%5D%28'+url+'%29&url=+&notes='+notes+'&v=1&noui=1&jump=doclose';
      } else {
        var redirect = 'https://'+domain+'/bookmarklet?title='+title+'&url='+url+'&notes='+notes+'&v=1&noui=1&jump=doclose';
      }
      window.location.href = redirect;
    }
    return false;
  });
});
    </script>
  </body>
</html>