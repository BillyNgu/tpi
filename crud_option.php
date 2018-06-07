<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : Page d'affichage des différentes possibilités
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
$crud = TRUE;
$music = Get_all_music();

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
            <table class="table table-bordered table-hover">
                <tr>
                    <th class="text-center">Pochette d'album</th>
                    <th class="text-center">Titre</th>
                    <th class="text-center">Auteur</th>
                    <th class="text-center">Morceau</th>
                    <th class="text-center">Modifier / Supprimer</th>
                    <th class="text-center"><a class="btn btn-outline-primary" href="add_music.php">Ajouter</a></th>
                </tr>
                <?php
                foreach ($music as $value):
                    $extension = substr($value['music_file'], -3);
                    ?>
                    <tr>
                        <td class="text-center"><img height="150" width="150" class="img-thumbnail" src="./uploaded_files/img/cover/<?php if (empty($value['music_cover'])): ?>No_Cover.jpg<?php else: echo $value['music_cover'];
                endif; ?>" alt="<?php echo $value['music_cover']; ?>"></td>
                        <td class="text-center"><?php echo $value['music_title']; ?></td>
                        <td class="text-center"><?php echo $value['music_author']; ?></td>
                        <td class="text-center">
                            <audio controls=""><source src="./uploaded_files/songs/<?php echo $value['music_file']; ?>" type="audio/<?= $extension; ?>"
                            </audio>
                        </td>
                        <td class="text-center"><a href="modify_music.php?music_id=<?=$value['music_id']; ?>" class="btn btn-outline-primary">Modifier</a> <a class="btn btn-outline-danger" href="delete_music.php?music_id=<?=$value['music_id']; ?>">Supprimer</a></td>
                        <td></td>
                    </tr>
<?php endforeach; ?>
            </table>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
