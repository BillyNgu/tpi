<?php

/*
 * Author : Nguyen Billy
 * Date : 2018-06-04
 * Description : script of connection to db
 */

function pdo() {
    static $dbc = null;

    if ($dbc == null) {
        try {
            $dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, 
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_PERSISTENT => true));
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage() . '<br />';
            echo 'N°: ' . $e->getCode() . '<br />';
            die('Could not connect to MySql');
        }
    }
    return $dbc;
}