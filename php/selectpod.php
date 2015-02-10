<!DOCTYPE html>
<?php
// goto : https://<domain>/bookmarklet?url=<url_encode_url>&title=<url_encode_title>&notes=&v=1&noui=1&jump=doclose
// https://code.jquery.com/jquery-2.1.3.min.js
// https://code.jquery.com/ui/1.11.2/jquery-ui.min.js

include_once './diaspodlist.php';
$pods = getPodsList();
$from = empty($_GET["url"])?"":urlencode($_GET["url"]);
//$from = empty($_GET["url"])?"":$_GET["url"];
$title = empty($_GET["title"])?"":urlencode($_GET["title"]);
$notes = empty($_GET["notes"])?"":urlencode($_GET["notes"]);
?>
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Partager sur Diapora*</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.2/themes/black-tie/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <style type="text/css">
      body { padding-top: 50px; }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <span class="navbar-brand">Diapora*</span>
      </div>
    </nav>
    <div class="container">
      <h1>Partager sur Diapora*</h1>
      <form class="form-inline" id="gotoForm">
        <div class="form-group">
          <label for="exampleInputName2">Pod&nbsp;:</label>
          <div class="input-group">
            <div class="input-group-addon">https://</div>
            <input type="text" class="form-control input-sm" id="podInputUrl" style="width: 200px;">
            <div class="input-group-addon">/</div>
          </div>
        </div>
        <button type="submit" id="gotoButton" class="btn btn-primary input-sm">Sélectionner</button>
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
