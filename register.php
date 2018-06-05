<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : S'inscrire
 * Description : TPI
 */
require_once './dao/dao.php';

$register = TRUE;

if (isset($_POST['register'])) {

    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $nickname = trim(filter_input(INPUT_POST, 'nickname', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    // pas de filtre, parce que hashage prochainement
    $pwd = filter_input(INPUT_POST, 'password');
    $pwdRepeat = filter_input(INPUT_POST, 'passwordConfirmation');

    $uploadOk = 1;
    $target_dir = "./uploaded_files/img/";
    $target_file = $target_dir . $nickname . "-" . basename($_FILES["profile_pic"]["name"]);
    $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $errors = [];

    if (empty($name)) {
        $errors['name'] = 'Le nom ne peut pas être vide.';
    }
    if (empty($nickname)) {
        $errors['nickname'] = 'Le pseudo ne peut pas être vide.';
    }
    if (empty($email)) {
        $errors['email'] = 'L\'email ne peut pas être vide.';
    }
    if (empty($pwd)) {
        $errors['password'] = 'Le mot de passe ne peut pas être vide.';
    }
    if (empty($pwdRepeat)) {
        $errors['passwordConfirmation'] = 'La confirmation du mot de passe ne peut pas être vide.';
    }

    if ($pwd !== $pwdRepeat) {
        $errors['passwordConfirmation'] = 'Les mots de passe ne sont pas identiques.';
    }

    if (empty($errors)) {
        if (!empty($_FILES['profile_pic'])) {
            // Allow certain file formats
            if ($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif") {
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
                    echo "The file " . basename($_FILES["profile_pic"]["name"]) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        CreateUser(strtolower($name), strtolower($nickname), strtolower($email), $pwd, $nickname . "-" . $_FILES["profile_pic"]["name"]);
        SetFlashMessage("Utilisateur ajouté.");
        header("location:index.php");
        exit;
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
                    <input type="text" name="name" class="form-control col-3" id="lastname_login" value="<?php
                    if (!empty($name)) {
                        echo $name;
                    }
                    ?>">
                           <?php
                           if (!empty($errors['name'])) {
                               echo $errors['name'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="nickname_login">Pseudo :</label>
                    <input type="text" name="nickname" class="form-control col-3" id="nickname_login" value="<?php
                    if (!empty($nickname)) {
                        echo $nickname;
                    }
                    ?>">
                           <?php
                           if (!empty($errors['nickname'])) {
                               echo $errors['nickname'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="email_login">Email :</label>
                    <input type="email" name="email" class="form-control col-3" id="email_login" value="<?php
                    if (!empty($email)) {
                        echo $email;
                    }
                    ?>">
                           <?php
                           if (!empty($errors['email'])) {
                               echo $errors['email'];
                           }
                           ?>
                </div>
                <div class="form-group">
                    <label for="password_login">Mot de passe :</label>
                    <input type="password" name="password" class="form-control col-3" id="password_login">
                    <?php
                    if (!empty($errors['password'])) {
                        echo $errors['password'];
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="passwordconfirmation_login">Confirmer mot de passe :</label>
                    <input type="password" name="passwordConfirmation" class="form-control col-3" id="passwordconfirmation_login">
                    <?php
                    if (!empty($errors['passwordConfirmation'])) {
                        echo $errors['passwordConfirmation'];
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label>Image de profil :</label>
                    <input type="file" name="profile_pic" class="form-control-file col-3" multiple accept="image/*">
                    <?php
                    if (!empty($errors['profile_pic'])) {
                        echo $errors['profile_pic'];
                    }
                    ?>
                </div>
                <a class="btn btn-primary" href="index.php">Retour</a>
                <input class="btn btn-primary" value="S'inscrire" name="register" type="submit">
            </form>
        </div>
        <script type="text/javascript" src="js/bootstrap.js"></script>
    </body>
</html>
