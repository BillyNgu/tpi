<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : Profil
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$profile = TRUE;

$userData = GetData($nickname);
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
            <div class="row mt-3">
                <div class="col-md-auto">
                    <div class="card" style="width: 18rem;">
                        <?php if (!empty($userData['user_profilepic'])): ?>
                            <img class="card-img-top" src="./uploaded_files/img/<?php echo $userData['user_profilepic']; ?>">
                        <?php else: ?>
                            <img class="card-img-top" src="./uploaded_files/img/no-avatar.png">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col">
                    <h3>Pseudo : <?php echo $nickname ?></h3>
                    <h5>Nom : <?= $userData['user_name'] ?> </h5> <br>
                </div>
                <div class="col">
                    <fieldset>
                        <legend>Score</legend>
                    </fieldset>
                </div>
            </div>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
