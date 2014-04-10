<?php
// Niente accessi diretti
if(!isset($hash_pwd)) die('Accesso diretto non consentito!');

// E' stato inviato il form
if(isset($_POST['submitted'])){
    $url = $_POST['url'];
    $method = $_POST['method'];
    
    if($url == ''){
        // Indirizzo non presente
        echo <<<_END
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Attenzione!</strong> Non hai inserito un indirizzo.
    </div>
_END;
        print_form();
    } else {
        // Indirizzo valido
        if(filter_var($url, FILTER_VALIDATE_URL)){
            // Formato non presente
            if($method == ''){
                echo <<<_END
<form method="post" action="index.php?mode=1" class="form-horizontal">
  <div class="control-group">
    <label class="control-label">Indirizzo:</label>
    <div class="controls">
      <input class="span3" type="text" name="url" value="$url" readonly="true" />
          <span class="add-on">
            <i class="icon-play-circle">
            </i>
          </span>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label">Impostazioni:</label>
    <div class="controls">
        <select class="span3" name="method" size="1">
_END;
                format_list($url);
                echo <<<_END
        </select>
          <span class="add-on">
            <i class="icon-refresh">
            </i>
          </span>
    </div>
  </div>
<input type="hidden" name="submitted" value="yes" />
<div class="controls">
  <button type="submit" class="btn btn-large btn-primary">Vai!</button>
  <a class="btn btn-large" href="index.php?mode=1">Cancella</a>
</div>
</form>
_END;
            } else {
                //Scarica
                $method_safe = (int)$method;
                $command = "youtube-dl -o \"./download/%(title)s.%(ext)s\" -f " . $method_safe . " " . $url;
                echo "<pre>";
                echo exec($command);
                echo "</pre>";
            }

        } else {
            // Errore nell'indirizzo
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
    // Stato iniziale
    print_form();
}

function print_form(){
    echo <<<_END
<form method="post" action="index.php?mode=1" class="form-horizontal">
  <div class="control-group">
    <label class="control-label">Indirizzo:</label>
    <div class="controls">
      <input class="span3" type="text" name="url" value="" />
          <span class="add-on">
            <i class="icon-play-circle">
            </i>
          </span>
    </div>
  </div>
<input type="hidden" name="submitted" value="yes" />
<div class="controls">
  <button type="submit" class="btn btn-large btn-primary">Analizza</button>
  <a class="btn btn-large" href="index.php?mode=1">Cancella</a>
</div>
</form>
_END;
}

function format_list($url){
    $command = "youtube-dl -j " . $url;
    $json = exec($command);
    $vett = json_decode($json, true);
    printf("\n");

    foreach ($vett["formats"] as $k) {
        echo '<option value="';
        echo $k["format_id"];
        echo '">';
        echo $k["ext"];
        echo preg_replace("/.* -(.*)/", " - $1", $k["format"]);
        echo '</option>';
        printf("\n");
    }  
}

?>