<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Add music into the database 
 */
require_once './dao/dao.php';

// Prevent user to access page without being logged
if (empty($_SESSION['user_nickname'])) {
    header('Location:index.php');
}

// Initialize var
$nickname = $_SESSION['user_nickname'];
$userData = Get_user_data($nickname);
$crud = TRUE;
$all_music_style = Get_music_style();

// If the button is clicked
if (filter_has_var(INPUT_POST, "add_music")) {
    // Input value
    $title = trim(filter_input(INPUT_POST, 'music_title', FILTER_SANITIZE_STRING));
    $author = trim(filter_input(INPUT_POST, 'music_author', FILTER_SANITIZE_STRING));
    $style = filter_input(INPUT_POST, 'music_style', FILTER_VALIDATE_INT);
    $cover = "";
    $song = "";

    $errors_add_music = [];
    $errors_add_file_cover = [];
    
    // Check errors
    if (empty($title)) {
        $errors_add_music['music_title'] = "Le titre ne peut pas être vide.";
    }
    if (empty($author)) {
        $errors_add_music['music_author'] = "L'auteur ne peut pas être vide.";
    }

    if (empty($errors_add_music)) {
        Add_music($title, $author, $style);
    }

    // Initialize file input var
    $music = Get_last_music();
    $uploadOk_cover = 1;
    $target_dir_cover = "./uploaded_files/img/cover/";
    $target_file_cover = $target_dir_cover . basename($music['music_id'] . "-" . $_FILES["cover"]["name"]);
    $FileType_cover = strtolower(pathinfo($target_file_cover, PATHINFO_EXTENSION));

    $uploadOk_song = 1;
    $target_dir_song = "./uploaded_files/songs/";
    $target_file_song = $target_dir_song . basename($music['music_id'] . "-" . $_FILES["song"]["name"]);
    $FileType_song = strtolower(pathinfo($target_file_song, PATHINFO_EXTENSION));
    
    // Check errors
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

    if (!empty($_FILES["cover"]["name"])) {
        $cover = $music['music_id'] . "-" . $_FILES["cover"]["name"];
    } else {
        $cover = NULL;
    }

    if (!empty($_FILES['song']['name'])) {
        $song = $music['music_id'] . "-" . $_FILES["song"]['name'];
    }


    if (empty($song)) {
        $errors_add_file_cover['song'] = "Il ne peut pas ne pas y avoir de musique.";
    }
    
    // If no errors
    if (empty($errors_add_file_cover)) {
        Add_file_cover($music['music_id'], $song, $cover);
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
            <h2>Ajout d'une musique</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">      
                    <div class="row">
                        <div class="col">
                            <label>Titre de la musique : <input type="text" name="music_title" class="form-control"></label>
                            <?php
                            if (!empty($errors_add_music['music_title'])) {
                                echo $errors_add_music['music_title'];
                            }
                            ?>
                        </div>
                        <div class="col">
                            <label>Auteur de la musique : <input name="music_author" class="form-control"></label>
                            <?php
                            if (!empty($errors_add_music['music_author'])) {
                                echo $errors_add_music['music_author'];
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Le morceau (16 Mo max) : <input class="form-control-file" name="song" type="file" accept="audio/*"></label>
                    <?php if (!empty($errors_add_file_cover['song'])): ?>
                        <p><?= $errors_add_file_cover['song']; ?></p>
                    <?php endif; ?> 
                    <label>La pochette d'album (optionnel) : <input class="form-control-file" name="cover" type="file" accept="image/*"></label>
                    <label>Style de musique : <select name="music_style">
                            <?php foreach ($all_music_style as $value_music_style): ?>
                                <option 
                                    <?php if ($value_music_style['music_style_id'] == 2): ?> selected="" 
                                    <?php endif; ?> value="
                                    <?= $value_music_style['music_style_id']; ?>"><?= $value_music_style['music_style']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <a class="btn btn-primary" href="crud_option.php">Retour</a>
                <input class="btn btn-primary" name="add_music" type="submit" value="Ajouter"/>
                <?= GetFlashMessage(); ?>
                <div class="form-group">
                    <a class="float-right btn btn-primary" href="add_music_style.php">Ajouter un style de musique</a>
                </div>
            </form>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
