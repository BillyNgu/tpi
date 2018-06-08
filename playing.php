<?php
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : In game
 */
require_once './dao/dao.php';

$nickname = $_SESSION['user_nickname'];
$userData = GetData($nickname);
$paramData = Get_parameters($userData['user_id']);
$musics = Get_all_music_random($paramData['parameters_questions_number']);
$question_name = [];
$play = TRUE;
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
            <fieldset>
                <legend>Jouer</legend>
                <p>Quelle est cette musique ?</p>
                <?php
                foreach ($musics as $value):
                    $question_name[] = $value['music_file'];
                    ?>
                    <label>
                        <input name="answer" value="<?= $value['music_title']; ?>" type="radio" ><?= $value['music_title']; ?>
                    </label>
                    <?php
                endforeach;
                // a random music file in the $question_name array
                $question_music = $question_name[array_rand($question_name, 1)];
                var_dump($question_name);
                ?>
                <audio autoplay="" controls="" id="question_audio">
                    <source src="./uploaded_files/songs/<?php echo $question_music; ?>" type="audio/<?= substr($question_music, -3); ?>">
                </audio>
                <!-- A slide bar to control the volume -->
                <input class="slider" id="q_volume_slide" type="range" min="0" max="1" step="0.1" onchange="setVolume()">
                <p><span id="q_volume_output"></span>%.</p>
                <?php var_dump($question_music); ?>
            </fieldset>
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

                    // Disable main function of the html audio tag and add a slider bar to change its volume.                  
                    function setVolume() {
                        var volume = document.getElementById("q_volume_slide");
                        q_audio.volume = volume.value;
                    }
        </script>
    </body>
</html>
