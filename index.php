<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : The index of the website.
 */
require_once './dao/flashmessage.php';
require_once './dao/dao.php';

$index = TRUE;

if (filter_has_var(INPUT_POST, 'connection')) {
    $nickname_login = trim(filter_input(INPUT_POST, 'nicknameLogin', FILTER_SANITIZE_STRING));
    $pwd_login = filter_input(INPUT_POST, 'passwordLogin', FILTER_SANITIZE_STRING);
    $errors_connection = [];

    if (empty($nickname_login)) {
        $errors_connection['nicknameLogin'] = "L'identifiant ne peut pas être vide.";
    }

    if (empty($pwd_login)) {
        $errors_connection['passwordLogin'] = "Le mot de passe ne peut pas être vide.";
    }

    if (empty($errors_connection)) {
        if (CheckLogin(strtolower($nickname_login), $pwd_login) == FALSE) {
            $errors_connection['login'] = 'L\'identifiant et/ou le mot de passe sont faux.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Blindtest</title>
        <?php require_once './css/css_js.php'; ?>
    </head>
    <body>
        <div class="container">
            <?php require_once './navbar.php'; ?>
            <div class="row">
                <div class="col">
                    <form action="index.php" method="post">
                        <div class="form-group">
                            <?php if (!empty($message)) : ?>
                                <p><?= $message ?></p>
                            <?php endif; ?>
                            <label for="exampleInputNickname">Identifiant :</label>
                            <input type="text" name="nicknameLogin" value="<?php
                            if (!empty($nickname_login)) {
                                echo $nickname_login;
                            }
                            ?>" class="form-control col-3" id="exampleInputNickname" placeholder="Entrez votre pseudo">
                                   <?php
                                   if (!empty($errors_connection['nicknameLogin'])) {
                                       echo $errors_connection['nicknameLogin'];
                                   }
                                   ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe :</label>
                            <input type="password" name="passwordLogin" class="form-control col-3" id="exampleInputPassword1" placeholder="Entrez votre mot de passe">
                            <?php
                            if (!empty($errors_connection['passwordLogin'])) {
                                echo $errors_connection['passwordLogin'];
                            }
                            if (!empty($errors_connection['login'])) {
                                echo $errors_connection['login'];
                            }
                            ?>
                        </div>
                        <button type="submit" name="connection" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>
