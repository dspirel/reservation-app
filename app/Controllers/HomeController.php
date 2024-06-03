<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use DateInterval;
use DateTime;

class HomeController extends Controller
{
    public function home() 
    {   
        $data = [];
        if (!empty($_GET["dpicker"])) {
            $date = $_GET["dpicker"];
            //validation
            if (strlen($date) == 10 && strpos($date, "-") == 4 &&  strrpos($date, "-") == 7 ) {
                $model = new ReservationModel();
                $data = $model->getReservations($date);
                $data = $this->getTimeEnd($data);
            }
        }

        $this->render("home", $data);
    }

    public function showError() {
        $this->render("show-error");
    }

    private function getTimeEnd($data){
        foreach ($data as $k => $r) {
            $dt = DateTime::createFromFormat("H:i:s", $r["time_start"]);
            $dt->add(DateInterval::createFromDateString($r["duration"] . "minutes"));
            $data[$k]["time_end"] = $dt->format("H:i:s");
        }
        return $data;
    }
}