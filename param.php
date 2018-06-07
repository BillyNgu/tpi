<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Title : Paramètres
 * Description : TPI
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
$param = TRUE;
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
                        <input type="range" min="10" max="100" value="30" class="slider" id="myRange">
                        <p><span id="demo"></span> seconde(s).</p>
                    </div>
                    <select>
                        <option value="5">5 questions</option>
                        <option value="10">10 questions</option>
                        <option value="15">15 questions</option>
                    </select>
                    <table>
                        <tr>
                            <th colspan="2">Type de questions : </th>
                        </tr>
                        <tr>
                            <td>
                                <label>
                                    <input type="radio" name="question" value="1" checked="checked" />Chant
                                </label>
                            </td>
                            <td>
                                <label>
                                    <input type="radio" name="question" value="2" />Image
                                </label>
                            </td>
                        </tr>
                    </table>
                    <button class="btn btn-primary" type="submit">Enregistrer</button>
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
