<?php

/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Script of functions
 */

require_once './dao/mySql.inc.php';
require_once './dao/connectionBase.php';
require_once './dao/flashmessage.php';

/**
 * Create a user
 * @param type $name name of the user
 * @param type $nickname nickname of the user
 * @param type $email email of the user
 * @param type $pwd password of the user
 * @param type $profilepic profile picture of the user
 */
function CreateUser($name, $nickname, $email, $pwd, $profilepic) {
    $sql = "INSERT INTO `users`(`user_name`, `user_nickname`, `user_email`, `user_password`, `user_profilepic`, `user_status`) "
            . "VALUES (:name, :nickname, :email, :pwd, :profilepic, 0)";

    $pwdsha1 = sha1($pwd);
    if (!empty($profilepic)) {
        $profilepic_unique = $nickname . "-" . $profilepic;
    } else {
        $profilepic_unique = null;
    }

    $query = pdo()->prepare($sql);
    $query->bindParam(':name', $name, PDO::PARAM_STR);
    $query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':pwd', $pwdsha1, PDO::PARAM_STR);
    $query->bindParam(':profilepic', $profilepic_unique, PDO::PARAM_STR);
    $query->execute();
}

/**
 * Check the login
 * @param type $nickname nickname of the user
 * @param type $pwd password of the user
 */
