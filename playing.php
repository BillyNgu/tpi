<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : In game
 */
require_once './dao/dao.php';

if (empty($_SESSION['user_nickname'])) {
    header('Location:index.php');
}

$nickname = $_SESSION['user_nickname'];
$userData = Get_user_data($nickname);
$paramData = Get_parameters($userData['user_id']);
$question_name = [];
$music_played = "";
$play = TRUE;
$_SESSION['cpt'] += 1;

// Check if the var is set, if not, set it
if (!isset($_SESSION['game_id'])) {
    $_SESSION['game_id'] = Create_game();
}

// Get the musics or covers
$musics_to_play = Get_all_music_random($_SESSION['game_id'], $paramData['music_style_id']);

if (filter_has_var(INPUT_POST, 'answer') && filter_has_var(INPUT_POST, 'q_answer')) {
    $q_answer = filter_input(INPUT_POST, 'q_answer', FILTER_SANITIZE_STRING);

    if (check_answer($q_answer, $_SESSION['q_audio'])) {
        $_SESSION['score'] += 1;
        Add_game($_SESSION['game_id'], $userData['user_id'], Get_music_id_by_file($_SESSION['q_audio']));
        var_dump("answer:" . $_SESSION['q_audio']);
//        var_dump("id of the music:" . Get_music_id($_SESSION['q_audio']));
    }
}

// Check if all the questions have been answered (right or wrong), if so, add the score to the db
if ($_SESSION['cpt'] >= ($paramData['parameters_questions_number'] + 1)) {
    Add_score($_SESSION['score'], $paramData['parameters_questions_number'], $userData['user_id']);
    header('Location:result.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <title>Blindtest</title>
        <script src="js/amplitude.js" type="text/javascript"></script>
        <?php require_once './css/css_js.php'; ?>
    </head>
    <body>
        <div class="container">
            <?php require_once './navbar.php'; ?>
            <form action="playing.php" method="post">
                <fieldset>
                    <legend>Jouer</legend>
                    <h5>Question <?= $_SESSION['cpt']; ?>/<?= $paramData['parameters_questions_number']; ?></h5>
                    <p>Quelle est cette musique ?</p>
                    <table>
                        <?php
                        foreach ($musics_to_play as $question_value):
                            $question_name[] = $question_value['music_file'];
                            ?>
                            <tr>
                                <td>
                                    <label>
                                        <input name="q_answer" value="<?= $question_value['music_title']; ?>" type="radio" >
                                        <?= $question_value['music_title']; ?>
                                    </label>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                        // a random music file in the $question_name array
                        if (!empty($question_name)) {
                            $question_music = $question_name[array_rand($question_name, 1)];
                            $_SESSION['q_audio'] = $question_music;
                            var_dump($question_music);
                        }
                        ?>
                    </table>
                    <audio autoplay="" controls="" id="question_audio">
                        <source src="./uploaded_files/songs/<?= $question_music; ?>" type="audio/<?= substr($question_music, -3); ?>">
                    </audio>
                    <!-- A slide bar to control the volume -->
                    <input class="slider" id="q_volume_slide" type="range" min="0" max="1" step="0.1" onchange="setVolume()">
                    <p>Volume : <span id="q_volume_output"></span>%.</p>
                    <p>Temps restant : <span id="time_limit"><?= $paramData['parameters_time']; ?></span> seconde(s).</p>
                    <button class="btn btn-primary" name="answer">Valider</button>
                </fieldset>                  
            </form>
        </div>
        <script src="js/bootstrap.js" type="text/javascript"></script>
        <script>
                        // Change the style of the slider
                        var q_audio = document.getElementById("question_audio");
                        q_audio.controls = false;


                        var q_audio_slide = document.getElementById("q_volume_slide");
                        var output = document.getElementById("q_volume_output");
                        output.innerHTML = q_audio_slide.value * 100; // Display the default slider value

                        // Update the current slider value (each time you drag the slider handle)
                        q_audio_slide.oninput = function () {
                            output.innerHTML = this.value * 100;
                        };

                        var q_time_limit = <?= $paramData['parameters_time']; ?>;
                        q_time_limit.innerHTML = q_time_limit;
                        // Update the count down every 1 second
                        var x = setInterval(function () {
                            q_time_limit--;
                            // Display the result in the element with id="demo"
                            document.getElementById("time_limit").innerHTML = q_time_limit;

                            // If the count down is finished, write some text 
                            if (q_time_limit === 0) {
                                location.reload();
                            }
                        }, 1000);

                        // Disable main function of the html audio tag and add a slider bar to change its volume.                  
                        function setVolume() {
                            var volume = document.getElementById("q_volume_slide");
                            q_audio.volume = volume.value;
                        }
        </script>
    </body>
</html>
