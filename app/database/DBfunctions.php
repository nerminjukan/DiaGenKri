<?php

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 22. 03. 2018
 * Time: 12:18
 */
require_once "DBconnect.php";

class DBfunctions {

    public static function saveGraph($email, $data, $name, $description, $access, $gtype, $atype){

        $db = DBconnect::getInstance();

        try {
            $statement = $db->prepare("INSERT INTO diagenkri.graph (`e-mail`, `name`, `description`, `private`, `visual`, `algorithm_type`, `data`)
                                                 VALUES (:email, :name, :description, :private, :gtype, :atype, :data)");
            $statement->bindParam(":email", $email);
            $statement->bindParam(":name", $name);
            $statement->bindParam(":description", $description);
            $statement->bindParam(":private", $access);
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
        $id = $db->lastInsertId();

        return $id;
    }
  
    public static function createCurationRequest($graphId, $email){
        $db = DBconnect::getInstance();

        $check = $db->prepare("SELECT COUNT(id) AS 'id' FROM diagenkri.`graph-curation` WHERE `graph-id`=:gid");
        $check->bindParam(":gid", $graphId);
        $check->execute();
        $anwser = $check->fetch(PDO::FETCH_NUM);

        //return $anwser;

        if($anwser[0] === 0 || $anwser[0] === '0'){
            try {
                $statement = $db->prepare("INSERT INTO diagenkri.`graph-curation` (`graph-id`, `request-date`, `requested-by`)
                                                 VALUES (:graphId, :date, :email)");
                $statement->bindParam(":graphId", $graphId);
                $statement->bindParam(":email", $email);
                $statement->bindParam(":date", $date);
                $date = date("Y-m-d H:i:s");

                $result = $statement->execute();

                return $result;
            } catch (Exception $e) {
                return ('Caught exception: ' .  $e->getMessage() . "\n");
            }
        }else{
            try {
                $update = $db->prepare("UPDATE diagenkri.`graph-curation` SET `request-date`=:date WHERE `graph-id`=:gid AND `requested-by`=:auth ");
                $update->bindParam(":date", $date);
                $update->bindParam(":gid", $graphId);
                $update->bindParam(":auth", $email);
                $date = date("Y-m-d H:i:s");
                $success = $update->execute();

                return $success;

            } catch (Exception $e) {
                return ('Caught exception: ' .  $e->getMessage() . "\n");
            }
        }
    }

    public static function editGraph($email, $data, $name, $description, $access, $gtype, $atype, $id){

        $db = DBconnect::getInstance();

        try {
            $statement = $db->prepare("UPDATE diagenkri.graph SET `name`=:name,`description`=:description, `private`=:private, `visual`=:gtype,
            `algorithm_type`=:atype,`data`=:data WHERE `id`=:id ");
            $statement->bindParam(":name", $name);
            $statement->bindParam(":description", $description);
            $statement->bindParam(":private", $access);
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
        // var_dump("res iz dbf:loadGraph", $result);
        // echo $result;
        // var_dump($statement);
        // exit();

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
        $result = null;
        try {
            $query = $db->prepare("SELECT DATE_FORMAT(g.created, '%d. %m. %Y') AS 'created-date', g.*, DATE_FORMAT(ge.`edit-date`, '%d. %m. %Y') AS 'edit-date', ge.`edited-by`, u.name AS 'uname', u.surname AS 'usurname' FROM diagenkri.graph g LEFT JOIN
                                            ( SELECT * FROM `graph-edits` WHERE `edit-date` IN (SELECT max(`edit-date`) FROM `graph-edits`
                                            GROUP BY `graph-id`) ) AS ge ON g.id = ge.`graph-id`
                                            LEFT JOIN user u ON u.`e-mail`=g.`e-mail`;");

            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $err){
            return 0;
        }

        return $result;
    }
    
    public static function makeProfile($email, $fow){
        $db = DBconnect::getInstance();

        $dostop = date("Y-m-d H:i:s");

        $statement = $db->prepare("INSERT INTO diagenkri.user_profile (`e-mail`, lastaccess, fieldofwork)
            VALUES (:email, :dostop, :fow)");
        $statement->bindParam(":email", $email);
        $statement->bindParam(":dostop", $dostop);
        $statement->bindParam(":fow", $fow);
        $statement->execute();
    }

    public static function insert($name, $surname, $email, $password, $fow) {
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

            self::makeProfile($email, $fow);

            $key = self::activationCode($email);
            return $key;
        }
        else{
            return false;
        }
    }

    public static function saveProfileChanges($email, $name, $surname, $fow){
        $db = DBconnect::getInstance();

        $updateActive = $db->prepare("UPDATE diagenkri.user SET name = :name, surname = :surname WHERE `e-mail` = :email");
        $updateActive->bindParam(":name", $name);
        $updateActive->bindParam(":surname", $surname);
        $updateActive->bindParam(":email", $email);

        $res = $updateActive->execute();
        if($res){
            $updateActive = $db->prepare("UPDATE diagenkri.user_profile SET fieldofwork = :fow WHERE `e-mail` = :email");
            $updateActive->bindParam(":fow", $fow);
            $updateActive->bindParam(":email", $email);

            $res = $updateActive->execute();
            if($res){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public static function activationCode($email){
        $db = DBconnect::getInstance();
        $check = $db->prepare("SELECT COUNT(id) AS id FROM diagenkri.user WHERE `e-mail` = :email");
        $check->bindParam(":email", $email);
        $check->execute();
        $anwser = $check->fetch(PDO::FETCH_NUM);
        if($anwser[0] == 1){
            $check = $db->prepare("SELECT COUNT(id) AS id FROM diagenkri.user_confirm WHERE `mail` = :email");
            $check->bindParam(":email", $email);
            $check->execute();
            $anwser = $check->fetch(PDO::FETCH_NUM);
            if($anwser[0] === '0'){
                $key = $email . date("Y-m-d H:i:s") . random_int(1, 10000);
                $key = md5($key);

                $statement = $db->prepare("INSERT INTO diagenkri.user_confirm (`mail`, code)
                VALUES (:email, :code)");
                $statement->bindParam(":email", $email);
                $statement->bindParam(":code", $key);
                $success = $statement->execute();
                if($success){
                    return $key;
                }else{
                    return 0;
                }

            }
            else{
                $key = $email . date("Y-m-d H:i:s") . random_int(1, 10000);
                $key = md5($key);
                $update = $db->prepare("UPDATE diagenkri.user_confirm SET code=:code WHERE `mail`=:email ");
                $update->bindParam(":email", $email);
                $update->bindParam(":code", $key);
                $success = $update->execute();
                if($success){
                    return $key;
                }else{
                    return 0;
                }
            }
        }

    }

    public static function confirmActivation($email, $key){
        $db = DBconnect::getInstance();

        $statement = $db->prepare("SELECT diagenkri.user_confirm.code AS code
                                              FROM diagenkri.user_confirm WHERE diagenkri.user_confirm.mail= :email");
        $statement->bindParam(":email", $email);
        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_NUM);


        if($result[0] === $key){
            $updateActive = $db->prepare("UPDATE diagenkri.user SET active = :active WHERE `e-mail` = :email");
            $updateActive->bindParam(":active", $active);
            $updateActive->bindParam(":email", $email);

            $active = 1;

            $updateActive->execute();

            $delete = $db->prepare("DELETE FROM diagenkri.user_confirm WHERE mail = :email;");
            $delete->bindParam(":email", $email);
            $result = $delete->execute();

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
            $checkPass = $db->prepare("SELECT password, active FROM diagenkri.user WHERE `e-mail` = :email");
            $checkPass->bindParam(":email", $eposta);
            $checkPass->execute();
            $result = $checkPass->fetch(PDO::FETCH_NUM);
            $preveri = password_verify($geslo, $result[0]);
            if($preveri && $result[1] === '1'){
                $updateAccess = $db->prepare("UPDATE diagenkri.user_profile SET `lastaccess` = :time WHERE `e-mail` = :email");
                $updateAccess->bindParam(":time", $date);
                $updateAccess->bindParam(":email", $eposta);
                $date = date("Y-m-d H:i:s");
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

    public static function getCurations(){

        $db = DBconnect::getInstance();

        $statement = $db->prepare("
          SELECT diagenkri.user.name, diagenkri.user.surname, g.name AS 'graph-name', DATE_FORMAT(gc.`request-date`, '%d. %m. %Y') AS 'formated-date', gc.status, gc.id, gc.`graph-id`, gc.`curated-by`, gc.`requested-by`
          FROM diagenkri.`user`
              RIGHT JOIN diagenkri.graph g ON
                  diagenkri.`user`.`e-mail`=g.`e-mail`
              RIGHT JOIN diagenkri.`graph-curation` gc ON
                  g.`id`=gc.`graph-id` ORDER BY gc.`request-date` DESC;");

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function curationsCount(){

        $db = DBconnect::getInstance();

        $statement = $db->prepare("SELECT COUNT(id) AS id FROM diagenkri.`graph-curation` WHERE diagenkri.`graph-curation`.status=:status;");

        $statement->bindParam(":status", $status);

        $status = 0;

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_NUM);

        return $result;
    }

    public static function updateCuration($id, $status, $curator){
        $db = DBconnect::getInstance();

        $statement = $db->prepare("UPDATE diagenkri.`graph-curation` SET status = :status, `curated-by` = :curatedby
                                             WHERE id = :id");
        $statement->bindParam(":status", $status);
        $statement->bindParam(":curatedby", $curator);
        $statement->bindParam(":id", $id);

        $result = $statement->execute();

        if($status === '1' || $status === 1){

            $gidstm = $db->prepare("SELECT `graph-id` FROM diagenkri.`graph-curation`
                                              WHERE id = :id");

            $gidstm->bindParam(":id", $id);

            $gidstm->execute();

            $resultId = $gidstm->fetch(PDO::FETCH_NUM);

            $statement1 = $db->prepare("UPDATE diagenkri.graph SET curated = :curated
                                             WHERE id = :id");
            $statement1->bindParam(":curated", $curated);
            $statement1->bindParam(":id", $gid);

            $curated = 1;

            $gid = $resultId;

            $result1 = $statement1->execute();

            return $result1;
        }

        return $result;
    }

}