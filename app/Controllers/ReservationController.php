<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use DateTime;
use DateInterval;

class ReservationController extends Controller
{   
    private ReservationModel $rmodel;

    public function __construct()
    {
        $this->rmodel = new ReservationModel;
    }

    public function showReservationForm() 
    {   
        $this->render("add-reservation");    
    }

    public function addReservation()
    {
        $validation = $this->validateInput($_POST);
        //$validation[bool,data]
        if ($validation[0]) {
            $data = $validation[1];
            //remove time from DateTime
            $data["date_start"] = $data["date_start"]->format("Y-m-d");
            $this->rmodel->addNewReservation($data);
            $this->redirect("/");
        } else {
            $this->render("add-reservation", $validation[1]);
        }
    }

    public function updateReservation()
    {
        //$validation[bool,data]
        $validation = $this->validateInput($_POST);
        if ($validation[0]) {
            //$model = new ReservationModel();
            $data = $validation[1];
            //remove time from DateTime
            $data["date_start"] = $data["date_start"]->format("Y-m-d");
            $this->rmodel->updateReservation($data);
            $this->redirect("/");
        } else {
            //render with errors
            $this->render("edit-reservation", $validation[1]);
        }
    }

    public function showEditReservationForm()
    {
        //get url param
        $url_components = parse_url($_SERVER["REQUEST_URI"]);
        parse_str($url_components["query"], $params);

        $reservation = $this->rmodel->getReservationById($params["rid"]);
        $_SESSION["reservation_edit"] = $reservation[0];
        $this->render("edit-reservation");
    }

    private function validateInput($data) {
        $inputErrors = [];
        //last_name
        if (empty($data["last_name"]) || !preg_match("/^[- '\p{L}]+$/u", $data["last_name"])) {
            $inputErrors["last_name"] = "Please enter a valid name. 3-50 alphabetic characters.";
        }
    
        //contact info
        if (empty($data["contact_info"]) || !ctype_digit($data["contact_info"]) || strlen($data["contact_info"]) < 8){
            $inputErrors["contact_info"] = "Please enter a valid phone number.";
        }
    
        //date-start
        $data["date_start"] = DateTime::createFromFormat('Y-m-d', $data["date_start"]);//->format('d-m-Y');//date("d.m.y", strtotime($data["date-start"]));
        $current_date =  DateTime::createFromFormat('Y-m-d', date('Y-m-d'));
        $date_difference = date_diff($current_date, $data["date_start"]);
    
        if (empty($data["date_start"]) || $date_difference->invert == 1){
            $inputErrors["date_start"] = "Please enter correct date.";
        }
    
        //time
        if (empty($data["time_start"])) $inputErrors["time_start"] = "Please enter time.";
        //check if time less than 09:00
        $hours = intval(substr($data["time_start"], 0, 2));
        $minutes = intval(substr($data["time_start"], 3, 2));
        if ($hours < 9) $inputErrors["time_start"] = "Please enter a time after 09:00.";
        //check if time more than 22:00
        if ($hours > 21) $inputErrors["time_start"] = "Please enter a time before 22:00.";
    
        //duration in minutes
        if (empty($data["duration"])) $inputErrors["duration"] = "Please enter a duration.";
        //length
        if ($data["duration"] < 30) $inputErrors["duration"] = "Minimum duration 30.";
        if ($data["duration"] > 120) $inputErrors["duration"] = "Maximum duration 120.";
    
        //group size
        if (empty($data["group_size"])) $inputErrors["group_size"] = "Please enter a group size.";
        if ($data["group_size"] < 1) $inputErrors["group_size"] = "Minimum size 1.";
        if ($data["group_size"] > 40) $inputErrors["group_size"] = "Maximum size 40.";
    
        //check if data ok
        if (empty($inputErrors)) {
            return [true, $data];
        } else {
            return [false, $inputErrors];
        }
    }
}