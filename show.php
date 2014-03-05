<?php
// Niente accessi diretti
if(!isset($hash_pwd)) die('Accesso diretto non consentito!');

if(isset($_GET['id'])){
    // Procedura di cancellazione
    $path = realpath('./download/'.$_GET['id']);
        if(is_readable($path)) {
                unlink($path);
            echo <<<_END
    <div class="alert alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Fatto!</strong> Il file &egrave; stato cancellato correttamente.
    </div>
_END;
    } else {
        // File non cancellabile
        echo <<<_END
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Attenzione!</strong> Non ho i permessi per cancellare il file.
    </div>
_END;
    }
}

echo <<<_END
<h4 class=\"muted\">File disponibili</h4>
<table class="table table-hover">
_END;
$n_file = 0;
if($handle = opendir('./download')) {
    while(false !== ($entry = readdir($handle))) {
        if($entry != "." && $entry != "..") {
            $n_file++;
            printf("\n<tr><td>%s</td><td></td>", $entry);
            printf("<td><a class=\"btn btn-primary\" href=\"download/%s\">Scarica</a></td>", $entry);
            printf("<td><a class=\"btn btn-danger\" href=\"index.php?mode=2&id=%s\">Cancella</a></td>", $entry);
            echo "</tr>";
        }
    }
    if($n_file == 0) {
        echo "<tr><td>Nessun file</td></tr>";
    }
printf("\n</table>");
closedir($handle);
}

?>