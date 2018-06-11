<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Register page
 */
require_once './dao/dao.php';

$register = TRUE;

if (filter_has_var(INPUT_POST, 'register')) {

    $name_register_form = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $nickname_register_form = trim(filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING));
    $email_register_form = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    // no filter for password, only in function
    $pwd_register_form = filter_input(INPUT_POST, 'password');
    $pwdRepeat_register_form = filter_input(INPUT_POST, 'passwordConfirmation');

    $uploadOk_register = 1;
    $target_dir_register = "./uploaded_files/img/profile/";
    $target_file_register = $target_dir_register . $nickname_register_form . "-" . basename($_FILES["profile_pic"]["name"]);
    $FileType_register = strtolower(pathinfo($target_file_register, PATHINFO_EXTENSION));

    $errors_register_form = [];

    if (!empty($_FILES['profile_pic'])) {
        // Allow certain file formats
        if ($FileType_register != "jpg" && $FileType_register != "png" && $FileType_register != "jpeg" && $FileType_register != "gif") {
            $uploadOk_register = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk_register == 1) {
            move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file_register);
            // if everything is ok, try to upload file
        }
    }

    if (empty($name_register_form)) {
        $errors_register_form['name'] = "Le nom ne peut pas être vide.";
    }

    if (empty($nickname_register_form)) {
        $errors_register_form['nickname'] = "Le pseudo ne peut pas être vide.";
    }

    if (empty($email_register_form)) {
        $errors_register_form['email'] = "L'email ne peut pas être vide.";
    }

    if (empty($pwd_register_form)) {
        $errors_register_form['password'] = "Le mot de passe ne peut pas être vide.";
    }

    if (empty($pwdRepeat_register_form)) {
        $errors_register_form['passwordConfirmation'] = "La confirmation ne peut pas être vide.";
    }

    if ($pwd_register_form !== $pwdRepeat_register_form) {
        $errors_register_form['passwordConfirmation'] = "Les mots de passe sont différents.";
    }

    if (empty($errors_register_form)) {
        CreateUser(strtolower($name_register_form), strtolower($nickname_register_form), strtolower($email_register_form), $pwd_register_form, $_FILES["profile_pic"]["name"]);
        $userdata = Get_user_data($nickname_register_form);
        // Save default parameters to prevent the user to play without settings
        Save_parameters(30, 5, 1, $userdata['user_id']);
        header('Location:index.php');
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
            <form action="register.php" method="post" enctype="multipart/form-data">
                <h3>Inscription</h3>
                <div class="form-group">
                    <label for="lastname_login">Nom :</label>
                    <input type="text" name="name" placeholder="Lennon" class="form-control col-3" id="lastname_login" value="<?php
                    if (!empty($name_register_form)) {
                        echo $name_register_form;
                    }
                    ?>">
                           <?php
                           if (!empty($errors_register_form['name'])) {
                               echo $errors_register_form['name'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="nickname_login">Pseudo :</label>
                    <input type="text" name="nickname" placeholder="BobL" class="form-control col-3" id="nickname_login" value="<?php
                    if (!empty($nickname_register_form)) {
                        echo $nickname_register_form;
                    }
                    ?>">
                           <?php
                           if (!empty($errors_register_form['nickname'])) {
                               echo $errors_register_form['nickname'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="email_login">Email :</label>
                    <input type="email" name="email" placeholder="random@email.com" class="form-control col-3" id="email_login" value="<?php
                    if (!empty($email_register_form)) {
                        echo $email_register_form;
                    }
                    ?>">
                           <?php
                           if (!empty($errors_register_form['email'])) {
                               echo $errors_register_form['email'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="password_login">Mot de passe :</label>
                    <input type="password" name="password" class="form-control col-3" id="password_login">
                    <?php
                    if (!empty($errors_register_form['password'])) {
                        echo $errors_register_form['password'];
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="passwordconfirmation_login">Confirmer mot de passe :</label>
                    <input type="password" name="passwordConfirmation" class="form-control col-3" id="passwordconfirmation_login">
                    <?php
                    if (!empty($errors_register_form['passwordConfirmation'])) {
                        echo $errors_register_form['passwordConfirmation'];
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label>Image de profil :</label>
                    <input type="file" name="profile_pic" class="form-control-file col-3" multiple accept="image/*">
                    <?php
                    if (!empty($errors_register_form['profile_pic'])) {
                        echo $errors_register_form['profile_pic'];
                    }
                    ?>
                </div>
                <a class="btn btn-primary" href="index.php">Retour</a>
                <input class="btn btn-primary" value="S'inscrire" name="register" type="submit">
                <?= GetFlashMessage(); ?>
            </form>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>
