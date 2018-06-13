<?php 
/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : script to logout
 */
session_start();

session_destroy();

header('Location:index.php');