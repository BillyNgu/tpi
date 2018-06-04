<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : Index
 * Description : TPI
 */
require_once './dao/flashmessage.php';
require_once './dao/dao.php';

$index = TRUE;

if (isset($_POST['connection'])) {
    $nickname = trim(filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING));
    $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    CheckLogin(strtolower($nickname), $pwd);
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
                            <input type="text" name="nickname" class="form-control col-3" id="exampleInputNickname" placeholder="Entrez votre pseudo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe :</label>
                            <input type="password" name="password" class="form-control col-3" id="exampleInputPassword1" placeholder="Entrez votre mot de passe">
                        </div>
                        <button type="submit" name="connection" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>
