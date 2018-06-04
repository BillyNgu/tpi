<?php

require_once './dao/dao.php';

$nickname = $_SESSION['pseudo'];
$play = TRUE;

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <title>VidéoQuizz</title>
        <?php require_once './css/css_js.php'; ?>
    </head>
    <body>
        <div class="container">
            <?php require_once './navbar.php'; ?>
        </div>
    </body>
</html>
