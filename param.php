<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Parameters of the user
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = Get_user_data($nickname);
$param = TRUE;
$param_value = Get_parameters($userData['user_id']);

if (filter_has_var(INPUT_POST, 'save')) {
    $time = trim(filter_input(INPUT_POST, 'time', FILTER_VALIDATE_INT));
    $questions_number = trim(filter_input(INPUT_POST, 'questions_number', FILTER_VALIDATE_INT));
    $question_type = trim(filter_input(INPUT_POST, 'question_type', FILTER_VALIDATE_INT));

    Save_parameters($time, $questions_number, $question_type, $userData['user_id']);
    $param_value = Get_parameters($userData['user_id']);
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
                    <legend>Paramètres</legend>
                    <p>Temps : </p>
                    <div class="slidecontainer">
                        <input name="time" type="range" min="10" max="60" value="<?= $param_value['parameters_time']; ?>" class="slider" id="param_time">
                        <p><span id="param_second"></span> seconde(s).</p>
                    </div>
                    <label>Le nombre de questions : 
                        <select name="questions_number">
                            <option <?php if ($param_value['parameters_questions_number'] == 5): ?> selected="" <?php endif; ?> value="5">5 questions</option>
                            <option <?php if ($param_value['parameters_questions_number'] == 10): ?> selected="" <?php endif; ?> value="10">10 questions</option>
                            <option <?php if ($param_value['parameters_questions_number'] == 15): ?> selected="" <?php endif; ?> value="15">15 questions</option>
                        </select>
                    </label>
                    <table>
                        <tr>
                            <th colspan="2">Type de questions : </th>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <input type="radio" name="question_type" value="1" <?php if ($param_value['parameters_type'] == 1): ?> checked="checked" <?php endif; ?> />Chanson
                                </label>
                            </td>
                            <td>
                                <label>
                                    <input type="radio" name="question_type" value="2" <?php if ($param_value['parameters_type'] == 2): ?> checked="checked" <?php endif; ?>/>Pochette d'album
                                </label>
                            </td>
                        </tr>
                    </table>
                    <button name="save" class="btn btn-primary" type="submit">Enregistrer</button>
                    <?php echo GetFlashMessage(); ?>
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
