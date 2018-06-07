<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : CRUD admin
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
$crud = TRUE;

if (filter_has_var(INPUT_POST, "add_question")) {
    $title = trim(filter_input(INPUT_POST, 'music_title', FILTER_SANITIZE_STRING));
    $description = trim(filter_input(INPUT_POST, 'music_description', FILTER_SANITIZE_STRING));

    $choice1 = trim(filter_input(INPUT_POST, 'choice1', FILTER_SANITIZE_STRING));
    $choice2 = trim(filter_input(INPUT_POST, 'choice2', FILTER_SANITIZE_STRING));
    $choice3 = trim(filter_input(INPUT_POST, 'choice3', FILTER_SANITIZE_STRING));
    $choice4 = trim(filter_input(INPUT_POST, 'choice4', FILTER_SANITIZE_STRING));

    $choice = [$choice1, $choice2, $choice3, $choice4];
    $answer = filter_has_var(INPUT_POST, 'answer');

    $uploadOk_cover = 1;
    $target_dir_cover = "./uploaded_files/img/cover/";
    $target_file_cover = $target_dir_cover . basename($title . "-" . $_FILES["cover"]["name"]);
    $FileType_cover = strtolower(pathinfo($target_file_cover, PATHINFO_EXTENSION));

    $uploadOk_song = 1;
    $target_dir_song = "./uploaded_files/songs/";
    $target_file_song = $target_dir_song . basename($nickname . "-" . $_FILES["song"]["name"]);
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
        if ($FileType_song != "mp3" && $FileType_song != "m4a" && $FileType_song != "ogg" && $FileType_song != "flac") {
            $uploadOk_song = 0;
        }

        // if everything is ok, try to upload file
        if ($uploadOk_song == 1) {
            move_uploaded_file($_FILES["song"]["tmp_name"], $target_file_song);
        }
    }
    Add_Music($title, $description, $nickname . "-" . $_FILES["song"]["name"], $title . "-" . $_FILES["cover"]["name"]);
    $last_music = Get_last_music();
    // Add these value in db
    for ($index = 0; $index < count($choice); $index++) {
        Add_Choice($choice[$index], $last_music['music_id']);
    }
    Add_answer($last_music['music_id'], $_POST['answer']);
    var_dump($last_music['music_id']);
    var_dump($_POST['answer']);
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
            <h2>Configuration des questions</h2>
            <form method="post" action="" enctype="multipart/form-data">
                <div class="form-group">      
                    <div class="row">
                        <div class="col">
                            <label>Titre de la musique : <input required="" type="text" name="music_title" class="form-control"></label>
                        </div>
                        <div class="col">
                            <label>
                                Description de la musique : <textarea required="" name="music_description" class="form-control"></textarea>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col">
                            <label>Proposition 1 : <input required="" class="form-control" name="choice1" type="text"></label>
                            <label><input type="radio" name="answer" value="1" checked="checked" /> En faire la réponse.</label>
                        </div>
                        <div class="col">
                            <label>Proposition 2 : <input required="" class="form-control" name="choice2" type="text"></label>
                            <label><input type="radio" name="answer" value="2" /> En faire la réponse.</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label>Proposition 3 : <input required="" class="form-control" name="choice3" type="text"></label>
                            <label><input type="radio" name="answer" value="3" /> En faire la réponse.</label>
                        </div>
                        <div class="col">
                            <label>Proposition 4 : <input required="" class="form-control" name="choice4" type="text"></label>
                            <label><input type="radio" name="answer" value="4" /> En faire la réponse.</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Le morceau : <input required="" class="form-control-file" name="song" type="file" accept="audio/*"></label>
                    <label>La pochette d'album (optionnel) : <input class="form-control-file" name="cover" type="file" accept="image/*"></label>
                </div>
                <a class="btn btn-primary" href="crud_option.php">Retour</a>
                <input class="btn btn-primary" name="add_question" type="submit" value="Ajouter"/>
            </form>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
