<?php
/*
 * Auteur : Nguyen Billy
 * Date : 2018-06-04
 * Description : TPI
 */
session_start();

function SetFlashMessage($message) {
    $_SESSION["MessageFlash"] = $message;
}

function GetFlashMessage() {
    if (isset($_SESSION["MessageFlash"])) {
        $message = $_SESSION["MessageFlash"];
        unset($_SESSION["MessageFlash"]);
    }
 else {
        $message = "";
    }
    return $message;
}
