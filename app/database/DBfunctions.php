<?php

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 22. 03. 2018
 * Time: 12:18
 */
require_once "DBconnect.php";

class DBfunctions {
    
    public static function makeProfile($email){
        $db = DBconnect::getInstance();

        $dostop = date("Y-m-d H:i:s");

        $statement = $db->prepare("INSERT INTO diagenkri.user_profile (`e-mail`, lastaccess)
            VALUES (:email, :dostop)");
        $statement->bindParam(":email", $email);
        $statement->bindParam(":dostop", $dostop);
        $statement->execute();
    }

    public static function insert($name, $surname, $email, $dateofbirth, $placeofbirth, $password) {
        $db = DBconnect::getInstance();

        $statement1 = $db->prepare("SELECT `e-mail` FROM diagenkri.user WHERE `e-mail` = :eposta");
        $statement1->bindParam(":eposta", $email);
        $statement1->execute();
        $result1 = $statement1->fetch(PDO::FETCH_NUM);

        if($result1 < 1){

            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

            $statement = $db->prepare("INSERT INTO diagenkri.user (name, surname, `e-mail`, dateofbirth, placeofbirth, password)
            VALUES (:name, :surname, :email, :dateofbirth, :placeofbirth, :password)");
            $statement->bindParam(":name", $name);
            $statement->bindParam(":surname", $surname);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":dateofbirth", $dateofbirth);
            $statement->bindParam(":placeofbirth", $placeofbirth);
            $statement->bindParam(":password", $hashed_pass);
            $statement->execute();
            self::makeProfile($email);
            return true;
        }
        else{
            return false;
        }
    }

}