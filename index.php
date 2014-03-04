<?php
session_start();
require_once 'config.php';
require_once 'header.html';

// In che modo siamo?
if(!isset($_SESSION['logged'])){
    // Se non siamo loggati
    $mode = 0;
} else {
    if($_SESSION['token'] == md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'])){
        // Siamo loggati
        $mode = 1;
        if(isset($_GET['mode'])){
            // Abilita la navigazione
            $mode = (int)$_GET['mode'];
        }
    } else {
        // Ci stanno rubando la sessione?
        $mode = 3;
    }
}

// Gestione del menu
echo <<<_END
        <ul class="nav nav-pills pull-right">

_END;
print_menu("Scarica", 1, $mode);
print_menu("Visualizza", 2, $mode);
print_menu("Esci", 3, 0);
echo <<<_END
        </ul>
        <h3 class="muted">youtube-dl-tmpname</h3>
      </div>

      <hr>

_END;

switch($mode){
    case '1':
        // Scarica e converti
        require_once 'download.php';
        break;
    case '2':
        // Visualizza
        require_once 'show.php';
        break;
    case '3':
        // Termina la sessione
        $_SESSION = array();
        if(session_id() != "" || isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy(); 
        echo <<<_END
    <div class="alert alert-info">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>A presto!</strong> La sessione &egrave; stata terminata correttamente.
    </div>
_END;
        require_once 'login.php';
        break;
    default:
        // Forza il login
        require_once 'login.php';
        break;
}

require_once 'footer.html';

function print_menu($name, $mode, $active){
    if($active == $mode || ($mode == 2 && $active == 3)){
        $string = sprintf("\t  <li class=\"active\"><a href=\"index.php?mode=%d\">%s</a></li>\n", $mode, $name);
    } else {
        $string = sprintf("\t  <li><a href=\"index.php?mode=%d\">%s</a></li>\n", $mode, $name);
    }
    echo $string;
}

?>