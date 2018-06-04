<?php

/*
 * Authors : Nguyen Billy
 * Description : Functions
 * Date : 2018-05-08
 */

require_once './dao/mySql.inc.php';
require_once './dao/connectionBase.php';
require_once './dao/flashmessage.php';

/**
 * Get the list of all Pokemon
 * @return array
 */
function getAllPokemon() {
    $sql = "SELECT `pokemonId`, `pokemonSprite`, `pokemonName`  FROM `pokemon`";
    $query = pokedb()->prepare($sql);
    $query->execute();
    return $result = $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all the types
 * @return array
 */
function getAllTypes() {
    $sql = "SELECT `typeImage`, `typeName` FROM `type` ORDER BY `typeName` ASC";
    $query = pokedb()->prepare($sql);
    $query->execute();
    return $result = $query->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTypeImages() {
    $sql = "SELECT `typeImage` FROM `type` ORDER BY `type`.`typeName` ASC";
    $query = pokedb()->prepare($sql);
    $query->execute();
    return $result = $query->fetchAll(PDO::FETCH_ASSOC);
}

function getStrengthFactor($cpt) {
//    $sql = "SELECT * FROM `weakness` ORDER BY `weakness`.`defendTypeId`, `weakness`.`attackTypeId` ASC";
//    $sql = "SELECT `weakness`.`strengthFactor` FROM `weakness`, `type` WHERE `weakness`.`defendTypeId` = (SELECT `typeId` FROM `type` WHERE `type`.`typeImage` = :typeImage) LIMIT 18";
    $sql = "SELECT * FROM `weakness`, `type` WHERE `weakness`.`defendTypeId` = :cpt and attackTypeId = type.typeId ORDER BY type.typeName limit 18";
    $query = pokedb()->prepare($sql);
    $query->bindParam(':cpt', $cpt, PDO::PARAM_INT);
    $query->execute();
    return $result = $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get all attacks
 * @return array
 */
function getAllAttack() {
    $sql = "SELECT `moveName`, `movePower`, `moveAccuracy`, `typeId` FROM `move`";
    $query = pokedb()->prepare($sql);
    $query->execute();
    return $result = $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get a type by its id
 * @param int $idType The type id
 * @return string
 */
function getTypeById($idType) {
    $sql = "SELECT `typeImage` FROM `type` WHERE `typeId` = :idType";
    $query = pokedb()->prepare($sql);
    $query->bindParam(':idType', $idType, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch()[0];
}

/**
 * Get all types of a selected Pokemon
 * @param int $idPokemon
 * @return array
 */
function getPokemonType($idPokemon) {
    $sql = "SELECT `type`.`typeId`, `type`.`typeImage`"
            . "FROM `type`, `composed` WHERE `type`.`typeId` = `composed`.`typeId` AND `composed`.`pokemonId` = :idPokemon";
    $query = pokedb()->prepare($sql);
    $query->bindParam(':idPokemon', $idPokemon, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll();
}

/**
 * Get all types of attacks
 * @param int $idMove The move Id
 * @return array
 */
function getAttackType($idMove) {
    $sql = "SELECT `typeImage` FROM `type`, `move` WHERE `type`.`typeId`=`move`.`typeId` AND `move`.`moveId`= :idMove";
    $query = pokedb()->prepare($sql);
    $query->bindParam(':idMove', $idMove, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Get description of a Pokemon
 * @param int $idPokemon The Pokemon id
 * @return array
 */
function getDescription($idPokemon) {
    $sql = "SELECT`pokemonId`, `pokemonName`, `pokemonDescription`, `pokemonImg`, `pokemonSprite` FROM `pokemon` WHERE `pokemonId` = :idPokemon";
    $query = pokedb()->prepare($sql);
    $query->bindParam(':idPokemon', $idPokemon, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function CreateUser($Name, $Nickname, $Email, $Pwd) {
    $sql = "INSERT INTO `utilisateurs`(`nom`, `pseudo`, `email`, `mdp`, `status`) "
            . "VALUES (:name, :nickname, :email, :pwd, 0)";
    
    $query = pdo()->prepare($sql);
    $query->bindParam('name', $Name, PDO::PARAM_STR);
    $query->bindParam('nickname', $Nickname, PDO::PARAM_STR);
    $query->bindParam('email', $Email, PDO::PARAM_STR);
    $query->bindParam('pwd', $Pwd, PDO::PARAM_STR);
    $query->execute(array(
        'name' => strtolower($Name),
        'nickname' => strtolower($Nickname),
        'email' => strtolower($Email),
        'pwd' => sha1($Pwd)
    ));
}

function CheckLogin($Nickname, $Pwd) {
    $sql = "SELECT `pseudo`, `mdp` FROM `utilisateurs` WHERE `pseudo` = :nickname AND `mdp` = :pwd";
    $query = pdo()->prepare($sql);

    $Pwd = sha1($Pwd);
    
    $query->bindParam(':nickname', $Nickname, PDO::PARAM_STR);
    $query->bindParam(':pwd', $Pwd, PDO::PARAM_STR);
    $query->execute();
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($Nickname === $user['pseudo'] && $Pwd === $user['mdp']) {
        $_SESSION['pseudo'] = $Nickname;
//        $_SESSION['idUser'] = $idUser;

        header('Location:login.php');
    } else {
        $_SESSION['pseudo'] = "";
    }
}

function getSaltFromUser($Nickname) {
    $sql = "SELECT `userSalt` from `user` WHERE `userNickname` = :Nickname";
    $query = pokedb()->prepare($sql);
    $query->bindParam(':Nickname', $Nickname, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch()[0];
}
