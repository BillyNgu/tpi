<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Titre : Profil
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$profile = TRUE;

$userData = GetData($nickname);

if (isset($_POST['change'])) {
    $uploadOk = 1;
    $target_dir = "./uploaded_files/img/";
    $target_file = $target_dir . basename($nickname . "-" . $_FILES["profile_pic"]["name"]);
    $FileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

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
            }
        }
    }
    UpdateProfilePicture($nickname, $_FILES["profile_pic"]["name"], $userData['user_profilepic']);
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
            <div class="row mt-3">
                <div class="col-md-auto">
                    <div class="card" style="width: 16rem;">
                        <?php if (!empty($userData['user_profilepic'])): ?>
                            <img class="card-img-top" src="./uploaded_files/img/<?php echo $userData['user_profilepic']; ?>">
                        <?php else: ?>
                            <img class="card-img-top" src="./uploaded_files/img/no-avatar.png">
                        <?php endif; ?>
                    </div>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <input class="mt-2" type="file" name="profile_pic" accept="image/*"><br>
                        <input class="mt-2 btn btn-primary" name="change" type="submit">
                    </form>
                </div>
                <div class="col">
                    <h3>Pseudo : <?php echo $nickname ?></h3>
                    <h5>Nom : <?= $userData['user_name'] ?> </h5> <br>
                </div>
                <div class="col">
                    <fieldset>
                        <legend>Score</legend>
                    </fieldset>
                </div>
            </div>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
