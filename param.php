<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : Parameters of the user
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
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
                        <input name="time" type="range" min="10" max="60" value="<?php
                        if (!empty($param_value['parameters_time'])):
                            echo $param_value['parameters_time'];
                        else:
                            ?>30<?php endif; ?>" class="slider" id="myRange">
                        <p><span id="demo"></span> seconde(s).</p>
                    </div>
                    <label>Le nombre de questions : 
                        <select name="questions_number">
                            <?php
                            if (!empty($param_value['parameters_questions_number'])):
                                switch ($param_value['parameters_questions_number']):
                                    case 5:
                                        ?>
                                        <option selected="" value="5">5 questions</option>
                                        <option value="10">10 questions</option>
                                        <option value="15">15 questions</option>
                                        <?php
                                        break;
                                    case 10:
                                        ?>
                                        <option value="5">5 questions</option>
                                        <option selected="" value="10">10 questions</option>
                                        <option value="15">15 questions</option>
                                        <?php
                                        break;
                                    case 15:
                                        ?>
                                        <option value="5">5 questions</option>
                                        <option value="10">10 questions</option>
                                        <option selected="" value="15">15 questions</option>
                                    <?php
                                    default: break;
                                endswitch;
                            else:
                                ?>
                                <option selected="" value="5">5 questions</option>
                                <option value="10">10 questions</option>
                                <option value="15">15 questions</option> 
                            <?php endif; ?>
                        </select>
                    </label>
                    <table>
                        <tr>
                            <th colspan="2">Type de questions : </th>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <?php if (!empty($param_value['parameters_type'])): if ($param_value['parameters_type'] == 1): ?>
                                            <input type="radio" name="question_type" value="1" checked="checked" />Chanson
                                        <?php else: ?>
                                            <input type="radio" name="question_type" value="1" />Chanson
                                        <?php
                                        endif;
                                    else:
                                        ?>
                                        <input type="radio" name="question_type" value="1" checked="checked" />Chanson
                                    <?php endif; ?>
                                </label>
                            </td>
                            <td>
                                <label>
                                    <?php if (!empty($param_value['parameters_type'])): if ($param_value['parameters_type'] == 2): ?>
                                            <input type="radio" name="question_type" value="2" checked="checked"/>Pochette d'album
                                        <?php else: ?>
                                            <input type="radio" name="question_type" value="2" />Pochette d'album
                                        <?php
                                        endif;
                                    else:
                                        ?>
                                        <input type="radio" name="question_type" value="2" />Pochette d'album
                                    <?php endif; ?>
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
            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            output.innerHTML = slider.value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
            slider.oninput = function () {
                output.innerHTML = this.value;
            };
        </script>
        <script src="js/bootstrap.js" type="text/javascript"></script>
    </body>
</html>
