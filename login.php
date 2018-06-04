<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-01-31
 * Titre : Forum
 * Description : Forum PHP
 */
require_once './dao/dao.php';

$nickname = $_SESSION['pseudo'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>VidéoQuizz</title>
        <?php require_once './css/css_js.php'; ?>
    </head>
    <body>
        <div class="container">
            <?php require_once './navbar.php'; ?>
            <?php if (!empty($message)) : ?>
                <p><?= $message; ?></p>
            <?php endif; ?>
            <section>
                <?php
                if (!empty($postsPerID)):
                    foreach ($postsPerID as $key => $value):
                        $hours = date('H:i', strtotime($value['datePost']));
                        $date = date('d-m-Y', strtotime($value['datePost']));
                        if ($value['modifyDate'] != NULL) {
                            $modifDate = date('d-m-Y', strtotime($value['modifyDate']));
                            $modifHours = date('H:i', strtotime($value['modifyDate']));
                        }
                        $file = getNameMediaInPostByIdPost($value['idComment']);
                        ?>
                        <article>
                            <?php if (!empty($file)): ?>
                                <div class="card mt-3" style="width: 30rem;">
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
                                        <h5><?= $value['titleComment']; ?></h5>
                                        <p><?= $value['commentary']; ?></p>
                                        <p class="card-subtitle">
                                            <small class="text-muted">
                                                Posté le <?= $date; ?> à <?= $hours; ?>. Modifié le <?= $modifDate; ?> à <?= $modifHours; ?>
                                            </small>
                                        </p>
                                        <a href="modifyPost.php?idComment=<?= $value['idComment']; ?>">Modifier</a> | <a href="deletePost.php?idComment=<?= $value['idComment'] ?>">Supprimer</a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="card mt-3" style="width: 30rem;">
                                    <div class="card-body">
                                        <h5><?= $value['titleComment']; ?></h5>
                                        <p><?= $value['commentary']; ?></p>
                                        <p class="card-subtitle">
                                            <small class="text-muted">
                                                Posté le <?= $date; ?> à <?= $hours; ?>
                                            </small>
                                        </p>
                                        <a href="modifyPost.php?idComment=<?= $value['idComment']; ?>">Modifier</a> | <a href="deletePost.php?idComment=<?= $value['idComment'] ?>">Supprimer</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </article>
                        <?php
                    endforeach;
                endif;
                ?>
            </section>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>
