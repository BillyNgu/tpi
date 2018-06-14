<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Parameters of the user
 */
require_once './dao/dao.php';

// Prevent user to access page without being logged
if (empty($_SESSION['user_nickname'])) {
    header('Location:index.php');
}

// Initialize var
$nickname = $_SESSION['user_nickname'];
$userData = Get_user_data($nickname);
$param = TRUE;
$users_param = Get_parameters($userData['user_id']);
$music_style = Get_music_style();

// If the button is clicked
if (filter_has_var(INPUT_POST, 'save')) {
    $time = trim(filter_input(INPUT_POST, 'time', FILTER_VALIDATE_INT));
    $questions_number = trim(filter_input(INPUT_POST, 'questions_number', FILTER_VALIDATE_INT));
    $user_music_style = filter_input(INPUT_POST, 'music_style', FILTER_VALIDATE_INT);

    Save_parameters($time, $questions_number, $userData['user_id'], $user_music_style);
    $users_param = Get_parameters($userData['user_id']);
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
            <form action="param.php" method="post">
                <fieldset>
                    <h2>Paramètres</h2>
                    <p>Temps : </p>
                    <div class="slidecontainer">
                        <input name="time" type="range" min="10" max="60" value="<?= $users_param['parameters_time']; ?>" class="slider" id="param_time">
                        <p><span id="param_second"></span> seconde(s).</p>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Le nombre de questions : 
                                <select name="questions_number">
                                    <option <?php if ($users_param['parameters_questions_number'] == 5): ?> selected="" <?php endif; ?> value="5">
                                        5 questions</option>
                                    <option <?php if ($users_param['parameters_questions_number'] == 10): ?> selected="" <?php endif; ?> value="10">
                                        10 questions</option>
                                    <option <?php if ($users_param['parameters_questions_number'] == 15): ?> selected="" <?php endif; ?> value="15">
                                        15 questions</option>
                                </select>
                            </label>
                        </div>
                        <div class="col">
                            Le style de musique pour les questions : 
                            <select name="music_style">
                                <?php foreach ($music_style as $value_music_style): ?>
                                    <option 
                                    <?php if ($value_music_style['music_style_id'] == $users_param['music_style_id']): ?>
                                            selected="" <?php endif; ?> value="
                                        <?= $value_music_style['music_style_id']; ?>">
                                            <?= $value_music_style['music_style']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button name="save" class="btn btn-primary" type="submit">Enregistrer</button>
                    <?= GetFlashMessage(); ?>
                </fieldset>
            </form>
        </div>
        <script>
            // Change the style of the slider
            var slider = document.getElementById("param_time");
            var output = document.getElementById("param_second");
            output.innerHTML = slider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
            slider.oninput = function () {
                output.innerHTML = this.value;
            };
        </script>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
