<?php

/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : script to delete a music from the db
 */
require_once './dao/dao.php';

$music_id = filter_input(INPUT_GET, 'music_id', FILTER_VALIDATE_INT);
$music = Get_music($music_id);

Delete_music($music_id, $music['music_cover'], $music['music_file']);

header("Location:crud_option.php");
