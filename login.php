<?php
// Niente accessi diretti
if(!isset($hash_pwd)) die('Accesso diretto non consentito!');

if(isset($_POST['pwd'])){
    // Modulo inviato
    if($_POST['pwd'] != ''){
        // I campi erano compilati
        if(md5($_POST['pwd']) == $hash_pwd){
            // Password corretta
            session_regenerate_id();
            $_SESSION['logged'] = 1;
            $_SESSION['token'] = md5($_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
        
            echo <<<_END
    <div class="alert alert-info">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Benvenuto!</strong> L'accesso &egrave; stato effettuato correttamente.
    </div>
    <table>
      <tr>
        <td><a class="btn btn-primary btn-large" href="index.php?mode=1">Scarica</a></td>
        <td>&nbsp;</td>
        <td><a class="btn btn-primary btn-large" href="index.php?mode=2">Visualizza</a></td>
      </tr>
    </table>
_END;
        } else {
            // Utente e password sbagliati
            print_error("Password errata.");
        }
        
    } else {
        // I campi erano vuoti
        print_error("Inserisci una password.");
    }
} else {
    // Modulo non ancora inviato
    print_login_form();
}

function print_login_form(){
    echo <<<_END
      <form class="form-signin" method="post" action="index.php">
        <h2 class="form-signin-heading">Accesso richiesto</h2>
        <input type="password" class="input-block-level" name="pwd" placeholder="Password">
        <button class="btn btn-large btn-primary" type="submit">Accedi</button>
      </form>
_END;
}

function print_error($error){
    echo <<<_END
    <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Attenzione!</strong> $error
    </div>
_END;
    print_login_form();
}

?>