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
function Create_user($name, $nickname, $email, $pwd, $profilepic) {
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
    SetFlashMessage("Compte créé.");
}

/**
 * Check the login
 * @param type $nickname nickname of the user
 * @param type $pwd password of the user
 */
function Check_login($nickname, $pwd) {
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
function Get_user_data($nickname) {
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
function Update_profile_picture($nickname, $picture, $old_picture) {
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
        SetFlashMessage("Image ajoutée.");
    } else {
        opendir($target_dir);
        unlink($target_file);

        $sql = "UPDATE `users` SET `user_profilepic`= :picture_name WHERE `user_nickname` = :nickname";
        $query = pdo()->prepare($sql);
        $query->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $query->bindParam(':picture_name', $picture_unique_name, PDO::PARAM_STR);
        $query->execute();
        SetFlashMessage("Image modifiée.");
    }
}

/**
 * Add music into the db
 * @param type $music_title the title of the music
 * @param type $music_author some information of the music
 */
function Add_music($music_title, $music_author, $music_style_id) {
    if (!empty(Check_music($music_title))) {
        SetFlashMessage("La musique existe déjà.");
    } else {
        $sql = "INSERT INTO `music`(`music_title`, `music_author`, `music_style_id`) "
                . "VALUES (:music_title, :music_author, :music_style_id)";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_INT);
        $query->execute();
        SetFlashMessage("Musique ajoutée.");
    }
}

/**
 * Add music style
 * @param type $style a style of music
 */
function Add_music_style($style) {
    $sql = "INSERT INTO `music_style`(`music_style`) VALUES (:style)";
    $query = pdo()->prepare($sql);
    $query->bindParam(':style', $style, PDO::PARAM_STR);
    $query->execute();
    SetFlashMessage('Style ajouté.');
}

/**
 * Get all music style from db
 * @return type array
 */
function Get_music_style() {
    $sql = "SELECT * FROM `music_style`";
    $query = pdo()->prepare($sql);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Check if the music already exists in db
 * @param type $music_title string
 */
function Check_music($music_title) {
    $sql = "SELECT `music_title` FROM `music` WHERE `music_title` = :music_title";
    $query = pdo()->prepare($sql);
    $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Update the music by its ID
 * @param type $music_id the id of the music which will be modified
 * @param type $music_title the title of the music
 * @param type $music_author the author of the music
 * @param type $music_file the dir of the song file
 * @param type $music_cover the dir of the cover
 */
function Update_music($music_id, $music_title, $music_author, $music_file, $music_cover, $music_style_id, $old_music_file, $old_music_cover) {
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

        $sql = "UPDATE `music` SET `music_title`=:music_title, `music_author`=:music_author, "
                . "`music_file`=:music_file,`music_cover`=:music_cover, `music_style_id`=:music_style_id WHERE `music_id` = :music_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->bindParam(':music_file', $music_file, PDO::PARAM_STR);
        $query->bindParam(':music_cover', $music_cover, PDO::PARAM_STR);
        $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_STR);
        $query->execute();
    } elseif (!empty($music_file)) {
        if (!empty($old_music_file)) {
            opendir($target_dir_file);
            unlink($target_music_file);
        }

        $sql = "UPDATE `music` SET `music_title`=:music_title, `music_author`=:music_author, "
                . "`music_file`=:music_file, `music_style_id`=:music_style_id WHERE `music_id` = :music_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->bindParam(':music_file', $music_file, PDO::PARAM_STR);
        $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_STR);
        $query->execute();
    } elseif (!empty($music_cover)) {
        if (!empty($old_music_cover)) {
            opendir($target_dir_cover);
            unlink($target_music_cover);
        }

        $sql = "UPDATE `music` SET `music_title`=:music_title, `music_author`=:music_author, "
                . "`music_cover`=:music_cover, `music_style_id`=:music_style_id WHERE `music_id` = :music_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->bindParam(':music_cover', $music_cover, PDO::PARAM_STR);
        $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_STR);
        $query->execute();
    } else {
        $sql = "UPDATE `music` SET `music_title`=:music_title, `music_author`=:music_author, "
                . "`music_style_id`=:music_style_id WHERE `music_id` = :music_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
        $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
        $query->bindParam(':music_author', $music_author, PDO::PARAM_STR);
        $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_STR);
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
 * Return 4 random musics from db 
 * @param type $game_id int the game the user is playing
 * @param type $music_style_id int the music style
 * @return type array
 */
