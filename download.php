<?php
// Niente accessi diretti
if(!isset($hash_pwd)) die('Accesso diretto non consentito!');

// E' stato inviato il form
if(isset($_POST['submitted'])){
    $url = $_POST['url'];
    $method = $_POST['method'];
    
    if($url == '' || $method == ''){
        // E' incompleto
        echo <<<_END
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Attenzione!</strong> Non hai compilato tutti i campi.
    </div>
_END;
        print_form();
    } else {
        // E' tutto compilato
        if(filter_var($url, FILTER_VALIDATE_URL) && $method >= 0){
            echo <<<_END
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Tutto bene!</strong> Scaricamento completato.
    </div>
_END;
            // Tipo di conversione
            switch ($method) {
                case 0:
                    $command = "youtube-dl -o ./download/%(title)s.%(ext)s ".$url;
                    break;
            }
            echo "<pre>";
            echo exec($command);
            echo "</pre>";
        } else {
            // Errore nell'url
            echo <<<_END
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Attenzione!</strong> Non hai inserito un indirizzo valido.
    </div>
_END;
            print_form();
        }
    }
} else {
    print_form();
}

function print_form(){
    echo <<<_END
<form method="post" action="index.php?mode=1" class="form-horizontal">
  <div class="control-group">
    <label class="control-label">Indirizzo:</label>
    <div class="controls">
      <input type="text" name="url" value="" />
          <span class="add-on">
            <i class="icon-play-circle">
            </i>
          </span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Impostazioni:</label>
    <div class="controls">
        <select name="method" size="1">
            <option value="0">Default</option>
            <option value="1">Solo audio</option>
            <option value="2">Altra opzione</option>
        </select>
          <span class="add-on">
            <i class="icon-refresh">
            </i>
          </span>
    </div>
  </div>
<input type="hidden" name="submitted" value="yes" />
<div class="controls">
  <button type="submit" class="btn btn-large btn-primary">Inizia</button>
  <a class="btn btn-large" href="index.php?mode=1">Cancella</a>
</div>
</form>
_END;
}
?>