<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-01-31
 * Titre : Forum
 * Description : Forum PHP
 */
require_once './dao/flashmessage.php';
require_once './dao/dao.php';

$index = TRUE;

if (isset($_POST['connection'])) {
    $Nickname = trim(filter_input(INPUT_POST, 'Nickname', FILTER_SANITIZE_STRING));
    $Pwd = filter_input(INPUT_POST, 'Password', FILTER_SANITIZE_STRING);

    CheckLogin(strtolower($Nickname), $Pwd);
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
                            <input type="text" name="Nickname" class="form-control col-5" id="exampleInputNickname" placeholder="Entrez votre pseudo">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mot de passe :</label>
                            <input type="password" name="Password" class="form-control col-5" id="exampleInputPassword1" placeholder="Entrez votre mot de passe">
                            <a href="forgottenpwd.php">Mot de passe oublié ?</a>
                        </div>
                        <button type="submit" name="connection" class="btn btn-primary">Se connecter</button>
                    </form>
                </div>
                <div class="col">
                    <section>
                        <?php
                        if (!empty($posts)):
                            foreach ($posts as $key => $value):
                                $hours = date('H:i', strtotime($value['datePost']));
                                $date = date('d-m-Y', strtotime($value['datePost']));
                                $nickname = getUserNicknameFromId($value['idUser']);
                                $file = getNameMediaInPostByIdPost($value['idComment']);
                                ?>
                                <article>
                                    <div class="card-deck" style="width: 20rem;">
                                        <?php if (!empty($file)): ?>
                                            <div class="card mt-3">
                                                <?php
                                                $extension = substr($file, -3);
                                                switch ($extension):
                                                    case 'png':
                                                        ?>
                                                        <img class = "card-img-top" alt = "" src = "./uploaded_files/<?= $file; ?>">
                                                        <?php
                                                        break;
                                                    case 'jpg':
                                                        ?>
                                                        <img class = "card-img-top" alt = "" src = "./uploaded_files/<?= $file; ?>">
                                                        <?php
                                                        break;
                                                    case 'peg':
                                                        ?>
                                                        <img class = "card-img-top" alt = "" src = "./uploaded_files/<?= $file; ?>">
                                                        <?php
                                                        break;
                                                    case 'mp3':
                                                        ?>
                                                        <audio class = "card-img-top" controls="">
                                                            <source src="./uploaded_files/<?= $file; ?>" type="audio/mpeg">
                                                        </audio>
                                                        <?php
                                                        break;
                                                    case 'mp4':
                                                        ?>
                                                        <video class = "card-img-top" autoplay="" loop="" controls="">
                                                            <source src="./uploaded_files/<?= $file; ?>" type="video/mp4">
                                                        </video>
                                                        <?php
                                                        break;
                                                    case 'gif':
                                                        ?>
                                                        <img class = "card-img-top" alt = "" src = "./uploaded_files/<?= $file; ?>">
                                                    <?php
                                                    default:
                                                        break;
                                                endswitch;
                                                ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $value['titleComment'] ?></h5>
                                                    <p class="card-text"><?= $value['commentary'] ?></p>
                                                    <p class="card-subtitle">
                                                        <small class="text-muted">
                                                            Posté le <?= $date; ?> à <?= $hours; ?> par <?= $nickname; ?>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
        <?php else: ?>
                                            <div class="card mt-3">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $value['titleComment'] ?></h5>
                                                    <p class="card-text"><?= $value['commentary'] ?></p>
                                                    <p class="card-subtitle">
                                                        <small class="text-muted">
                                                            Posté le <?= $date; ?> à <?= $hours; ?> par <?= $nickname; ?>
                                                        </small>
                                                    </p>
                                                </div>
                                            </div>
        <?php endif; ?>
                                    </div>
                                </article>
                                <?php
                            endforeach;
                        endif;
                        ?>
                    </section>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>
