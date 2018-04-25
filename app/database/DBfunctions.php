<?php

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 22. 03. 2018
 * Time: 12:18
 */
require_once "DBconnect.php";

class DBfunctions {

    public static function getUsersData(){
        $db = DBconnect::getInstance();

        $statement1 = $db->prepare("SELECT diagenkri.user.`e-mail`, diagenkri.user.name, diagenkri.user.surname, diagenkri.user_profile.*
                                              FROM diagenkri.user JOIN diagenkri.user_profile ON diagenkri.user.`e-mail`=diagenkri.user_profile.`e-mail`;");

        $statement1->execute();

        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);

        return $result1;
    }
    
    public static function makeProfile($email){
        $db = DBconnect::getInstance();

        $dostop = date("Y-m-d H:i:s");

        $statement = $db->prepare("INSERT INTO diagenkri.user_profile (`e-mail`, lastaccess)
            VALUES (:email, :dostop)");
        $statement->bindParam(":email", $email);
        $statement->bindParam(":dostop", $dostop);
        $statement->execute();
    }

    public static function insert($name, $surname, $email, $password) {
        $db = DBconnect::getInstance();

        $statement1 = $db->prepare("SELECT `e-mail` FROM diagenkri.user WHERE `e-mail` = :eposta");
        $statement1->bindParam(":eposta", $email);
        $statement1->execute();
        $result1 = $statement1->fetch(PDO::FETCH_NUM);

        if($result1 < 1){

            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

            $statement = $db->prepare("INSERT INTO diagenkri.user (name, surname, `e-mail`, password)
            VALUES (:name, :surname, :email, :password)");
            $statement->bindParam(":name", $name);
            $statement->bindParam(":surname", $surname);
            $statement->bindParam(":email", $email);
            $statement->bindParam(":password", $hashed_pass);
            $statement->execute();
            self::makeProfile($email);
            return true;
        }
        else{
            return false;
        }
    }

     public static function checkLogin($eposta, $geslo){
        $db = DBconnect::getInstance();

        $statement = $db->prepare("SELECT COUNT(id) AS id FROM diagenkri.user WHERE `e-mail` = :email");
        $statement->bindParam(":email", $eposta);
        $statement->execute();
        $anwser = $statement->fetch(PDO::FETCH_NUM);
        if($anwser[0] == 1){
            $checkPass = $db->prepare("SELECT password FROM diagenkri.user WHERE `e-mail` = :email");
            $checkPass->bindParam(":email", $eposta);
            $checkPass->execute();
            $result = $checkPass->fetch(PDO::FETCH_NUM);
            $preveri = password_verify($geslo, $result[0]);
            if($preveri){
                $updateAccess = $db->prepare("UPDATE diagenkri.user_profile SET `lastaccess` = :time WHERE `e-mail` = :email");
                $updateAccess->bindParam(":time", date("Y-m-d H:i:s"));
                $updateAccess->bindParam(":email", $eposta);
                $updateAccess->execute();
                return true;
            }
            return false;
        }
        return false;
    }

    // MAY NEED OPTIMIZATION
    public static function saveAdimistrationChanges($email, $permissionsArray){
        $db = DBconnect::getInstance();

        $insert= [];

        for($x=1;$x<=6;$x++){
            if(isset($_POST['option' . $x]) && $_POST['option' .$x] == 'on'){
                $insert[$x] = 1;
            }
            else{
                $insert[$x] = 0;
            }
        }


        $statement = $db->prepare("UPDATE diagenkri.user_profile SET `admin` = :admin, `readPR` = :readPR, `editPR` = :editPR,
                                             `deletePR` = :deletePR, `addPR` = :addPR, `confirmPR` = :confirmPR
                                             WHERE `e-mail` = :email");
        $statement->bindParam(":admin", $insert[1]);
        $statement->bindParam(":readPR", $insert[2]);
        $statement->bindParam(":editPR", $insert[3]);
        $statement->bindParam(":deletePR", $insert[4]);
        $statement->bindParam(":addPR", $insert[5]);
        $statement->bindParam(":confirmPR", $insert[6]);
        $statement->bindParam(":email", $email);

        $statement->execute();
        return true;

    }

    public static function getUserProfile($email){
        $db = DBconnect::getInstance();

        $statement1 = $db->prepare("SELECT diagenkri.user.`e-mail`, diagenkri.user.name, diagenkri.user.surname, diagenkri.user_profile.*
                                              FROM diagenkri.user JOIN diagenkri.user_profile ON diagenkri.user.`e-mail`=diagenkri.user_profile.`e-mail`
                                              WHERE diagenkri.user.`e-mail`= :email");
        $statement1->bindParam(":email", $email);
        $statement1->execute();

        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);

        return $result1;
    }


}