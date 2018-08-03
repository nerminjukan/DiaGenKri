<?php

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 22. 03. 2018
 * Time: 12:18
 */
require_once "DBconnect.php";

class DBfunctions {

    public static function saveGraph($email, $data, $name, $description, $gtype, $atype){

        $db = DBconnect::getInstance();

        try {
            $statement = $db->prepare("INSERT INTO diagenkri.graph (`e-mail`, `name`, `description`, `visual`, `algorithm_type`, `data`)
                                                 VALUES (:email, :name, :description, :gtype, :atype, :data)");
            $statement->bindParam(":email", $email);
            $statement->bindParam(":name", $name);
            $statement->bindParam(":description", $description);
            $statement->bindParam(":gtype", $gtype);
            $statement->bindParam(":atype", $atype);
            $statement->bindParam(":data", $data);

            // echo "<pre>";
            // var_dump($data);
            // exit();

            $result = $statement->execute();

            echo $result;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        // var_dump($result);

        return $result;

    }

    public static function editGraph($email, $data, $name, $description, $gtype, $atype, $id){

        $db = DBconnect::getInstance();

        try {
            $statement = $db->prepare("UPDATE diagenkri.graph SET `name`=:name,`description`=:description,`visual`=:gtype,
            `algorithm_type`=:atype,`data`=:data WHERE `id`=:id ");
            $statement->bindParam(":name", $name);
            $statement->bindParam(":description", $description);
            $statement->bindParam(":gtype", $gtype);
            $statement->bindParam(":atype", $atype);
            $statement->bindParam(":data", $data);
            $statement->bindParam(":id", $id);

            $result = $statement->execute();
            // var_dump("first", $result);

            // add to graph edits
            $statement1= $db->prepare("INSERT INTO `graph-edits` (`graph-id`, `edited-by`)
                                                 VALUES (:id, :email)");
            $statement1->bindParam(":id", $id);
            $statement1->bindParam(":email", $email);

            $result1 = $statement1->execute();

            $fin = $result && $result1;
            echo $fin;
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }

        // $statement = $db->prepare("UPDATE diagenkri.graph SET `name`=:name,`description`=:description,`visual`=:gtype,
        //     `algorithm_type`=:atype,`data`=:data WHERE `id`=:id ");
        // $statement->bindParam(":name", $name);
        // $statement->bindParam(":description", $description);
        // $statement->bindParam(":gtype", $gtype);
        // $statement->bindParam(":atype", $atype);
        // $statement->bindParam(":data", $data);
        // $statement->bindParam(":id", $id);

        // $result = $statement->execute();
        // // var_dump("first", $result);

        // // add to graph edits
        // $statement1= $db->prepare("INSERT INTO `graph-edits` (`graph-id`, `edited-by`)
        //                                      VALUES (:id, :email)");
        // $statement1->bindParam(":id", $id);
        // $statement1->bindParam(":email", $email);

        // $result1 = $statement1->execute();

        // $fin = $result && $result1;
        // echo $fin;
        return $result && $result1;

    }


    public static function deleteGraph($email, $id){
        $db = DBconnect::getInstance();

        try {
            $statement = $db->prepare("DELETE FROM `graph-edits` WHERE `graph-id` = :id;");
            $statement->bindParam(":id", $id);
            $result = $statement->execute();

            $statement1 = $db->prepare("DELETE FROM `graph` WHERE `id` = :id;");
            $statement1->bindParam(":id", $id);
            $result1 = $statement1->execute();

            $fin = $result && $result1;
            echo $fin;
        } catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    // return height of $vertex in tree, which is max($vertex.left, $vertex.right) + 1
    private function heightOfTree($vertex){
        if($vertex.left != null && $vertex.right != null)
            return max(heightOfTree($vertex.left), heightOfTree($vertex.right)) + 1;
        else if($vertex.left != null)
            return heightOfTree($vertex.left) + 1;
        else if($vertex.right != null)
            return heightOfTree($vertex.right) + 1;
        else
            return 1; 
    }



    public static function loadGraph($id){
        $db = DBconnect::getInstance();

        $statement = $db->prepare("SELECT * FROM diagenkri.graph WHERE graph.id = :id");

        $statement->bindParam(":id", $id);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getUsersData(){
        $db = DBconnect::getInstance();

        $statement1 = $db->prepare("SELECT diagenkri.user.`e-mail`, diagenkri.user.name, diagenkri.user.surname, diagenkri.user_profile.*
                                              FROM diagenkri.user JOIN diagenkri.user_profile ON diagenkri.user.`e-mail`=diagenkri.user_profile.`e-mail`;");

        $statement1->execute();

        $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);

        return $result1;
    }

    public static function getGraphs(){
        $db = DBconnect::getInstance();

        $statement1 = $db->prepare("SELECT * FROM diagenkri.graph;");

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


        $result = $statement->execute();

        return $result;

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

    // returns name and surname of user with $email
    public static function getUser($email){
        $db = DBconnect::getInstance();

        $statement1 = $db->prepare("SELECT diagenkri.user.name, diagenkri.user.surname, diagenkri.user_profile.*
                                              FROM diagenkri.user JOIN diagenkri.user_profile ON diagenkri.user.`e-mail` = diagenkri.user_profile.`e-mail` WHERE diagenkri.user.`e-mail` = :eposta");
        $statement1->bindParam(":eposta", $email);
        $statement1->execute();
        $result1 = $statement1->fetch(PDO::FETCH_ASSOC);


        // var_dump($result1);
        // exit();
        return $result1;
    }

}