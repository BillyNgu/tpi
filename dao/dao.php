<?php

/*
 * Authors : Nguyen Billy
 * Description : Functions
 * Date : 2018-06-04
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
 * Get data from db with nickname
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

function Add_Question($question) {
    $sql = "INSERT INTO `quizz`(`quizz_question`) VALUES (:question)";
    $query = pdo()->prepare($sql);
    $query->bindParam(':question', $question, PDO::PARAM_STR);
    $query->execute();
}

/**
 * Get all information of the last record inserted
 * @return type array
 */
function Get_last_question() {
    $sql = "SELECT * FROM `quizz` WHERE `quizz_id` = (SELECT MAX(`quizz_id`) FROM `quizz`)";
    $query = pdo()->prepare($sql);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function Add_Choice($choice1, $choice2, $choice3, $choice4, $answer, $question_id) {
    $sql = "INSERT INTO `choice`(`choice`, `choice_is_answer`, `quizz_id`) "
            . "VALUES (:choice, :answer, :question_id)";
    $query = pdo()->prepare($sql);

    $query->bindParam(':choice1', $choice1, PDO::PARAM_STR);
    $query->bindParam(':choice2', $choice2, PDO::PARAM_STR);
    $query->bindParam(':choice3', $choice3, PDO::PARAM_STR);
    $query->bindParam(':choice4', $choice4, PDO::PARAM_STR);



//    $query->bindParam(':answer', $answer, PDO::PARAM_INT);
    $query->bindParam(':question_id', $question_id, PDO::PARAM_INT);

    $choice = [':choice1', ':choice2', ':choice3', ':choice4'];

    for ($index = 0; $index < count($choice); $index++) {
        switch ($answer) {
            case 1:
                $answer = 1;
                break;
            case 2:
                $answer = 1;
                break;
            case 3:
                $answer = 1;
                break;
            case 4:
                $answer = 1;
                break;
            default:
                $answer = 0;
                break;
        }
        $query->bindParam(':answer', $answer, PDO::PARAM_INT);
        $query->bindParam(':choice', $choice[$index], PDO::PARAM_STR);
        $query->execute();
    }
}

function Add_Music($music_title, $music_description, $music_file, $music_cover) {
    $sql = "INSERT INTO `music`(`music_title`, `music_description`, `music_file`, `music_cover`) "
            . "VALUES (:music_title, :music_description, :music_file, :music_cover)";
    $query = pdo()->prepare($sql);
    $query->bindParam(':music_title', $music_title, PDO::PARAM_STR);
    $query->bindParam(':music_description', $music_description, PDO::PARAM_STR);
    $query->bindParam(':music_file', $music_file, PDO::PARAM_STR);
    $query->bindParam(':music_cover', $music_cover, PDO::PARAM_STR);
    $query->execute();
}

function Get_last_music() {
    $sql = "SELECT * FROM `music` WHERE `music_id` = (SELECT MAX(`music_id`) FROM `music`)";
    $query = pdo()->prepare($sql);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function Add_Music_Style($style, $music_id) {
    $sql = "INSERT INTO `music_style`(`music_style`, `music_id`) VALUES (:style, :music_id)";
    $query = pdo()->prepare($sql);
    $query->bindParam(':style', $style, PDO::PARAM_STR);
    $query->bindParam(':music_id', $music_id, PDO::PARAM_INT);
    $query->execute();
}
