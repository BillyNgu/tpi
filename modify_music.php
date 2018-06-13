<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : The admin can change the music in the db.
 */
require_once './dao/dao.php';

if (empty($_SESSION['user_nickname'])) {
    header('Location:index.php');
}

$nickname = $_SESSION['user_nickname'];
$userData = Get_user_data($nickname);
$crud = TRUE;
$music_id = filter_input(INPUT_GET, 'music_id', FILTER_VALIDATE_INT);
$music = Get_music($music_id);
$all_music_style = Get_music_style();
$musics_style = Get_music_style_by_music_id($music_id);

if (filter_has_var(INPUT_POST, "modify_music")) {
    $title = trim(filter_input(INPUT_POST, 'music_title', FILTER_SANITIZE_STRING));
    $author = trim(filter_input(INPUT_POST, 'music_author', FILTER_SANITIZE_STRING));
    $style = filter_input(INPUT_POST, 'music_style', FILTER_VALIDATE_INT);
    $cover = "";
    $music_file = "";

    $errors_modify_music = [];

    $uploadOk_cover = 1;
    $target_dir_cover = "./uploaded_files/img/cover/";
    $target_file_cover = $target_dir_cover . basename($music['music_id'] . "-" . $_FILES["cover"]["name"]);
    $FileType_cover = strtolower(pathinfo($target_file_cover, PATHINFO_EXTENSION));

    $uploadOk_song = 1;
    $target_dir_song = "./uploaded_files/songs/";
    $target_file_song = $target_dir_song . basename($music['music_id'] . "-" . $_FILES["song"]["name"]);
    $FileType_song = strtolower(pathinfo($target_file_song, PATHINFO_EXTENSION));

    if (!empty($_FILES['cover'])) {
        // Allow certain file formats
        if ($FileType_cover != "jpg" && $FileType_cover != "png" && $FileType_cover != "jpeg" && $FileType_cover != "gif") {
            $uploadOk_cover = 0;
        }

        // if everything is ok, try to upload file
        if ($uploadOk_cover == 1) {
            move_uploaded_file($_FILES["cover"]["tmp_name"], $target_file_cover);
        }
    }

    if (!empty($_FILES['song'])) {
        // Allow certain file formats
        if ($FileType_song != "mp3" && $FileType_song != "m4a" && $FileType_song != "ogg") {
            $uploadOk_song = 0;
        }

        // if everything is ok, try to upload file
        if ($uploadOk_song == 1) {
            move_uploaded_file($_FILES["song"]["tmp_name"], $target_file_song);
        }
    }

    if (empty($_FILES["cover"]["name"])) {
        $cover = $_FILES["cover"]["name"];
    } else {
        $cover = $music['music_id'] . "-" . $_FILES["cover"]["name"];
    }

    if (empty($_FILES['song']['name'])) {
        $music_file = $_FILES['song']['name'];
    } else {
        $music_file = $music['music_id'] . "-" . $_FILES['song']['name'];
    }

    if (empty($title)) {
        $errors_modify_music['music_title'] = "Le titre ne peut pas être vide.";
    }

    if (empty($author)) {
        $errors_modify_music['music_author'] = "L'auteur ne peut pas être vide.";
    }

    if (empty($errors_modify_music)) {
        Update_music($music['music_id'], $title, $author, $music_file, $cover, $music['music_file'], $music['music_cover']);
        Update_music_style($style, $music_id);
        header('Location:crud_option.php');
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
            <h2>Modification de la musique</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">      
                    <div class="row">
                        <div class="col">
                            <label>
                                Titre de la musique : 
                                <input type="text" name="music_title" class="form-control" value="<?= $music['music_title']; ?>">
                            </label>
                            <?php
                            if (!empty($errors_modify_music['music_title'])) {
                                echo $errors_modify_music['music_title'];
                            }
                            ?>
                        </div>
                        <div class="col">
                            <label>
                                Auteur de la musique : 
                                <input name="music_author" class="form-control" value="<?= $music['music_author']; ?>">
                            </label>
                            <?php
                            if (!empty($errors_modify_music['music_author'])) {
                                echo $errors_modify_music['music_author'];
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        Le morceau (16 Mo max) : <input class="form-control-file" name="song" type="file" accept="audio/*">
                    </label>
                    <label>
                        La pochette d'album (optionnel) : <input class="form-control-file" name="cover" type="file" accept="image/*">
                    </label>
                    <label>
                        Style de musique : 
                        <select name="music_style">
                            <?php foreach ($all_music_style as $value_music_style): ?>
                                <option 
                                <?php if ($value_music_style['music_style_id'] == $musics_style): ?>
                                        selected="" <?php endif; ?> value="
                                    <?= $value_music_style['music_style_id']; ?>">
                                        <?= $value_music_style['music_style']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <a class="btn btn-primary" href="crud_option.php">Retour</a>
                <input class="btn btn-primary" name="modify_music" type="submit" value="Modifier"/>
            </form>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