function CheckLogin($nickname, $pwd) {
    $sql = "SELECT `user_nickname`, `user_password` FROM `users` WHERE `user_nickname` = :nickname AND `user_password` = :pwd";
    $query = pdo()->prepare($sql);

    $pwdsha1 = sha1($pwd);

    $query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
    $query->bindParam(':pwd', $pwdsha1, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($nickname === $user['user_nickname'] && $pwdsha1 === $user['user_password']) {
        $_SESSION['user_nickname'] = $nickname;
        header('Location:profile.php');
    } else {
        $_SESSION['user_nickname'] = "";
        return FALSE;
    }
}

/**
 * Get data of the user
 * @param type $nickname nickname of the user
 */
function GetData($nickname) {
    $sql = "SELECT * FROM `users` WHERE `user_nickname` = :nickname";
    $query = pdo()->prepare($sql);
    $query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Update the profile picture of a user
 * @param type $nickname nickname of the user
 * @param type $picture new picture of the profile
 * @param type $old_picture old picture of the profile
 */
function UpdateProfilePicture($nickname, $picture, $old_picture) {
    $target_dir = "./uploaded_files/img/profile/";
    $target_file = $target_dir . $old_picture;

    $picture_unique_name = $nickname . "-" . $picture;

    // if there isn't an image in the database, update the record
    // if there is, remove the old image + the file and update the record
    if (empty($old_picture)) {
        $sql = "UPDATE `users` SET `user_profilepic`= :picture_name WHERE `user_nickname` = :nickname";
        $query = pdo()->prepare($sql);
        $query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $query->bindParam(':picture_name', $picture_unique_name, PDO::PARAM_STR);
        $query->execute();
        header("Refresh:0");
    } else {
        opendir($target_dir);
        unlink($target_file);

        $sql2 = "UPDATE `users` SET `user_profilepic`= :picture_name WHERE `user_nickname` = :nickname";
        $query2 = pdo()->prepare($sql2);
        $query2->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $query2->bindParam(':picture_name', $picture_unique_name, PDO::PARAM_STR);
        $query2->execute();
        header("Refresh:0");
    }
}

/**
 * Add music into the db
 * @param type $music_title the title of the music
 * @param type $music_author some information of the music
 */
function Add_Music($music_title, $music_author) {

    if (!empty(Check_music($music_title))) {
        SetFlashMessage("La musique existe déjà.");
    } else {
        $sql = "INSERT INTO `music`(`music_title`, `music_author`) "
                . "VALUES (:music_title, :music_author)";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->execute();
        SetFlashMessage("Musique ajoutée.");
    }
}

/**
 * Check if the music already exists in db
 * @param type $music_title string
 */
function Check_music($music_title) {
    $sql = "SELECT `music_title` WHERE `music_title` = :music_title";
    $query = pdo()->prepare($sql);
    $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
    $query->execute();
}

/**
 * Update the music by its ID
 * @param type $music_id the id of the music which will be modified
 * @param type $music_title the title of the music
 * @param type $music_author the author of the music
 * @param type $music_file the dir of the song file
 * @param type $music_cover the dir of the cover
 */
function Update_music($music_id, $music_title, $music_author, $music_file, $music_cover, $old_music_file, $old_music_cover) {
    $target_dir_file = "./uploaded_files/songs/";
    $target_music_file = $target_dir_file . $old_music_file;

    $target_dir_cover = "./uploaded_files/img/cover/";
    $target_music_cover = $target_dir_cover . $old_music_cover;

    if (!empty($music_file) && !empty($music_cover)) {
        if (!empty($old_music_file) && !empty($old_music_cover)) {
            opendir($target_dir_file);
            unlink($target_music_file);
            opendir($target_dir_cover);
            unlink($target_music_cover);
        }

        $sql = "UPDATE `music` SET `music_title`=:music_title, `music_author`=:music_author,`music_file`=:music_file,`music_cover`=:music_cover WHERE `music_id` = :music_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->bindParam(':music_file', $music_file, PDO::PARAM_STR);
        $query->bindParam(':music_cover', $music_cover, PDO::PARAM_STR);
        $query->execute();
    } elseif (!empty($music_file)) {
        if (!empty($old_music_file)) {
            opendir($target_dir_file);
            unlink($target_music_file);
        }

        $sql = "UPDATE `music` SET `music_title`=:music_title, `music_author`=:music_author,`music_file`=:music_file WHERE `music_id` = :music_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->bindParam(':music_file', $music_file, PDO::PARAM_STR);
        $query->execute();
    } elseif (!empty($music_cover)) {
        if (!empty($old_music_cover)) {
            opendir($target_dir_cover);
            unlink($target_music_cover);
        }

        $sql = "UPDATE `music` SET `music_title`=:music_title, `music_author`=:music_author, `music_cover`=:music_cover WHERE `music_id` = :music_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->bindParam(':music_cover', $music_cover, PDO::PARAM_STR);
        $query->execute();
    } else {
        $sql = "UPDATE `music` SET `music_title`=:music_title, `music_author`=:music_author WHERE `music_id` = :music_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->execute();
    }
}

/**
 * Return all of the last record
 * @return type array
 */
function Get_last_music() {
    $sql = "SELECT * FROM `music` WHERE `music_id` = (SELECT MAX(`music_id`) FROM `music`)";
    $query = pdo()->prepare($sql);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Add the dir of the cover and the file
 * @param type $music_id the id of the music
 * @param type $music_file the dir of the file
 * @param type $music_cover the dir of the cover
 */
function Add_file_cover($music_id, $music_file, $music_cover) {
    $sql = "UPDATE `music` SET `music_file`= :music_file, `music_cover`= :music_cover WHERE `music_id` = :music_id";
    $query = pdo()->prepare($sql);
    $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
    $query->bindParam(':music_file', $music_file, PDO::PARAM_STR);
    $query->bindParam(':music_cover', $music_cover, PDO::PARAM_STR);
    $query->execute();
}

/**
 * Add music style
 * @param type $style a style of music
 */
function Add_Music_Style($style) {
    $sql = "INSERT INTO `music_style`(`music_style`) VALUES (:style)";
    $query = pdo()->prepare($sql);
    $query->bindParam(':style', $style, PDO::PARAM_STR);
    $query->execute();
}

/**
 * Return all music
 * @return type array
 */
function Get_all_music() {
    $sql = "SELECT * FROM `music`";
    $query = pdo()->prepare($sql);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Return the value of the specified record
 * @param type $music_id the linked music
 * @return type array
 */
function Get_music($music_id) {
    $sql = "SELECT * FROM `music` WHERE `music_id` = :music_id";
    $query = pdo()->prepare($sql);
    $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Delete de music in db and in dir
 * @param type $music_id the id of the music
 * @param type $music_cover the dir of the cover
 * @param type $music_file the dir of the file
 */
function Delete_music($music_id, $music_cover, $music_file) {
    $target_dir_cover = "./uploaded_files/img/cover/";
    $target_file_cover = $target_dir_cover . $music_cover;
    $target_dir_song = "./uploaded_files/songs/";
    $target_file_song = $target_dir_song . $music_file;

    $sql3 = "DELETE FROM `music` WHERE `music_id` = :music_id";
    $query3 = pdo()->prepare($sql3);
    $query3->bindParam(':music_id', $music_id, PDO::PARAM_INT);
    $query3->execute();

    if (!empty($music_cover)) {
        opendir($target_dir_cover);
        unlink($target_file_cover);
        closedir($target_dir_cover);
    }
    if (!empty($music_file)) {
        opendir($target_dir_song);
        unlink($target_file_song);
        closedir($target_dir_song);
    }
}

/**
 * Save parameters to play
 * @param type $question_time the time of each question in second
 * @param type $questions_number the number of questions the user will be asked
 * @param type $question_type the type of question the user wants to play (1 for songs, 2 for album cover)
 * @param type $user_id the id of the user
 */
function Save_parameters($question_time, $questions_number, $question_type, $user_id) {
    // Check if parameters exist for the user, if it doesn't insert, else update
    if (!empty(Get_parameters($user_id))) {
        $sql = "UPDATE `parameters` SET `parameters_time`=:question_time, `parameters_questions_number`=:questions_number, "
                . "`parameters_type`=:question_type WHERE `user_id` =:user_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':question_time', $question_time, PDO::PARAM_INT);
        $query->bindParam(':questions_number', $questions_number, PDO::PARAM_INT);
        $query->bindParam(':question_type', $question_type, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
    } else {
        $sql = "INSERT INTO `parameters`(`parameters_time`, `parameters_questions_number`, `parameters_type`, `user_id`) "
                . "VALUES (:question_time, :questions_number, :question_type, :user_id)";
        $query = pdo()->prepare($sql);
        $query->bindParam(':question_time', $question_time, PDO::PARAM_INT);
        $query->bindParam(':questions_number', $questions_number, PDO::PARAM_INT);
        $query->bindParam(':question_type', $question_type, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
    }
    SetFlashMessage("Paramètres enregistrés");
}

/**
 * Check if there is a parameter linked to a user
 * @param type $user_id the id of the user
 * @return type array
 */
function Get_parameters($user_id) {
    $sql = "SELECT * FROM `parameters` WHERE `user_id` = :user_id";
    $query = pdo()->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}