function Get_all_music_random($game_id, $music_style_id) {
    // $sql = "SELECT * FROM `music` WHERE `music_id` NOT IN (SELECT `music_id` FROM `game` WHERE `game_id` = game_id)";
    // $sql = "SELECT * FROM `music` WHERE `music_id` IN (SELECT `music_id` FROM `game` WHERE `game_id` = :game_id)";
    if ($music_style_id != 1) {
        $sql = "SELECT * FROM `music` WHERE `music_id` NOT IN(SELECT `music_id` FROM `game` WHERE `game_id` = :game_id) AND "
                . "`music_style_id` IN (SELECT `music_style_id` FROM `music` WHERE `music_style_id` = :music_style_id) ORDER BY RAND() LIMIT 4";
    } else {
        $sql = "SELECT * FROM `music` WHERE `music_id` NOT IN(SELECT `music_id` FROM `game` WHERE `game_id` = :game_id) ORDER BY RAND() LIMIT 4";
    }
    $query = pdo()->prepare($sql);
    $query->bindParam(':game_id', $game_id, PDO::PARAM_INT);
    if ($music_style_id != 1) {
        $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_INT);
    }
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get music_id with its dir
 * @param type $music_file the dir of the music file
 * @return type array
 */
function Get_music_id_by_file($music_file) {
    $sql = "SELECT `music_id` FROM `music` WHERE `music_file` = :music_file";
    $query = pdo()->prepare($sql);
    $query->bindParam(':music_file', $music_file, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC)['music_id'];
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

    $sql = "DELETE FROM `music` WHERE `music_id` = :music_id";
    $query = pdo()->prepare($sql);
    $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
    $query->execute();

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
 * @param type $user_id the id of the user
 * @param type $music_style_id the music style
 */
function Save_parameters($question_time, $questions_number, $user_id, $music_style_id) {
    if (!empty(Get_parameters($user_id))) {
        // Check if parameters exist for the user, if it doesn't insert, else update
        $sql = "UPDATE `parameters` SET "
                . "`parameters_time`=:question_time, `parameters_questions_number`=:questions_number, `music_style_id`=:music_style_id "
                . "WHERE `user_id` =:user_id";
        $query = pdo()->prepare($sql);
        $query->bindParam(':question_time', $question_time, PDO::PARAM_INT);
        $query->bindParam(':questions_number', $questions_number, PDO::PARAM_INT);
        $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
        SetFlashMessage("Paramètres enregistrés.");
    } else {
        $sql = "INSERT INTO `parameters`(`parameters_time`, `parameters_questions_number`, `user_id`, `music_style_id`) "
                . "VALUES (:question_time, :questions_number, :user_id, :music_style_id)";
        $query = pdo()->prepare($sql);
        $query->bindParam(':question_time', $question_time, PDO::PARAM_INT);
        $query->bindParam(':questions_number', $questions_number, PDO::PARAM_INT);
        $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_INT);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();
    }
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

/**
 * Return the music style name with its id
 * @param type $music_style_id
 * @return type array
 */
function Get_music_style_by_id($music_style_id) {
    $sql = "SELECT * FROM `music_style` WHERE `music_style_id` = :music_style_id";
    $query = pdo()->prepare($sql);
    $query->bindParam(':music_style_id', $music_style_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC)['music_style'];
}

/**
 * Return true or false if the audio is the same as the answer
 * @param type string. $q_answer The answer the user chooses
 * @param type string. $q_audio The audio file that was playing
 * @return boolean
 */
function check_answer($q_answer, $q_audio) {
    $sql = "SELECT `music_title` FROM `music` WHERE `music_file` = :q_audio";
    $query = pdo()->prepare($sql);
    $query->bindParam(':q_audio', $q_audio, PDO::PARAM_STR);
    $query->execute();

    if ($query->fetch(PDO::FETCH_ASSOC)['music_title'] == $q_answer) {
        return TRUE;
    } else {
        return FALSE;
    }
}

/**
 * Add score into db based on the user and its parameters
 * @param type $score int. The score of the user.
 * @param type $score_question int. The number of questions of the quizz.
 * @param type $user_id int. The user
 */
function Add_score($score, $score_question, $user_id) {
    $sql = "INSERT INTO `score`(`score`, `score_questions_number`, `user_id`) "
            . "VALUES (:score, :score_question, :user_id)";
    $query = pdo()->prepare($sql);
    $query->bindParam(':score', $score, PDO::PARAM_INT);
    $query->bindParam(':score_question', $score_question, PDO::PARAM_INT);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
}

/**
 * Return the score of the user
 * @param type $user_id the id of the user
 * @return type array
 */
function Get_score($user_id) {
    $sql = "SELECT * FROM `score` WHERE `user_id` = :user_id";
    $query = pdo()->prepare($sql);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Create a game
 * @return type int
 */
function Create_game() {
    $sql = "SELECT COALESCE(MAX(`game_id`), 0) + 1 as `game_id` FROM `game`";
    $query = pdo()->prepare($sql);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC)['game_id'];
}

/**
 * Add game
 * @param type $game_id game_id from Create_game()
 * @param type $user_id the user id
 * @param type $music_id the music_id
 */
function Add_game($game_id, $user_id, $music_id) {
    $sql = "INSERT INTO `game`(`game_id`, `user_id`, `music_id`) VALUES (:game_id, :user_id, :music_id)";
    $query = pdo()->prepare($sql);
    $query->bindParam(':game_id', $game_id, PDO::PARAM_INT);
    $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
    $query->execute();
}
