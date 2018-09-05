<?php

$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();
}
/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 8. 05. 2018
 * Time: 16:41
 */

require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

class Visualisation extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/index', ['name' => $user->name]);
    }

    public function editor($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/editor', ['name' => $user->name]);
    }

    public function viewonly($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/view', ['name' => $user->name]);
    }


    public function delete() {
        $result = 0;
        if(isset($_SESSION["user"]) && isset($_POST["id"]))
            $result = DBfunctions::deleteGraph($_SESSION["user"], $_POST['id']);
        
        echo $result;
    }


    public function edit(){
        if(isset($_SESSION["user"]) && isset($_POST["data"]) && isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["access"]) && isset($_POST["gtype"]) && isset($_POST["atype"]) && isset($_POST["id"]) && isset($_POST["curation"])){


            DBfunctions::editGraph($_SESSION["user"], $_POST["data"], $_POST["name"], $_POST["description"], $_POST["access"], $_POST["gtype"], $_POST["atype"],
                $_POST["id"]);

            if($_POST["curation"] === "1"){

                $res = DBfunctions::createCurationRequest($_POST["id"], $_SESSION["user"]);
                echo json_encode($res);
            }
        }
    }

    public function load(){
        // echo "hello world";
        $result = DBfunctions::loadGraph($_POST['id']);
        // echo "<pre>";
        // var_dump("result:", $result);
        // exit();

        echo json_encode($result);
    }

    public function save(){

        //var_dump($_POST);

        if(isset($_SESSION["user"]) && isset($_POST["data"]) && isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["access"]) && isset($_POST["gtype"]) && isset($_POST["atype"]) && isset($_POST["curation"])){


            $graphId = DBfunctions::saveGraph($_SESSION["user"], $_POST["data"], $_POST["name"], $_POST["description"], $_POST["access"], $_POST["gtype"], $_POST["atype"]);

            if($_POST["curation"] === "1"){

                $res = DBfunctions::createCurationRequest($graphId, $_SESSION["user"]);
                echo json_encode($res);
            }
            // ViewHelper::redirect('../../public/visualisation/gallery');
        }
        else{
            // TO DO
        }



    }

    public function diagnosis(){
        $this->view('visualisation/diagnosis');
    }

    public function gallery($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/gallery', ['name' => $user->name]);
    }

    public function curationsUpdate(){
        $count = DBfunctions::curationsCount();

        echo json_encode($count);
    }

    public function curations(){
        $this->view('visualisation/curations');
    }

    public function curate(){
        if(isset($_SESSION["user"]) && isset($_POST["id"]) && isset($_POST["algName"]) && isset($_POST["result"]) && isset($_POST["explanation"]) && isset($_POST["author"]) && isset($_POST["curatorMail"]) && isset($_POST["curatorFullName"])){
            $result = DBfunctions::updateCuration($_POST["id"], $_POST["result"], $_POST["curatorMail"]);

            if($result){
                $result = $this->sendMail($_POST["author"], $_POST["id"], $_POST["explanation"], $_POST["result"], $_POST["curatorMail"], $_POST["curatorFullName"], $_POST["algName"]);
                // echo json_encode($result);
                // var_dump($_POST["author"], $_POST["id"], $_POST["explanation"], $_POST["result"], $_POST["curatorMail"], $_POST["curatorFullName"], $_POST["algName"]);
                echo $result;
                return;
            }
            echo "update failure " . $result;
            // echo json_encode('update failure: ' . $result);
            return;
        }
        echo "not all data received!";
        // echo json_encode('Not all data received!');
        return;
    }

    public function sendMail($receiver, $id, $explanation, $decision, $curatorMail, $curatorFullName, $algName){
        $stat = "";
        if($decision == 1){
            $decision = 'We gladly inform you that the request was successfully approved!';
            $stat = 'approved';
        }else{
            $decision = 'Unfortunately, we must inform you that the request was rejected.';
            $stat = 'rejected';
        }

        $to      = $receiver; // Send email to our user
        $subject = 'Algorithm curation response for: ' . $algName; // Give the email a subject
        $message = '
 
Thank you for submitting this curation request!

Your curation request has now been processed. ' . $decision . '

-----------------------------
CURATION DETAILS

Request ID: ' . $id . '
Status: ' . $stat . '
Curator: ' . $curatorFullName . '
Curator\'s contact address: ' . $curatorMail . '
Explanation provided by the curator:

' . $explanation . '

-----------------------------

If this action was not done by you, please ignore and delete this message.

Please do not respond to this email address.

Your ViDis team
 
';

        $headers = 'From:support@vidis.fri.uni-lj.si' . "\r\n"; // Set from headers
        $response = mail($to, $subject, $message, $headers); // Send our email
        return $response;
    }

}