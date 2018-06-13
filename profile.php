<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Profile page
 */
require_once './dao/dao.php';

if (empty($_SESSION['user_nickname'])) {
    header('Location:index.php');
}

$nickname = $_SESSION['user_nickname'];
$profile = TRUE;
$userData = Get_user_data($nickname);
$userScore = Get_score($userData['user_id']);

if (filter_has_var(INPUT_POST, 'change')) {
    $uploadOk_profile = 1;
    $target_dir_profile = "./uploaded_files/img/profile/";
    $target_file_profile = $target_dir_profile . basename($nickname . "-" . $_FILES["profile_pic"]["name"]);
    $FileType_profile = strtolower(pathinfo($target_file_profile, PATHINFO_EXTENSION));

    if (!empty($_FILES['profile_pic'])) {
        // Allow certain file formats
        if ($FileType_profile != "jpg" && $FileType_profile != "png" && $FileType_profile != "jpeg" && $FileType_profile != "gif") {
            $uploadOk_profile = 0;
        }

        // if everything is ok, try to upload file
        if ($uploadOk_profile == 1) {
            move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file_profile);
            Update_profile_picture($nickname, $_FILES["profile_pic"]["name"], $userData['user_profilepic']);
            $userData = Get_user_data($nickname);
        }
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
            <div class="row mt-3">
                <div class="col-md-auto">
                    <div class="card" style="width: 16rem;">
                        <?php if (!empty($userData['user_profilepic'])): ?>
                            <img class="card-img-top" src="./uploaded_files/img/profile/<?= $userData['user_profilepic']; ?>">
                        <?php else: ?>
                            <img class="card-img-top" src="./uploaded_files/img/profile/no-avatar.png">
                        <?php endif; ?>
                    </div>
                    <form action="profile.php" method="post" enctype="multipart/form-data">
                        <input class="form-control-file mt-2" type="file" name="profile_pic" accept="image/*"><br>
                        <input class="mt-2 btn btn-primary" value="Valider" name="change" type="submit">
                    </form>
                    <?= GetFlashMessage(); ?>
                </div>
                <div class="col">
                    <h3>Pseudo : <?= $nickname ?></h3>
                    <h5>Nom : <?= $userData['user_name'] ?> </h5> <br>
                </div>
                <div class="col">
                    <table class="table tab-content">
                        <tr>
                            <th>Score</th>
                        </tr>
                        <?php
                        foreach ($userScore as $scoreValue):
                            $scoreHour = date('H:i', strtotime($scoreValue['score_date']));
                            $scoreDate = date('d:m:Y', strtotime($scoreValue['score_date']));
                            ?>
                            <tr>
                                <td>
                                    <?=
                                    $scoreValue['score'];
                                    if ($scoreValue['score'] > 1):
                                        ?> points <?php else: ?> point <?php endif; ?> sur 
                                    <?= $scoreValue['score_questions_number']; ?> 
                                    questions le <?= $scoreDate; ?> à <?= $scoreHour; ?>.
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>